<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = User::with('posts.comments', 'experience')->where('id', auth()->user()->id)->first();
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/includes/country.json')));
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function submitProfile(Request $request)
    {
        $countryData = (array)json_decode(file_get_contents(resource_path('views/includes/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes = implode(',', array_column($countryData, 'dial_code'));
        $countries = implode(',', array_column($countryData, 'country'));
        // dd($request->all());
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'mobile_code' => 'required|in:' . $mobileCodes,
            'country_code' => 'required|in:' . $countryCodes,
            'country' => 'required|in:' . $countries,
            'mobile' => 'required|regex:/^([0-9]*)$/',
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required' => 'Last name field is required'
        ]);

        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();

        if ($request->hasFile('image')) {
            $old = $user->image;
            $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->country_code = $request->country_code;
        $user->mobile = $request->mobile_code.$request->mobile;

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->social_link = [
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
        ];
        $user->skills = json_encode($request->skills, true);


        $user->save();
        $notify[] = ['success', 'Profile has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();
        return view($this->activeTemplate . 'user.password', compact('pageTitle', 'user'));
    }

    public function experience()
    {
        $pageTitle = 'Experience';
        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();
        return view($this->activeTemplate . 'user.experience.index', compact('pageTitle', 'user'));
    }


    public function experienceStore(Request $request)
    {
        $pageTitle = 'Experience';
        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();
        $request->validate([
            'title' => 'required|string',
            'company_name' => 'required|string',
            'curr_working' => 'string',
            'start_date' => 'required|string',
            'end_date' => 'required_unless:curr_working,on',
            'location' => 'string',
            'responsibility' => 'required|string',
        ]);

        $experience = new Experience();
        $experience->user_id = auth()->id();
        $experience->title = $request->title;
        $experience->company_name = $request->company_name;
        $experience->start_date = $request->start_date;
        $experience->currently_working = $request->curr_working ?? 'off';
        $experience->end_date = $request->end_date;
        $experience->location = $request->location;
        $experience->responsibility = $request->responsibility;
        $experience->save();
        $notify[] = ['success', 'Experience create successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function experienceEdit(Experience $experience)
    {
        $pageTitle = 'Edit Experience';
        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();
        return view($this->activeTemplate . 'user.experience.edit', compact('pageTitle', 'user', 'experience'));
    }

    public function experienceUpdate(Request $request, $id)
    {
        $pageTitle = 'experience Update';
        $request->validate([
            'title' => 'required|string',
            'company_name' => 'required|string',
            'curr_working' => 'string',
            'start_date' => 'required|string',
            'end_date' => 'required_unless:curr_working,on',
            'location' => 'string',
            'responsibility' => 'required|string',
        ]);

        $experience = Experience::findOrFail($id);
        $experience->user_id = auth()->id();
        $experience->title = $request->title;
        $experience->company_name = $request->company_name;
        $experience->start_date = $request->start_date;
        $experience->currently_working = $request->curr_working ?? 'off';
        $experience->end_date = $request->end_date;
        $experience->location = $request->location;
        $experience->responsibility = $request->responsibility;
        $experience->save();
        $notify[] = ['success', 'Experience updated successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function experienceDelete($id)
    {
        try {
            $experience = Experience::findOrFail($id);
            $experience->delete();
            $notify[] = ['success', 'Experience delete successfully'];
            return redirect()->back()->withNotify($notify);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Couldn\'t delete the experience'];
            return back()->withNotify($notify);
        }
    }


    public function profileImageUpdate(Request $request)
    {
        // Validate the image file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();
        $notify[] = ['success', 'Profile has been updated successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        $general = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }
}

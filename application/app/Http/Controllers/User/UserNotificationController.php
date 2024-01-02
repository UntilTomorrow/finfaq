<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;

class UserNotificationController extends Controller
{
    public function index(){
        $pageTitle = 'Notification';
        $user = User::where('id',auth()->user()->id)->with('posts.comments')->first();
        $notifications = UserNotification::where('user_to',auth()->id())->paginate(getpaginate(30));
        return view($this->activeTemplate . 'user.notification.notification', compact('pageTitle','user','notifications'));
    }

    public function read_status($id){
        $pageTitle = 'Notification Read';
        $userNotification = UserNotification::where('id',$id)->first();
        $userNotification->read_status = 1;
        $userNotification->save();
        $notify[] = ['success', 'Notification delete successfully'];
        return redirect($userNotification->click_url);

    }

    public function delete($id){

        $pageTitle = 'Notification Delete';
        $userNotification = UserNotification::where('id',$id)->first();
        $userNotification->delete();
        $notify[] = ['success', 'Notification delete successfully'];
        return back()->withNotify($notify);
    }

}

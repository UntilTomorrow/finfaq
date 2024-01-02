<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{

    public function index(Request $request)
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';

        $posts = Post::with('user', 'comments', 'votes', 'bookmarks')->where('status', 1)->orderBy('id','desc')->paginate(getPaginate());
        $categories = Category::where('status',1)->get();
       
        if ($request->ajax()) {

            $view = view($this->activeTemplate . 'components.main', compact('posts','categories'))->render();
            return response()->json(['html' => $view]);

        };
        return view($this->activeTemplate . 'home', compact('posts', 'pageTitle','categories'));
    }

    public function textPost()
    {
        $pageTitle = 'Add Post';
        $categories = Category::where('status',1)->get();
        return view($this->activeTemplate . 'add-post', compact('pageTitle', 'categories'));
    }

    public function addJobPost()
    {
        $pageTitle = 'Job Post';
        return view($this->activeTemplate . 'job-post', compact('pageTitle'));
    }

    public function savePost(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('user.login');
        }
        $pageTitle = 'Saved Post';
        $posts = Post::with(['user', 'comments', 'votes','bookmarks'])->where('status', 1)->whereHas('bookmarks', function ($q) {
            $q->where('user_id', auth()->user()->id)->where('type', auth()->user()->type);
        })->paginate(getPaginate());

        if ($request->ajax()) {
            $view = view($this->activeTemplate . 'components.main', compact('posts', 'pageTitle'))->render();
            return response()->json(['html' => $view]);
        }
        return view($this->activeTemplate . 'save-post', compact('pageTitle', 'posts'));
    }

    public function postDetails($id)
    {
        $pageTitle = 'Post Details';
        $post = Post::with(['user', 'comments', 'comments.votes', 'comments.user', 'votes', 'bookmarks','images'])->findOrFail($id);
        $post->views = $post->views + 1;
        $post->save();
        return view($this->activeTemplate . 'post-details', compact('pageTitle', 'post'));
    }

    public function user_profile(Request $request, $id)
    {
        $pageTitle = '';
        $user = User::where('id',$id)->with('posts.comments')->first();
        $chat = Chat::with('receiver')->where('sender_id',auth()->id())->where('receiver_id',$id)->orWhere('receiver_id',auth()->id())->orWhere('sender_id',$id)->orderBy('created_at','asc')->get();
        
        $posts = Post::where('user_id', $user->id)->where('status', 1)->with('user', 'comments', 'votes', 'bookmarks')->paginate(getPaginate());
        if ($request->ajax()) {
            $view = view($this->activeTemplate . 'components.main', compact('posts', 'pageTitle', 'user','chat'))->render();
            return response()->json(['html' => $view]);
        }
        return view($this->activeTemplate . 'profile-details', compact('pageTitle', 'user', 'posts','chat'));
    }

    public function popularPost(Request $request)
    {
        $pageTitle = 'Popular post';
        $posts = Post::where('status', 1)->with(['user', 'comments.user', 'votes', 'bookmarks'])->orderBy('views', 'desc')->take(100)->paginate(getPaginate());
        $categories = Category::where('status',1)->get();
        if ($request->ajax()) {
            $view = view($this->activeTemplate . 'components.main', compact('posts','categories', 'pageTitle'))->render();
            return response()->json(['html' => $view]);
        }
        return view($this->activeTemplate . 'home', compact('pageTitle', 'posts','categories'));
    }

    public function jobPost(Request $request)
    {
        $pageTitle = 'Job post';
        $categories = Category::where('status',1)->get();
        $posts = Post::where('status', 1)->where('job', 1)->with('user', 'comments', 'votes', 'bookmarks')->orderBy('id','desc')->paginate(getPaginate());
        
        if ($request->ajax()) {
            $view = view($this->activeTemplate . 'components.main', compact('posts','categories', 'pageTitle'))->render();
            return response()->json(['html' => $view]);
        }
        return view($this->activeTemplate . 'home', compact('pageTitle', 'posts','categories'));
    }

    public function categoryPost(Request $request, $category_name, $id)
    {
        $pageTitle = $category_name . ' ' . 'post';
        $posts = Post::where('category_id', $id)->where('status', 1)->with('user', 'comments', 'votes','bookmarks')->paginate(getPaginate());
        if ($request->ajax()) {
            $view = view($this->activeTemplate . 'components.main', compact('posts', 'pageTitle'))->render();
            return response()->json(['html' => $view]);
        }
        return view($this->activeTemplate . 'category', compact('pageTitle','posts'));
    }


    public function profile()
    {
        $pageTitle = 'Profile';
        return view($this->activeTemplate . 'profile-details', compact('pageTitle'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = '';
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle'));
    }


    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie-Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}

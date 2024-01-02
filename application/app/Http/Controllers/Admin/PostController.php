<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function pending()
    {
        $pageTitle = 'Pending Posts';
        $posts = $this->postData('text','pending');
        return view('admin.posts.list', compact('pageTitle', 'posts'));
    }


    public function active()
    {
        $pageTitle = 'Active Posts';
        $posts = $this->postData('text','active');
        return view('admin.posts.list', compact('pageTitle', 'posts'));
    }


    public function rejected()
    {
        $pageTitle = 'Rejected Posts';
        $posts = $this->postData('text','rejected');
        return view('admin.posts.list', compact('pageTitle', 'posts'));
    }
    public function deletePost($id)
    {
        $post = Post::find($id);
        $images = PostImage::wherePostId($post->id)->get();
        if($images){
            foreach($images as $image){
                fileManager()->removeFile(getFilePath('posts') . $image->path . $image->image);
            }
        }
        $post->images()->delete();
        $post->comments()->delete();
        $post->bookmarks()->delete();
        $post->delete();
        $notify[] = ['success', 'Post Deleted'];
        return redirect()->back()->withNotify($notify);
    }

    public function posts()
    {
        $pageTitle = 'All Posts';
        $emptyMessage = "No data found";
        $posts = $this->postData('text');
        return view('admin.posts.list', compact('pageTitle', 'posts', 'emptyMessage'));
    }

    public function job_post_list()
    {
        $pageTitle = 'All Job Posts';
        $emptyMessage = "No data found";
        $posts = $this->postData('job');
        return view('admin.posts.job_list', compact('pageTitle', 'posts', 'emptyMessage'));
    }

    protected function postData($type = null, $scope = null)
    {
        if ($scope) {
            $posts = Post::$scope();
        } else {
            $posts = Post::query();
        }

        //search
        $request = request();
        if ($request->search) {
            $search = $request->search;
            $posts  = $posts->where($type , 1)->where(function ($post) use ($search) {
                $post->where('title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%");
            });
        }
        
        return $posts->with('user','category','apply_job')->where($type,1)->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function details($id)
    {
        $general = gs();
        $post = Post::where('id', $id)->with(['user','category'])->firstOrFail();
        $latestPosts = Post::latest()->take(10)->get();
        $pageTitle = 'Post Details';
        return view('admin.posts.detail', compact('pageTitle', 'post','general','latestPosts'));
    }


}

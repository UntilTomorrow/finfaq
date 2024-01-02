<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\PostCommentReport;
use App\Http\Controllers\Controller;

class PostCommentController extends Controller
{
    public function postCommentReports()
    {
        $pageTitle = 'Flags';
        $emptyMessage = "No data found";
        $data = PostCommentReport::with(['post.category', 'comment'])->paginate(getPaginate());
        return view('admin.post_comment_reports.list', compact('pageTitle', 'data', 'emptyMessage'));
    }
    public function postCommentReportsStatus(Request $request)
    {
        $data = PostCommentReport::where('id', $request->id)->first();
        $data->status = $this->statusCheck($data);
        if ($data->type == "post") {
            $post = Post::where("id", $data->post_id)->first();
            $post->status = $this->statusCheck($post);
            return response()->json(
                $data = [
                    'status' => "success",
                    'message' => "Post status updated"
                ],
            );
        } else {
            if ($data->comment_id) {
                $comment = Comment::where("id", $data->comment_id)->first();
                $comment->status = $this->statusCheck($comment);
                return response()->json(
                    $data = [
                        'status' => "success",
                        'message' => "Comment status updated"
                    ],
                );
            }
            return response()->json(
                $data = [
                    'status' => "error",
                    'message' => "This property does't exist."
                ],
            );
        }
    }

    private function  statusCheck($data)
    {
        if ($data->status === 1) {
            $data->status = 0;
            $data->save();
        } elseif ($data->status === 0) {
            $data->status = 1;
            $data->save();
        }
        return $data;
    }
}

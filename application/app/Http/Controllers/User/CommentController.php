<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentVote;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\PostCommentReport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function comment_create(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'post_id' => 'required|numeric',
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $comment = Comment::create([
                'user_id' => auth()->id(),
                'post_id' => $request->post_id,
                'type' => 'user',
                'status' => 1,
                'comment' => $request->comment,
                'parent_comment_id' => $request->parent_comment_id
            ]);

            $post = Post::with('user')->where('id', $request->post_id)->first();
            
            // User notification
            $userNotification = new UserNotification();
            $userNotification->user_from = auth()->id();
            $userNotification->user_to = $post->user->id;
            $userNotification->title = auth()->user()->fullname . ' commented on your post ' . $post->title;
            $userNotification->read_status = 0;
            $userNotification->type = 'comment';
            $userNotification->click_url = url('/') . '/post-details/' . $post->id;
            $userNotification->save();           
            
            $data = [
                'status' => "success",
                'message' => "",
                'commentCount' => Comment::where('post_id', $request->post_id)->count(),
                'comment' => $comment->id,
                'html' => view('presets/default/components/comment', [
                    'single_comment' => $comment,
                ])->render()

            ];
            // dd($data);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($data);
        }
    }
    public function comment_reply(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'post_id' => 'required|numeric',
                'comment_id' => 'required|numeric',
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }
            $comment = Comment::create([
                'user_id' => auth()->id(),
                'post_id' => $request->post_id,
                'type' => 'user',
                'status' => 1,
                'comment' => $request->comment,
                'parent_comment_id' => $request->comment_id
            ]);


            $commentNotify = Comment::with('user')->where('id', $request->comment_id)->first();
            $post = Post::with('user')->where('id', $request->post_id)->first();

            // User notification
            $userNotification = new UserNotification();
            $userNotification->user_from = auth()->id();
            $userNotification->user_to = $commentNotify->user->id;
            $userNotification->title = auth()->user()->fullname . ' reply commented on your comment ' . $commentNotify->comment;
            $userNotification->read_status = 0;
            $userNotification->type = 'comment-reply';
            $userNotification->click_url = url('/') . '/post-details/' . $post->id;
            $userNotification->save();

            $data = [
                'status' => "success",
                'message' => "",
                'comment' => $comment,
                'html' => view('presets/default/components/comment', [
                    'single_comment' => $comment,
                ])->render()

            ];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($data);
        }
    }

    public function comment_edit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment_id' => 'required|numeric',
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $comment = Comment::find($request->comment_id);

            $comment->update([
                'comment' => $request->comment,
            ]);
            $data = [
                'status' => "success",
                'message' => "",
                'comment' => $comment
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function comment_delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'post_id' => 'required|numeric',
                'comment_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $comment = Comment::with('comments')->where('id', $request->comment_id)->where('post_id', $request->post_id)->where('user_id', auth()->id())->where('type', auth()->user()->type)->first();

            $commentDeleteCount = $comment->deleteComments($comment) + 1;
            $comment->delete();
            $comment->votes->each->delete();
            $data = [
                'status' => "success",
                'message' => "",
                'commentDeleteCount' => $commentDeleteCount
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function comment_vote(Request $request)
    {
        $data =  $request->validate([
            'comment_id' => 'required|numeric',
            'vote' => 'required|in:1,0',
        ]);

        $comment_vote = new CommentVote();
        $post = Post::where('id', $request->post_id)->with('user')->first();
        $exist_vote =  $comment_vote->where('comment_id', $request->comment_id)->where('user_id', auth()->user()->id)->where('type', auth()->user()->type)->first();

        $comment = Comment::where('id', $request->comment_id)->first();
        
        // User notification
        $userNotification = new UserNotification();
        $userNotification->user_from = auth()->id();
        $userNotification->user_to = $comment->user_id;
        $userNotification->title = (!$exist_vote) ? auth()->user()->fullname. ' like your comment ' .$comment->comment : auth()->user()->fullname. ' Unlike your post ' .$comment->comment;
        $userNotification->read_status = 0;
        $userNotification->type = 'comment-vote';
        $userNotification->click_url = url('/') . '/post-details/' . $comment->post_id;
        $userNotification->save();

        if (!$exist_vote) {
            $comment_vote->comment_id = $request->comment_id;
            $comment_vote->user_id = auth()->user()->id;
            $comment_vote->type = auth()->user()->type;
            if ($request->vote == 1) {
                $comment_vote->like = 1;
            } else {
                $comment_vote->unlike = 1;
            }
            $comment_vote->save();
            $data = $this->total_like_unlike_comment_count($comment_vote, $request);
            return response()->json($data);
        } else {
            if ($exist_vote->like == 1 && $request->vote == 1) {
                $exist_vote->delete();
                $data = $this->total_like_unlike_comment_count($comment_vote, $request);
                return response()->json($data);
            }

            if ($exist_vote->like == 1 && $request->vote == 0) {
                $exist_vote->like = 0;
                $exist_vote->unlike = 1;
                $exist_vote->save();
                $data = $this->total_like_unlike_comment_count($comment_vote, $request);
                return response()->json($data);
            }

            if ($exist_vote->unlike == 1 && $request->vote == 0) {
                $exist_vote->delete();
                $data = $this->total_like_unlike_comment_count($comment_vote, $request);
                return response()->json($data);
            }

            if ($exist_vote->unlike == 1 && $request->vote == 1) {
                $exist_vote->like = 1;
                $exist_vote->unlike = 0;
                $exist_vote->save();

                $data = $this->total_like_unlike_comment_count($comment_vote, $request);
                return response()->json($data);
            }
        }
    }

    public function comment_report(Request $request)
    {
       
        $request->validate([
            'post_id' => 'required|numeric',
            'comment_id' => 'required|numeric',
            'reason' => 'required|string',
        ]);
        $comment_report = new PostCommentReport();

        $exist_comment_report = $comment_report->where('comment_report_user', auth()->user()->id)->where('type', 'comment')->where('post_id', $request->post_id)->where('comment_id', $request->comment_id)->first();

        if ($exist_comment_report) {
            $data = [
                'status' => "error",
                'message' => "You are already report this comment",
            ];
            return response()->json($data);
        }

        $comment = Comment::where('id', $request->comment_id)->first();

        
        // User notification
        $userNotification = new UserNotification();
        $userNotification->user_from = auth()->id();
        $userNotification->user_to = $comment->user_id;
        $userNotification->title = auth()->user()->fullname. ' report your comment ' .$comment->comment;
        $userNotification->read_status = 0;
        $userNotification->type = 'comment-report';
        $userNotification->click_url = url('/') . '/post-details/' . $comment->post_id;
        $userNotification->save();


        $comment_report->post_id = $request->post_id;
        $comment_report->comment_id = $request->comment_id;
        $comment_report->user_id = $comment->user->id;
        $comment_report->type = 'comment';
        $comment_report->comment_report_user = auth()->user()->id;
        $comment_report->reason =  $request->reason;
        $comment_report->save();

        $data = [
            'status' => "success",
            'message' => "Reported successfully",
        ];
        return response()->json($data);
    }


    private function total_like_unlike_comment_count($comment_vote, $request)
    {
        $total_like = $comment_vote->where('comment_id', $request->comment_id)->where('like', 1)->count();
        $total_unlike = $comment_vote->where('comment_id', $request->comment_id)->where('unlike', 1)->count();
        return number_format_short($total_like - $total_unlike);
    }

}

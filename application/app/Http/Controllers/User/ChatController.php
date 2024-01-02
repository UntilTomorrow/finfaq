<?php

namespace App\Http\Controllers\User;

use Pusher\Pusher;
use App\Events\Chat;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Models\UserNotification;
use App\Models\Chat as ModalChat;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "receiver_id" => "required|numeric",
            "message" => "required_if:file,null",
            'file' => ['nullable', 'file', new FileTypeValidate(['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'])]
        ]);

        $chat =  new ModalChat();
        $chat->sender_id = auth()->id();
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        if ($request->hasFile('file')) {
            try {
                $filename       = fileUploader($request->file, getFilePath('chatFiles'));
                $chat->file    = $filename;
            } catch (\Exception $exp) {
                $notify[]       = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $chat->save();


        // User notification
        $userNotification = new UserNotification();
        $userNotification->user_from = auth()->id();
        $userNotification->user_to = $chat->receiver_id;
        $userNotification->title = auth()->user()->fullname . ' message to you ' . $chat->message;
        $userNotification->read_status = 0;
        $userNotification->type = 'message';
        $userNotification->click_url = url('/') . '/user-profile/' . auth()->id();
        $userNotification->save();


        $options = [
            'cluster' => gs()->pusher_credential->app_cluster,
            'encrypted' => gs()->pusher_credential->useTLS
        ];

        $pusher = new Pusher(
            gs()->pusher_credential->app_key,
            gs()->pusher_credential->app_secret,
            gs()->pusher_credential->app_id,
            $options
        );

        $data = [
            'id' => $chat->id,
            'file' => $chat->file,
            'message' => $chat->message,
            'sender' => $chat->sender_id,
            'receiver' =>  $chat->receiver_id,
            'created_at' => $chat->created_at,
        ];

        $event_name = '' . $chat->receiver_id . '';
        $pusher->trigger($event_name, "App\\Events\\Chat", $data);
        return response()->json($data);
    }

    public function download_file($id)
    {
        $chat = ModalChat::where('id', $id)->first();
        $path = getFilePath('chatFiles') . '/' . $chat->file;
        if (file_exists($path)) {
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($path, $chat->file, $headers);
        }
        $notify[] = ['error', 'file is missing'];
        return back()->withNotify($notify);
    }
}

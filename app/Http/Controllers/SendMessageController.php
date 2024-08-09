<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Events\SendMessage;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    public function show_room($id) 
    {
        //update auth user status to be online 
        $update = User::find(auth()->user()->id)->update([
            'is_online'=>1
        ]);
        $user = User::findOrfail($id);

        //select room if there exist , if not create new one 
        $room = Chat::where([
            ['user_1',auth()->user()->id],
            ['user_2',$id]

            ])->orWhere([
                ['user_1',$id],
                ['user_2',auth()->user()->id]
            ])->first();
        if($room == null){
            $room = Chat::create([
                'user_1'=>auth()->user()->id,
                'user_2'=>$id
            ]);
        }

        return view('pages.messager',[
            'user'=>$user, 
            'room_id'=>$room->id,
            'messages'=>$room->messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        $fromId = auth()->user()->id;
        $toUserId = $request->touserId;
        $message = $request->message;
        $status = $request->status;
    
        $user = auth()->user()->name;
        $id = $request->roomid;
    
        $save_message = Message::create([
            'message'=>$message,
            'from_id'=>$fromId,
            'to_id'=>$toUserId,
            'chat_id'=>$id,
            'is_readed'=>$status,
        ]);
        event(new SendMessage($message,$user,$id,$fromId,$status));
        return null;
    }

    //update message status to => is_readed 
    public function read_all_messages(Request $request)
    {
        $to_id = $request->toId;
        $room_id = $request->roomId;
        $update = Message::where([
            ['chat_id',$room_id],
            ['from_id',auth()->user()->id],
            ['to_id',$to_id],
            ['is_readed',0],
        ])->update([
            'is_readed'=>1
        ]);
        return null;
    }
}

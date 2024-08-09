<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
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
}

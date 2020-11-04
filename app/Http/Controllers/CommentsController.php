<?php

namespace App\Http\Controllers;

use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
   public function cmntPosts(){

    $jsonBody = file_get_contents('php://input');
    $json = json_decode($jsonBody, true);

    $postId= $json['postId'];
    $text=$json['text'];
    $usId=Auth::id();
    $data_form=['post_id'=>$postId,
                'user_id'=>$usId,
                'cmnt_text'=>$text];

                comments::insert($data_form);
                
   }

   function cmntCount(Request $request){

    $post=$request->postId;
   $count= comments::where('post_id',$post)->count();
   
   return $count;
   }

   function cmntContent(Request $request){

    $post=$request->postId;
   $content= comments::where('post_id',$post)
   ->join('users','users.id','=','comments.user_id')
   ->select('comments.*','users.name')->get();
   
   return $content;
   }
}

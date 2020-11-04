<?php

namespace App\Http\Controllers;

use App\Models\likes;
use Illuminate\Cache\NullStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Output\NullOutput;

class LikesController extends Controller
{
    function likePost(Request $request){

        $postlike=$request->pstId;
        $usId=Auth::id();
       $check= Likes::select('id')->where('user_id',$usId)->where('post_id',$postlike)->count();
    
if($check===0){
        $data=['post_id'=>$postlike,
             'user_id'=>$usId];
        likes::insert($data);
    }else{
        likes::where('post_id',$postlike)->where('user_id',$usId)->delete();
    }
        return redirect('/feeds');
    }

    function likePostjs(){
        $jsonBody = file_get_contents('php://input');
        $json = json_decode($jsonBody, true);

        $postlike= $json['postId'];
       //dd($postlike);
        $usId=Auth::id();
       $check= Likes::select('id')->where('user_id',$usId)->where('post_id',$postlike)->count();
    
if($check===0){
        $data=['post_id'=>$postlike,
             'user_id'=>$usId];
        likes::insert($data);
    }else{
        likes::where('post_id',$postlike)->where('user_id',$usId)->delete();
    }
    
    }

    function likeCount(Request $request){

        $post=$request->postId;
       $count= likes::where('post_id',$post)->count();
       
       return $count;
       }
}

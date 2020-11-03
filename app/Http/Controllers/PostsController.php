<?php

namespace App\Http\Controllers;

use App\Models\posts;
use App\Models\users;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PostsController extends Controller
{
    public function showPosts(){

       $posts= DB::table('posts')->join('users','posts.user_id','=','users.id')->select('posts.*','users.id as uid','users.name')->latest()->get();
     //return $posts;
     return view('feed',compact('posts'));
    }

    public function delPosts(Request $request){
        
        $postdel=$request->pstId;
       
        posts::destroy($postdel);
       return redirect('/feeds');
     }
   
    public function addPosts(Request $request){

      $request->validate([
          'blog_text' =>'required',
         // 'pic_path' => 'required|image'
      ]);
      $image_file=$request->pic_path;

    //   $image=Image::make($image_file);
    //   Response::make($image->encode('jpeg'));
      $form_data=array(
          'user_id'=>Auth::id(),
          'blog_text'=>$request->blog_text,
          'pic_path'=>'pics/postPics/bg2.jpg'
      );
      posts::create($form_data);
     return redirect('/feeds');
     }

}

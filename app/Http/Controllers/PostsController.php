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
    public function showPosts(Request $request){
   $n=5;
     $inc=$request->seeMore;
      if($inc>0){
        $n+=10;
      }else{$n=5;}

       $posts= DB::table('posts')
       ->leftJoin('users','posts.user_id','=','users.id')
       ->leftJoin('likes','likes.post_id','=','posts.id')
      //  ->leftJoin('comments','comments.post_id','=','posts.id')
       ->select('posts.*','users.id as uid','users.name', 
                DB::raw("count(likes.post_id) as likenb"))
       ->groupBy('posts.id')
       ->latest()->paginate($n);
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
      if($request->file('imgg')!=null){
      $file_namewithExt= $request->file('imgg')->getClientOriginalName();

  $path=$request->file('imgg')->storeAs('/storage', $file_namewithExt);
      }else{$path='';}
      $form_data=array(
          'user_id'=>Auth::id(),
          'blog_text'=>$request->blog_text,
          'pic_path'=>$path
      );
      posts::create($form_data);
     return redirect('/feeds');
     }

     public function editText(Request $request){

          $user_id=Auth::id();
          $new_text=$request->new_text;
          $post_id=$request->post_id;
       
      
      posts::where('posts.id',$post_id)
      ->where('posts.user_id',$user_id)
      ->update(['blog_text'=>$new_text]);
     }

}

<?php

namespace App\Http\Controllers;

use App\Models\posts;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class PostsController extends Controller
{

  public function publicshowPosts(){
   
 
        $posts= DB::table('posts')
        ->leftJoin('users','posts.user_id','=','users.id')
        ->leftJoin('likes','likes.post_id','=','posts.id')
     
        ->select('posts.*','users.id as uid','users.name', 
                 DB::raw("count(likes.post_id) as likenb"))
        ->groupBy('posts.id')
        ->latest()->paginate(5);
    
      return view('welcome',compact('posts'));
     }

  public function showPosts(Request $request){
    
       $posts= DB::table('posts')
       ->leftJoin('users','posts.user_id','=','users.id')
       ->leftJoin('likes','likes.post_id','=','posts.id')
       ->select('posts.*','users.id as uid','users.name' 
                ,DB::raw("count(likes.post_id) as likenb")
                )
       ->groupBy('likes.post_id','posts.id')
       ->latest()->simplePaginate(2);
      
     return view('feed',compact('posts'));
    }

    public function showPost(Request $request){
    $id=$request->notId;
    DB::table('notifications')->where('id',$id)
    ->update(['read_at'=>now()]);
    $post_id=$request->post_id;
      $postt= Posts::where('posts.id','=',$post_id)
      ->leftJoin('users','posts.user_id','=','users.id')
      ->leftJoin('likes','likes.post_id','=','posts.id')
      ->select('posts.*','users.id as uid','users.name' 
               ,DB::raw("count(likes.post_id) as likenb")
               )
      ->groupBy('likes.post_id','posts.id')->get();
    // dd($post);
    return view('post',compact('postt'));
   }

  public function delPosts(Request $request){
    $imagepath='var/www/bloggApp/storage/app/'.$request->pic;
    if($imagepath!="var/www/bloggApp/storage/app/"){
     
    if(Storage::exists($imagepath)){
      
      Storage::delete($imagepath);
    }
  }
        $postdel=$request->pstId;
       
       posts::destroy($postdel);
       return redirect('/feeds');
     }
   
  public function addPosts(Request $request){

      $request->validate([
          'blog_text' =>'required',
          'pic_path' => 'nullable|image'
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

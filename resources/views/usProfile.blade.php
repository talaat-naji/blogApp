<x-app-layout>


    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/feed.css') }}" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>
            news feed
        </title>
    </head>


    <br>
    
         <div class="bg-gray-100 justify-content-center">
         <div class="border bg-white wid1 justify-content-center">
            @if ($userId['us'] != Auth::id())
                        <div class='justify-content-center'>
                            <input  type='hidden' value={{ $userId['us'] }} id="{{ $userId['us'] }}toBeAdded"/>

                                <button class='followBtn'  id="followbtn{{ $userId['us'] }}" class='' onclick="addFriend({{$userId['us'] }})">loadind...</button>
                        
                           </div>
                            @endif  
        {{-- <div class="align-items-center"> --}}
        @if ($userId['us'] == Auth::id())
            <form method='post' class='' enctype='multipart/form-data' action="{{ url('feeds/addPosts') }}">
                @csrf
                <div class="form-group">
                    {{-- <input class="form-control textareaa" type='textArea' name='blog_text'
                        placeholder="What's on your mind?" /><br> --}}
                        <textarea placeholder="What's on your mind?" class="form-control textareaa" name='blog_text'></textarea>
                    <div class="row">
                        <div class='col-sm'>
                            <input class="form-control-file " type='file' name='imgg' />
                        </div>
                        <div class='col-sm'>
                            <input class="btn btn-primary" type='submit' name='sub' value="Post" />
                        </div>
                    </div>
                   
                </div>
            </form> @endif 
          </div><br>
                @foreach ($posts as $post)

                    <div class="border bg-white wid justify-content-center">
                        <div class="row">
                        <div class='col-sm-auto prof'>
                        <img class="profile" src="https://ui-avatars.com/api/?name={{ $post->name }}"/>
                        </div>
                            <div class='col-sm'>

                               <div> <b class='userName1'>{{ $post->name }}</b><br>
                                <h6 class='date'>{{ $post->created_at }}</h6></div>
                            </div>
                           
                            <div class='col-sm'>
                                @if ($post->uid == Auth::id())
                                    <div class="dropdown">

                                        <button class="dropbtn"><i class="fa fa-bars"></i></button>

                                        <div class="dropdown-content">
                                            <form id='{{ $post->id }}del' method='post' action="{{ url('del') }}">
                                                @csrf
                                                <input type='hidden' value="{{ $post->id }}" name='pstId' />
                                                <input type='hidden' value="{{ $post->pic_path }}" name='pic' />

                                            </form>
<button onclick=confirmm({{ $post->id }}) class="btn navbar" name="del" /> delete post</button>

                                            <button class="btn navbar" name="del" onclick=edit({{ $post->id }})>edit
                                                post</button>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div id="editableText{{ $post->id }}">{{ $post->blog_text }}</div>

                        @if ($post->pic_path != '')

                            <img class="imgg" src="storage/app/{{ $post->pic_path }}" alt="post image goes here" width='700px'
                                height='300px' />

                        @endif
                        <div class="row justify-content-md-left">

                            <div class='col-md-auto'>

                                <button onclick=likkee({{ $post->id }},{{ $post->uid }}) id='{{ $post->id }}' class="btn like likebtn"
                                    name="likebtn">{{ $post->likenb }} Likes</button>


                            </div>

                            <div class='col-md-auto' id='dform{{ $post->id }}'>
                                @if ($post->uid == Auth::id())
                                    <button class="btn like cmnt" onclick=mycomment({{ $post->id }},{{ $post->uid }})
                                        id='c{{ $post->id }}'>{{-- $post->cmntnb
                                        --}} comments</button>

                                @else <button class="btn like cmnt" onclick=comment({{ $post->id }},{{ $post->uid }})
                                        id='c{{ $post->id }}'>{{-- $post->cmntnb
                                        --}} comments</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>


                @endforeach
                {{-- $posts->links() --}}
            </div>
          
            <script src="JSS/feedScript.js" onload="getFollowStatus({{ $userId['us'] }})"></script>

        </div>

     
</x-app-layout>

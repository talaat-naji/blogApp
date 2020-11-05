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
    {{-- <div class='container bg-gray-100'>
        <br>

        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul>
                    @foreach ($errors->any() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="align-items-center">
            <form method='post' enctype='multipart/form-data' action="{{ url('feeds/addPosts') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control" type='textArea' name='blog_text'
                        placeholder="What's on your mind?" /><br>
                    <div class="row">
                        <div class='col-sm'>
                            <input class="form-control-file " type='file' name='imgg' />
                        </div>
                        <div class='col-sm'>
                            <input class="btn btn-primary" type='submit' name='sub' value="Post" />
                        </div>
                    </div>
                    <hr>
                </div>
            </form>
            <div class="bg-gray-100 justify-content-center">
                @foreach ($posts as $post)

                    <div class="border bg-white wid justify-content-center">
                        <div class="row">
                            <div class='col-sm'>

                                <h4><b>{{ $post->name }}</b></h4>
                            </div>

                            <div class='col-sm'>
                                @if ($post->uid == Auth::id())
                                    <div class="dropdown">

                                        <button class="dropbtn"><i class="fa fa-bars"></i></button>

                                        <div class="dropdown-content">
                                            <form method='post' action="{{ url('del') }}">
                                                @csrf
                                                <input type='hidden' value="{{ $post->id }}" name='pstId' />
                                                <button class="btn navbar" name="del" id='lik'>delete post</button>


                                            </form>

                                            <button class="btn navbar" name="del" onclick=edit({{ $post->id }})>edit
                                                post</button>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div id="editableText{{ $post->id }}">{{ $post->blog_text }}</div>

                        @if ($post->pic_path != '')

                            <img src="storage/app/{{ $post->pic_path }}" alt="post image goes here" width='500px'
                                height='300px' />

                        @endif
                        <div class="row justify-content-md-left">

                            <div class='col-md-auto'>

                                <button onclick=likkee({{ $post->id }}) id='{{ $post->id }}' class="btn like likebtn"
                                    name="likebtn">{{ $post->likenb }} Likes</button>


                            </div>

                            <div class='col-md-auto' id='dform{{ $post->id }}'>
                                @if ($post->uid == Auth::id())
                                    <button class="btn like cmnt" onclick=mycomment({{ $post->id }})
                                        id='c{{ $post->id }}'>{{-- $post->cmntnb
                                        --}} comments</button>

                                @else <button class="btn like cmnt" onclick=comment({{ $post->id }})
                                        id='c{{ $post->id }}'>{{-- $post->cmntnb
                                        --}} comments</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>


                @endforeach
            </div>
            <form method='post' action="{{ url('feeds') }}">
                @csrf
                <input type='hidden' value="5" name='seeMore' />
                <button class="btn btn-link" name="comment" id='cmnt'>See More</button>
            </form>

            <script src="JSS/feedScript.js"></script>

        </div>

        {{--
        </body>

        </html> --}}
</x-app-layout>

<!Doctype>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/feed.css') }}" />
    <title>
        news feed
    </title>
</head>

<body class="body">
    <div class='container cntb'>

        <h2>Add New Post !!</h2>
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul>
                    @foreach ($errors->any() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="align-items-center">
            <form method='post' action="{{ url('feeds') }}">
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
            @foreach ($posts as $post)

                <div class="mx-auto">
                    <div class="row">
                        <div class='col-sm'>

                            <p><b>{{ $post->name }}</b></p>
                        </div>

                        <div class='col-sm'>
                            @if ($post->uid == Auth::id())
                                <form method='post' action="{{ url('del') }}">
                                    @csrf
                                    <input type='hidden' value="{{ $post->id }}" name='pstId' />
                                    <button class="btn btn" name="del" id='lik'>delete</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <p>{{ $post->blog_text }}</p>
                    <img src="{{ $post->pic_path }}" alt="post image goes here" width='500px' height='300px' />
                    <div class="acts"> </div>
                    <div class="row justify-content-md-left">
                        <div class='col-md-auto'>
                            <form method='post' action="{{ url('/like') }}">
                                @csrf
                                <input type='hidden' value="{{ $post->id }}" name='pstId' />
                                <button class="btn btn-secondary" name="like" id='lik'>Like</button>

                            </form>
                        </div>

                        <div class='col-md-auto'>
                            <form method='post' action="{{ url('feeds/cmnt') }}">
                                @csrf
                                <input type='hidden' value="{{ $post->id }}" name='pstId' />
                                <button class="btn btn-secondary" name="comment" id='cmnt'>comment</button>
                            </form>
                        </div>
                    </div>
                    <hr>



            @endforeach
            {{-- <script src="/JSS/feedScript.js"></script>
            --}}
        </div>
    </div>
</body>

</html>

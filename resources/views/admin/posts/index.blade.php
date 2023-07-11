<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Management</title>
</head>
<style>
    .article {
        width: 33%;
    }
    .title {
        font-size: 20px;
        font-weight: 700;
    }
</style>
<body>
    <h1>Posts Management</h1>
    <div>
        @foreach ($datas as $post)
            <div class="article">
                <div class="title">{{$post->title}}</div>
                <div class="content">{{$post->content}}</div>
                <div class="created-at"><u>Time:</u> {{$post->created_at}}</div>
            </div>
            <br>
        @endforeach
    </div>
</body>
</html>
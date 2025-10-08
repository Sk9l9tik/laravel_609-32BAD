<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
</head>
<body>
    <h2>{{ $paste ? "Comment list in".$paste->title : "Wrong title id!" }}</h2>
       @if($paste)
       <table border="1"> 
            <thead>
                <td>Id</th>
                <td>Text</td>
                <td>Author id</td>
                <td>Paste id</td>
            </thead>
            @foreach ($paste->comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->text }}</td>
                    <td>{{ $comment->author_id }}</td>
                    <td>{{ $comment->paste_id }}</td>
                </tr>
            @endforeach
        </table>
   @endif
</body>
</html>
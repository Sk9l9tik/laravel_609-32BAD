<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commnets</title>
</head>
<body>
    <h2>Comments list</h2>
       <table border="1"> 
            <thead>
                <td>Id</th>
                <td>Text</td>
                <td>Authro id</td>
                <td>Paste id</td>
            </thead>
            @foreach ($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->text }}</td>
                <td>{{ $comment->author_id }}</td>
                <td>{{ $comment->paste_id }}</td>
            </tr>
        @endforeach
   </table> 
</body>
</html>
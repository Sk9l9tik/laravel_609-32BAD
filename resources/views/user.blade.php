<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <h2>{{ $user ? "Pastes list for " . $user->name : "Wrong user id!" }}</h2>

    @if($user)
        <table border="1">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Main text</th>
                    <th>Expiration</th>
                    <th>Access</th>
                    <th>Author id</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->pastes as $paste)
                    <tr>
                        <td>{{ $paste->id }}</td>
                        <td>{{ $paste->title }}</td>
                        <td>{{ $paste->main_text }}</td>
                        <td>{{ $paste->expiration }}</td>
                        <td>{{ $paste->access }}</td>
                        <td>{{ $paste->author_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table border="1">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Text</th>
                    <th>Author id</th>
                    <th>Paste id</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->text }}</td>
                        <td>{{ $comment->author_id }}</td>
                        <td>{{ $comment->paste_id }}</td>
                   </tr>
               @endforeach
            </tbody>
        </table>   
    @endif

</body>
</html>
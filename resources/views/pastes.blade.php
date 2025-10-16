<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastes</title>
</head>
<body>
    <h2>Pastes list</h2>
       <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Main Text</th>
                    <th>Access</th>
                    <th>Expiration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pastes as $paste)
                <tr>
                    <td>{{ $paste->id }}</td>
                    <td>{{ $paste->title }}</td>
                    <td>{{ $paste->main_text }}</td>
                    <td>{{ $paste->access }}</td>
                    <td>{{ $paste->expiration }}</td>
                    <td>
                        <a href="{{ url('/paste/edit/'.$paste->id) }}">Edit</a>
                        <a href="{{ url('/paste/destroy/'.$paste->id) }}">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pastes->links() }}
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <h2>Users list</h2>
       <table border="1"> 
            <thead>
                <td>Id</th>
            </thead>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
            </tr>
        @endforeach
   </table> 
</body>
</html>
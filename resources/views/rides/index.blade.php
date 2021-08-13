
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-10">
    <table class="table-auto">
        <thead>
            <th>Ride Id</th>
            <th>Date</th>
            <th>Vehicle Id</th>
            <th>Vehicle Name</th>
        </thead>

        <tbody>
        @foreach ($rides as $ride)
            <tr>
                <td>{{ $ride->id }}</td>
                <td>{{ $ride->created_at }}</td>
                <td>{{ $ride->vehicle->id }}</td>
                <td>{{ $ride->vehicle->name }}</td>
            </tr> 
        @endforeach
        </tbody>
    </table>
    
    {{ $rides->links() }}
</body>
</html>


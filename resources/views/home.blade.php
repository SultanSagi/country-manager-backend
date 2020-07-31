<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    <form method="post" action="/import" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" />
        <button>Загрузить</button>
    </form>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Country</td>
                <td>Capital</td>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
            <tr>
                <td>{{$country->id}}</td>
                <td>{{$country->country}}</td>
                <td>{{$country->capital}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
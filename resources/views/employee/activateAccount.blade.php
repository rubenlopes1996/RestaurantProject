<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Account activation</title>
</head>
<body>
    <div id="app">
        <activate-account email="{{$email}}"></activate-account>
    </div> 
</body>
    <script src="../js/app.js"></script> 
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    </style>
    @yield('style') 
</head>
<body>
    <h1 class="title">@yield('title')</h1>
    <div class="container">
        @if (@session()->has('success'))
            <div class="success-message">{{session('success')}}</div>
        @endif
        <div style="text-align: center;">
            @yield("content")
        </div>
    </div>
</body>
</html>
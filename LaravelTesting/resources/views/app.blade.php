<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ isset($title) ? $title . ' - ' : null }}Laravel - The PHP Framework For Web Artisans</title>
    {!! HTML::style('css/app.css') !!}
    {!! HTML::style('css/css.css') !!}
</head>
<body>


	<div class="content">
        @if (Session::has('message'))
            <div class="flash alert-info">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif
        
        @if ($errors->any())
            <div class='flash alert-danger'>
                @foreach ( $errors->all() as $error )
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
     
        @yield('content')
    </div>


</body>
</html>
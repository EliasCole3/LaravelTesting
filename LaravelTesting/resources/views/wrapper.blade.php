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
        @yield('content')
    </div>


</body>
</html>
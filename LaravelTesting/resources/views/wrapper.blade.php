<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Elias Cole III</title>
    {!! HTML::style('css/app.css') !!}
    {!! HTML::style('css/css.css') !!}
    {!! HTML::script('js/nav.js') !!}
</head>
<body>

    <div id='wrapper'>
        <div id='body'>


                <div id='header'>
                    <b>Elias Cole III</b>
                </div>

                <div id="menu2">
                    <ul id="sddm">
                        <li><a href="/">Home</a></li>
                        <li><a href="/resume">Resume</a></li>
                        
                        <li><a href="/portfolio" onmouseover="mopen('div1')" onmouseout="mclosetime()">Portfolio</a>
                            <div id="div1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                                <a href='/portfolio/assembly'> Assembly MASM </a> 
                                <a href='/portfolio/matching-game'> Matching Game </a> 
                                <a href='/portfolio/android-fragments'> Android Fragments </a> 
                            </div>
                        </li>
                        
                    </ul>
                </div>


                <div class="content">
                    @yield('content')
                </div>


        </div>
    </div>




</body>
</html>
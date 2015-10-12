@extends('wrapper')
 
@section('content')
    <div id="splashMessage">
        
        <b>Welcome!</b> <br> <br>

        Please feel free to peruse my previous work and take a look at my resume. <br />

        <div class="update-container">
            What I’m currently working on: <br /><br />
            In my spare time I’ve been developing an app that will track, filter, and attractively display personal events(doc appointment, tires rotated, move-in date, etc.) on a timeline. I’ve been using MongoDB, Node.js, Express.js, and Mongoose. It’s been wonderful not having the context shift between three languages. It’s also been a little odd coding full-stack; it’s a weird feeling to be working on a front-end design issue, and then starting to address that issue by diving down to the bottom of the stack and manipulating the DB. So far the most interesting thing I've done(besides just getting the whole thing to work) has been implementing my own auto-incrementing field in Mongo, using the driver in Node. Pretty simple, but it was a fun one ^_^
        </div>

    </div>
@endsection
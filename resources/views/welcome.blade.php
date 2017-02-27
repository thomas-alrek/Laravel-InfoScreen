<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>InfoScreen</title>

    <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{ url('/css/ndt-lan.css')  }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- Leave those next 4 lines if you care about users using IE8 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="infoscreen">

<nav class="navbar-fixed-top">
    <div class="container-fluid">
        <div class="pull-right">
            <h1 id="slide-date"></h1>
        </div>
    </div>
</nav>

<style>
    body{
        width: 100%;
        height: 100%;
        overflow: hidden;
        cursor: none;
    }
    .vertical-center {
        min-height: 100%;
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    table{
        background-color: transparent!important;
    }
    .jumbotron{
        background-color: transparent;
    }
    .jumbotron h1{
        font-size: 100px
    }
    .jumbotron p{
        font-size: 50px
    }
    .jumbotron hr{
        border: 1px solid #fff;
    }
    #slide-header{
        width: 100%;
        overflow: hidden;
    }
    .animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    #anim-wrapper{
        max-width: 80%!important;
    }

    @keyframes anim-0 {
        0% {
            opacity: 0;
            transform: scale(.3);
        }

        50% {
            opacity: 1;
            transform: scale(1.05);
        }

        70% {
            transform: scale(.9);
        }

        100% {
            transform: scale(1);
        }
    }

    .anim-0 {
        animation-name: anim-0;
    }

    @keyframes anim-1 {
        0% {
            transform: perspective(400px) rotateX(90deg);
            opacity: 0;
        }
        40% {
            transform: perspective(400px) rotateX(-10deg);
        }
        70% {
            transform: perspective(400px) rotateX(10deg);
        }
        100% {
            transform: perspective(400px) rotateX(0deg);
            opacity: 1;
        }
    }
    .anim-1 {
        backface-visibility: visible !important;
        animation-name: anim-1;
    }

    @keyframes anim-2 {
        0% { opacity: 0; transform: translateX(-100%) rotate(-120deg); }
        100% { opacity: 1; transform: translateX(0px) rotate(0deg); }
    }
    .anim-2 {
        animation-name: anim-2;
    }

    @keyframes anim-3 {
        0% {
            transform-origin: center center;
            transform: rotate(-200deg);
            opacity: 0;
        }
        100% {
            transform-origin: center center;
            transform: rotate(0);
            opacity: 1;
        }
    }
    .anim-3 {
        animation-name: anim-3;
    }
</style>

<div class="container-fluid pagination-centered vertical-center">

    <div id="anim-wrapper" class="animated">
        <div id="slide-container" class="jumbotron" style="display: none">
            <h1 id="slide-header"><span class="icon icon-ndt-lan"></span>&nbsp;&nbsp;&nbsp;<span id="slide-title"></span></h1>
            <span id="slide-body"></span>
        </div>
    </div>

</div>

<!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        var slides = [];
        var currentSlide = null;
        var stop = false;

        function getDate(){
            $.getJSON("{{ url('/date') }}", function(data){
                $("#slide-date").html(data);
            });
        }

        function getSlideTime(){
            var title = $("#slide-title").html().length;
            var body = $("#slide-body").html().length;
            return Math.floor(((title / 5) + (body / 5)) * 300) + 2500;
        }

        function renderSlide(slide){
            var lines = slide.body.split('\n');
            slide.body = "";
            for(var i = 0; i < lines.length; i++){
                slide.body += "<p>" + lines[i] + "</p>";
            }
            $("#slide-container").fadeOut(function(){
                $("#anim-wrapper").removeClass();
                $("#anim-wrapper").addClass("animated anim-" + Math.floor(Math.random() * (3 + 1)));
                $("#slide-title").html(slide.title);
                $("#slide-body").html(slide.body);
                $("#slide-container").fadeIn();
                setTimeout(function(){
                    showSlides();
                }, getSlideTime());
            });
        }

        function showSlides(){
            if(stop){
                return;
            }
            fetchSlides();

            if(currentSlide != null){
                if(currentSlide >= slides.length){
                    currentSlide = 0;
                }
                if(slides.length == 0){
                    setTimeout(function(){
                        showSlides();
                    }, 1000);
                    return;
                }
                $.getJSON("{{ url('/slide') }}/" + slides[currentSlide].id, function(data){
                    renderSlide(data);
                }).error(function(){
                    location.reload(true);
                });
                currentSlide++;
            }
        }

        function fetchSlides(){
            $.getJSON("{{ url('/slide') }}", function(data){
                if(data != slides){
                    slides = data;
                }
                if(currentSlide == null){
                    currentSlide = 0;
                    showSlides();
                }
            });
        }

        $("#slide-container").fadeIn(function(){
            showSlides();
            setInterval(function(){
                getDate();
            }, 1000);
            setTimeout(function(){
                stop = true;
                $("#slide-container").fadeOut(function(){
                    location.reload(true);
                });
            }, (60 * 1000) * 60);
        });
    });
</script>
</body>
</html>

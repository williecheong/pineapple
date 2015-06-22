<!DOCTYPE html>
<html lang="en">
    <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <meta charset="utf-8">
            <title>Pineapple Kitchens</title>
            <link rel="icon" type="img/ico" href="/favicon.ico">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
            <link href='//fonts.googleapis.com/css?family=Roboto:500,100,300,700,400' rel='stylesheet' type="text/css">
            <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
            <link href="/assets/css/styles.css" rel="stylesheet">
    </head>
    <body>
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                @foreach($images as $key => $image)
                    <div class="item @if($key==0) {!! 'active' !!} @endif">
                        <div class="container">
                            <img src="{!! $image !!}">
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="icon-next"></span>
            </a>
            <div class="carousel-caption">
                <h1>
                    {!! $title !!}<br>
                    <span class="lead">{!! $subtitle !!}</span>
                </h1>
                <a class="btn btn-lg btn-primary" href="/">
                    <i class="fa fa-cutlery"></i>
                    Order Here for ${!! $price !!}
                </a>
            </div>                
        </div>
        <!-- /.carousel -->

        <div class="container marketing">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img class="img-circle" src="http://placehold.it/140x140">
                    <h2>Mobile-first</h2>
                    <p>Tablets, phones, laptops. The new 3 promises to be mobile friendly from the start.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img class="img-circle" src="http://placehold.it/140x140">
                    <h2>One Fluid Grid</h2>
                    <p>There is now just one percentage-based grid for Bootstrap 3. Customize for fixed widths.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img class="img-circle" src="http://placehold.it/140x140">
                    <h2>LESS is More</h2>
                    <p>Improved support for mixins make the new Bootstrap 3 easier to customize.</p>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->

        <!-- FOOTER -->
        <footer class="text-center">
            <hr>
            <i class="fa fa-copyright"></i>
            Pineapple Kitchens 2015 
        </footer>
        <!-- script references -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
    </body>
</html>
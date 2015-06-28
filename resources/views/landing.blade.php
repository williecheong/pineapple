<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>{!! APP_NAME !!}</title>
        <link rel="icon" type="img/ico" href="/favicon.ico?v={!! date('Ymd') !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Roboto:500,100,300,700,400' rel='stylesheet' type="text/css">
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/landing.css?v={!! date('Ymd') !!}" rel="stylesheet">
        <style>
            .app-text {
                color: {!! $theme !!};
            }
        </style>

    </head>
    <body id="page-top" class="index">
        <!-- Header -->
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <img class="img-responsive img-thumbnail img-rounded" src="{!! $images[0] !!}" alt="main-image">
                        <div class="intro-text">
                            <span class="title app-text">
                                {!! $title !!}
                            </span>
                            <div class="subtitle app-text">
                                {!! $subtitle !!}
                            </div>
                            <div>
                                <a href="/order" class="btn btn-lg btn-outline">
                                    <i class="fa fa-cutlery"></i>
                                    Order For Tomorrow
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Portfolio Grid Section -->
        <section id="portfolio">
            <div class="container">
                {{--
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Portfolio</h2>
                        <hr class="star-primary">
                    </div>
                </div>
                --}}
                <div class="row">
                    @foreach($images as $key=>$image)
                        <div class="col-sm-4 portfolio-item">
                            <a href="#portfolioModal{!! $key !!}" class="portfolio-link" data-toggle="modal">
                                <div class="caption">
                                    <div class="caption-content">
                                        <i class="fa fa-search-plus fa-3x"></i>
                                    </div>
                                </div>
                                <img src="{!! $image !!}" class="img-responsive img-thumbnail">
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- About Section -->
        <section class="success" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>The Dineapple Mission</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <p>Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional LESS stylesheets for easy customization.</p>
                    </div>
                    <div class="col-md-5">
                        <p>Whether you're a student looking to showcase your work, a professional looking to attract clients, or a graphic artist looking to share your projects, this template is the perfect starting point!</p>
                    </div>
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <a href="/order" class="btn btn-lg btn-default">
                            <i class="fa fa-cutlery"></i>
                            Order For Tomorrow
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="text-center">
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-4">
                            <h3>About {!! APP_NAME !!}</h3>
                            <p>Striving to serve something new and delicious everyday.</p>
                        </div>
                        <div class="footer-col col-md-4">
                            <h3>Contact Us</h3>
                            <ul class="list-inline">
                                <li>
                                    <a href="http://terrychen.me" class="btn-social btn-outline">
                                        <i class="fa fa-fw fa-coffee"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="http://williecheong.com" class="btn-social btn-outline">
                                        <i class="fa fa-fw fa-desktop"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn-social btn-outline">
                                        <i class="fa fa-fw fa-heartbeat"></i>
                                    </a>
                                </li>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-col col-md-4">
                            <h3>Location</h3>
                            <p>
                                Restaurant coming soon<br>
                                Stay tuned!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-below">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <i class="fa fa-copyright"></i>
                            {!! APP_NAME !!} {!! date('Y') !!}
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        @foreach($images as $key=>$image)
            <!-- Portfolio Modals -->
            <div class="portfolio-modal modal fade" id="portfolioModal{!! $key !!}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-content">
                    <div class="close-modal" data-dismiss="modal">
                        <div class="lr">
                            <div class="rl">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <div class="modal-body">
                                    <h2 class="app-text">
                                        {!! $title !!}
                                    </h2>
                                    <hr class="star-primary">
                                    <img src="{!! $image !!}" class="img-responsive img-centered img-rounded" alt="">
                                    <button type="button" class="btn btn-lg btn-default" style="margin-top:15px;" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                    <a href="/order" class="btn btn-lg btn-outline">
                                        <i class="fa fa-cutlery"></i>
                                        Order For Tomorrow
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach        

        <!-- script references -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/landing.js?v={!! date('Ymd') !!}"></script>
        @if ($app->environment('production'))
            @include('templates.analytics')
        @endif
    </body>

</html>

<?php echo "home"; exit; ?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gamazon</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/heroic-features.css')}}" rel="stylesheet">

</head>

<body>

@include('includes.header');

<!-- Page Content -->
<div class="container">

    <!-- Jumbotron Header -->
    <header class="jumbotron my-4 cover">
        <h1 class="display-3 cover-letter">Gamazon</h1>
        {{--<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>--}}
        {{--<a href="#" class="btn btn-primary btn-lg">Search</a>--}}

    </header>

    <!-- Page Features -->
    <h3>Five most popular products</h3>

    <div class="row text-center">
        @if(sizeof($popular)==0)
            <div class="col-lg-3 col-md-6 mb-4">
                <h3>No products.</h3>
            </div>
        @else
            <?php $i=0; ?>
            @foreach($popular as $pop)
                <?php $i++; ?>
                @break($i>=5)

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top card-image" src="{{asset('uploads/' . $images[$pop->product_id])}}" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{$pop->name}}</h4>
                            <p class="card-text">Rates: {{number_format($pop->rate,1)}} | Reviews: {{$pop->review}} | Visits: {{$pop->visit}}</p>
                        </div>
                        <div class="card-footer">
                            <a href="/product/{{$pop->product_id}}" class="btn btn-primary">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

    <hr>

    <h3>Products</h3>
    <a href="/home/order/rate" class="btn btn-light">Rate</a>
    <a href="/home/order/review" class="btn btn-light">Review</a>
    <a href="/home/order/visit" class="btn btn-light">Visit</a>
    <!-- Page Features -->
    <div class="row text-center">
        @if(sizeof($products)==0)
            <div class="col-lg-3 col-md-6 mb-4">
                <h3>No products.</h3>
            </div>
        @else
            @foreach($products as $product)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top card-image" src="{{asset('uploads/' . $images[$product->product_id])}}" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{$product->name}}</h4>
                            <p class="card-text">Rates: {{number_format($product->rate,1)}} | Reviews: {{$product->review}} | Visits: {{$product->visit}}</p>
                        </div>
                        <div class="card-footer">
                            <a href="/product/{{$product->product_id}}" class="btn btn-primary">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

@include('includes.footer');

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

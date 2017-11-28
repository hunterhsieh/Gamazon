<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gamazon</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/heroic-features.css" rel="stylesheet">

</head>

<body>

@include('includes.header');


<!-- Page Content -->
<div class="container">

    <h1 class="cart-title">Shopping Cart</h1>
    <a href="/cart/remove/all" class="btn btn-success btn-right">Place my order</a>
    <hr>
    <!-- Page Features -->
    <div class="row text-center">
        @if(sizeof($products)==0)
            <div class="col-lg-3 col-md-6 mb-4">
                <h2>No products.</h2>
            </div>
        @else
            @foreach($products as $product)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="{{$images[$product->product_id]}}" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{$product->name}}</h4>
                            <p class="card-text">Rates: {{number_format($product->rate,1)}} | Reviews: {{$product->review}} | Visits: {{$product->visit}}</p>
                        </div>
                        <div class="card-footer">
                            <a href="/product/{{$product->product_id}}" class="btn btn-primary">Details</a>
                            <a href="/cart/remove/{{$product->product_id}}" class="btn btn-warning">Remove</a>
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

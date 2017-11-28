<!DOCTYPE html>
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

    <h1 class="cart-title">Search</h1>
    {!! Form::open(array('url'=>'/search'))!!}<br>

    {!!Form::label('company','Company')!!}
    {!!Form::select('company',$company_names)!!}<br>

    {!!Form::label('category','Category')!!}
    {!!Form::select('category',['%'=>'','Action'=>'Action','Adventure'=>'Adventure','Role-playing'=>'Role-playing','Simulation'=>'Simulation','Strategy'=>'Strategy','Sports'=>'Sports','Other'=>'Other'])!!}<br>

    {!!Form::label('keyword','Search keyword')!!}
    {!!Form::text('keyword')!!}<br>

    {!!Form::label('price','Price')!!}
    {!!Form::number('price_low',0)!!} ~ {!!Form::number('price_high',1000000)!!}<br><br>

    {!!Form::submit('Search')!!}
    {!!Form::close()!!}<br>

    <hr>
    <h3>Search result</h3>
    <!-- Page Features -->
    <div class="row text-center">
        @if(sizeof($products)==0)
            <div class="col-lg-3 col-md-6 mb-4">
                <h4>No results.</h4>
            </div>
        @else
            @foreach($products as $product)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="{{$images[$product->product_id]}}" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{$product->name}}</h4>
                            <p class="card-text">{{$product->description}}</p>
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

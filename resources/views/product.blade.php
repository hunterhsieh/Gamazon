<?php global $account; ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/shop-item.css')}}" rel="stylesheet">

  </head>

  <body>

  @include('includes.header');

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">
          <h1 class="my-4"><a href="/company/{{$company->company_id}}">{{$company->name}}</a></h1>
          <div class="list-group">
            <?php $i=0; ?>
            @foreach($images as $image)
            <a href="/product/{{$product->product_id}}/{{$i}}" class="list-group-item">Image {{$i+1}}</a>
            <?php $i++; ?>
            @endforeach
          </div>
          <br><br>
          @if($account['type']=='gamer')
            @if($in_cart == true)
            <a href="/cart/remove/{{$product->product_id}}" class="btn btn-lg btn-warning">Remove from cart</a>
            @else
            <a href="/cart/add/{{$product->product_id}}" class="btn btn-lg btn-warning">Add to cart</a>
            @endif
          @endif
        </div>


        <div class="col-lg-9">

          <div class="card mt-4">
            <img class="card-img-top img-fluid product-image" src="{{asset('uploads/' . $images[$image_no]->image)}}" alt="">
            <div class="card-body">
              <h3 class="card-title">{{$product->name}}</h3>
              <h4>${{$product->price}}</h4>
              <p class="card-text">{{$product->description}}</p>
              <span class="text-warning">
                <?php $i=0; ?>
                @for(;$i<number_format($rate,0);$i++)
                    &#9733;
                @endfor
                @for($i=5-$rate;$i>0;$i--)
                    &#9734;
                @endfor
              </span>
              {{number_format($rate,1)}} stars <span class="visited">Visited {{$visit->visited_num}}</span>
            </div>
          </div>
          <!-- /.card -->

          <div class="card card-outline-secondary my-4">
            <div class="card-header">
              Product Reviews
            </div>
            <div class="card-body">
              @foreach ($reviews as $review)
                <p>{{$review->content}}</p>
                <small class="text-muted">Posted by {{$review->name}} | Rate {{$review->rate}}</small><br>
                <small class="like">
                  <a href=".\review\like\{{$product->product_id}}\{{$review->review_id}}">Like</a>
                  {{$review->like_num}}
                  @if($review->id == $account['id'])
                  &nbsp; &nbsp;
                  <a href=".\review\delete\{{$product->product_id}}\{{$review->review_id}}">Delete</a>
                  @endif
                </small>
                <hr>
              @endforeach
              @if(!$has_reviewed)
                <a href=".\review\post\{{$product->product_id}}" class="btn btn-success">Leave a Review</a>
              @endif
            </div>
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

      </div>

    </div>
    <!-- /.container -->

  @include('includes.footer');

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>

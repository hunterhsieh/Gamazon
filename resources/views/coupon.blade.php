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
@include('includes.header')
<div class="container">

    <div class="text-center">
        <div class="center">

            <h1 id="title">Coupon</h1>
            <hr>
            <br><br>
            <table class="table table-hover">
            <?php $i=0; ?>
            @foreach($coupons as $coupon)
               <?php $i++; ?>
               <tr>
                   <td>
                       {{$i}}
                   </td>
                   <td>
                       {{$coupon->content}}% off coupon
                   </td>
                   <td>
                       {{$coupon->datetime}}
                   </td>
               </tr>
            @endforeach
            </table>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br>
@include('includes.footer')

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
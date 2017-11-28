<?php global $account; ?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Gamazon</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/search">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link">|</span>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                @else
                    <li class="hunter-menu nav-item">

                        @if($account['type']=='company')
                        <a class="nav-link">

                            <img class="company-icon" src="{{$account['image']}}">
                            &nbsp;{{ Auth::user()->name }}

                        </a>
                        <ul>
                            <li><a class="nav-link" href="/product/add">Add product</a></li>
                            <li><a class="nav-link" href="/company/{{$account['type_id']}}">Product list</a></li>
                            <li><a class="nav-link" href="/logout">Logout</a></li>
                        </ul>
                        @else
                        <a class="nav-link">
                            @if($account['level']=='bronze')
                            <img class="user-level" src="{{asset('bronze.png')}}">&nbsp;{{ Auth::user()->name }}</a>
                            @elseif($account['level']=='silver')
                                <img class="user-level" src="{{asset('silver.png')}}">&nbsp;{{ Auth::user()->name }}</a>
                            @elseif($account['level']=='gold')
                                <img class="user-level" src="{{asset('gold.png')}}">&nbsp;{{ Auth::user()->name }}</a>
                            @endif
                        <ul>
                            <li><a class="nav-link" href="/cart">Cart</a></li>
                            <li><a class="nav-link" href="/coupon">My Coupon</a></li>
                            <li><a class="nav-link" href="/logout">Logout</a></li>
                        </ul>
                        @endif
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<html>
    <head>
        <title>9xb tech test</title>
        <meta name="desc" value="@yield('title')">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="row pt-2">
            <div class="col-md-12 text-center">
                @guest
                    <h2>Welcome to the tech test!</h2>
                    <p>Access to this page is protected.  Please 
                    <a href="{{ route('login') }}" title="log in">log in</a>
                @else
                    <a class="btn btn-secondary float-right mr-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">log out</a>
                    <h2>Welcome to the tech test {{ Auth::user()->name }}!</h2>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
        <div class="row ml-sm-2 ml-2 pt-5">
            <div class="col-md-1 col-lg-1 hidden-sm hidden-xs"></div>
            <div class="col-md-10 col-lg-10 col-sm-12 p-1">
                @guest
                    <div class="text-center h5">You must be logged in to use this page.</div>
                @endguest
                @yield('content')
            </div>
            <div class="col-md-1 col-lg-1 hidden-sm hidden-xs"></div>
        </div>
    </body>
</html>

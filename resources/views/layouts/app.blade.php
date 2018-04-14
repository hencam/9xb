<html>
    <head>
        <title>9xb tech test</title>
        <meta name="desc" value="@yield('title')">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    </head>
    <body>
        <div class="row">
            <div class="col-md-12 text-center">
                @guest
                    <b>Welcome to the 9xb tech test!</b>
                    <p>Access to this page is protected.  Please 
                    <a href="{{ route('login') }}" title="log in">log in</a>
                @else
                    <b>Welcome to the 9xb tech test {{ Auth::user()->name }}!</b>
                    <a class="btn btn-secondary float-right mr-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">log out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
        <div class="row ml-sm-2 ml-2">
            <div class="col-md-2 col-lg-2 hidden-sm hidden-xs"></div>
            <div class="col-md-8 col-lg-8 col-sm-12 border rounded p-1">
                @guest
                    <div class="text-center h5">You must be logged in to use this page.</div>
                @else
                    <p>You are logged in!</p>
                @endguest
                @yield('content')
            </div>
            <div class="col-md-2 col-lg-2 hidden-sm hidden-xs"></div>
        </div>
    </body>
</html>

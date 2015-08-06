<!DOCTYPE html>
<html>
<head>
	@include('includes.head')
</head>

<body>

    @if (Sentry::check())
        @include('includes.header')
    @endif
	
	<article class="col-lg-12 main-template">
	@yield('content')
	</article>

    @if (app('env') !== 'production')
        @include('includes.footer')
    @endif
</body>
</html>

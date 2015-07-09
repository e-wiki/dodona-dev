	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				{!! HTML::link('/', 'Dodona', ['class' => 'navbar-brand']) !!}
			</div>
			<div class="collapse navbar-collapse" id="mainNavBar">
				<ul class="nav navbar-nav">
                    @if (Sentry::check())
    					<li><a href="{{ url('/') }}"><span class="fa fa-home"></span>&nbsp;Status</a></li>
                    @endif
    				@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
    					<li><a href="{{ url('/administration/') }}"><span class="fa fa-dashboard"></span>&nbsp;Administration</a></li>
                    @endif
				</ul>
	          <ul class="nav navbar-nav navbar-right">
	            @if (Sentry::check())
				<li {{ (Request::is('profile') ? 'class="active"' : '') }}><a href="{{ route('sentinel.profile.show') }}">Account</a>
				</li>
				<li>
					<a href="{{ route('sentinel.logout') }}">Logout</a>
				</li>
				@else
				<li {{ (Request::is('login') ? 'class="active"' : '') }}><a href="{{ route('sentinel.login') }}">Login</a></li>
				<!--<li {{ (Request::is('users/create') ? 'class="active"' : '') }}><a href="{{ route('sentinel.register.form') }}">Register</a></li>-->
				@endif
	          </ul>
			</div>
		</div>
	</nav>
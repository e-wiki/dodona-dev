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
					<li><a href="{{ url('/') }}"><span class="fa fa-home"></span>&nbsp;Status</a></li>
					<li><a href="{{ url('/report/') }}"><span class="fa fa-area-chart"></span>&nbsp;Report</a></li>
					<li><a href="{{ url('/administration/') }}"><span class="fa fa-dashboard"></span>&nbsp;Administration</a></li>
				</ul>
			</div>
		</div>
	</nav>
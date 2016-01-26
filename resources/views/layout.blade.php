<html lang="eng">
<head>
@include('meta')
<body>

	<!--<header>
		<div class="row">
			<ul id="slide-out" class="side-nav fixed">
				<li><a href="/Products">Products</a></li>
				<li><a href="/Categories">Categories</a></li>
				<li><a href="#!">News</a></li>
				<li><a href="#!">Event</a></li>
			</ul>
			<a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
		</div>
	</header>-->
	@include('header')
	<main>
		<div class="container">
			<div class='row'>
				<div class="col s12 m9 l10">
					@yield('content')
				</div>
			</div>
		</div>
	</main>
	<div class='row'>
	</div>
</body>
</html>


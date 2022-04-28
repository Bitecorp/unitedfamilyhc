@php
	$headerClass = (!empty($headerInverse)) ? 'navbar-inverse ' : 'navbar-default ';
@endphp
<!-- begin #header -->
<div id="header" class="header {{ $headerClass }}">
	<!-- begin navbar-header -->
	<div class="navbar-header">
		<a href='/dashboard' class="navbar-brand"> <img src="/assets/img/logo/logo-corporativo-nav.png" alt="Girl in a jacket" >  <b>United</b> Family</a>
	</div>
	<!-- end navbar-header -->

	<!-- begin header-nav -->
	<ul class="navbar-nav navbar-right">
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<div class="image image-icon bg-black text-grey-darker">
					<i class="fa fa-user"></i>
				</div>
				<span class="d-none d-md-inline">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
                <a href="{{ url('/logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log Out
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
			</div>
		</li>
	</ul>
	<!-- end header navigation right -->
</div>
<!-- end #header -->

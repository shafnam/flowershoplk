{{-- <div class="container"> --}}
<div id="logoArea" class="navbar">
	<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</a>
	<div class="navbar-inner">
		<a class="brand" href="{{ route('index') }}">
			<img src="{{ URL::asset('images/flower-shop-logo.png') }}" alt="FlowerShoplk"/>
		</a>
		<ul id="topMenu" class="nav pull-right">
			<li><a class="{{ Request::is('/') ? 'active' : '' }}" href="{{ route('index') }}">Home</a></li>
			<li><a class="{{ Request::is('products*') ? 'active' : '' }}" href="{{ route('products') }}">Products</a></li>
		@guest
			<li><a class="{{ Request::is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li> 
			<li><a class="{{ Request::is('login*') ? 'active' : '' }}" href="{{ route('login') }}" style="color: crimson;"><small>Login</small></a></li>
		@else
			<li><a class="{{ Request::is('login*') ? 'active' : '' }}" href="{{ route('user.orderHistory') }}">My orders</a></li>
			<li><a class="{{ Request::is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li> 
			<li>
				<a class="{{ Request::is('login*') ? 'active' : '' }}" href="{{ route('logout') }}"
				onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">
					<small style="color:darkblue;font-weight: bold;">Logout</small>
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					{{ csrf_field() }}
				</form>
				{{-- <div class="dropdwn">
					<button onclick="myFunction()" class="dropbtn">Dropdown</button>
					<div id="myDropdown" class="dropdown-content">
						<a href="#">Link 2</a>
						<a href="#">Link 3</a>
					</div>
				</div>
				 --}}
			</li>
		@endguest
			<li>
				<a href="{{ route('shoppingCart') }}">
					<div class="btn btn-mini btn-success"><i class="icon-shopping-cart icon-white"></i></div> 
					<?php if(Session::has('cart')) { ?>
						<span class="percent"> <?php echo Session::get('cart')->totalQty; ?> </span>
					<?php } ?>                                
				</a> 
			</li>         
		</ul>
	</div>
</div>
{{-- </div> --}}
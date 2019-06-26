<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ URL::asset('images/sidebar-1.jpg') }}">
    <!-- Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger" Tip 2: you can also add an image using data-image tag -->
    <div class="logo">
        <a href="{{ route('admin.dashboard') }}" class="simple-text logo-normal" style="font-family: 'Playball', cursive;text-transform: capitalize;font-size: 25px;">
            <img src="{{ URL::asset('images/logo.png') }}" alt="FlowerShoplk"/>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @if($user_type == "Administrator")
                <li class="nav-item  {{ Request::is('admin') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/orders*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.orders.list') }}">
                        <i class="material-icons">open_in_new</i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/shops*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.shops.list') }}">
                        <i class="material-icons">store</i>
                        <p>Shops</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/products*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.products.list') }}">
                        <i class="material-icons">card_giftcard</i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/customers*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users.list') }}">
                        <i class="material-icons">person</i>
                        <p>Customers</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/commissions*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.commissions.list') }}">
                        <i class="material-icons">money</i>
                        <p>Commissions</p>
                    </a>
                </li>
            @elseif($user_type == "Editor")
                <li class="nav-item {{ Request::is('admin/orders*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.orders.list') }}">
                        <i class="material-icons">open_in_new</i>
                        <p>Orders</p>
                    </a>
                </li>
            @elseif($user_type == "ProductEditor")
                <li class="nav-item {{ Request::is('admin/products*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.products.list') }}">
                        <i class="material-icons">open_in_new</i>
                        <p>Products</p>
                    </a>
                </li>
            @endif  
        </ul>
    </div>
</div>
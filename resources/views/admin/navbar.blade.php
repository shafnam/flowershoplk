    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                {{-- <a class="navbar-brand" href="#pablo">Typography</a> --}}
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                {{-- <form class="navbar-form">
                    <div class="input-group no-border">
                    <input type="text" value="" class="form-control" placeholder="Search...">
                    <button type="submit" class="btn btn-white btn-round btn-just-icon">
                        <i class="material-icons">search</i>
                        <div class="ripple-container"></div>
                    </button>
                    </div>
                </form> --}}
                <ul class="navbar-nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#pablo">
                            <i class="material-icons">dashboard</i>
                            <p class="d-lg-none d-md-block">Stats</p>
                        </a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-transform: capitalize;">
                            <i class="material-icons">person</i>Hi, {{ Auth::user()->name }}
                            {{-- <span class="notification">5</span> --}}
                            <p class="d-lg-none d-md-block">
                            Some Actions
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#pablo">
                            <i class="material-icons">person</i>
                            <p class="d-lg-none d-md-block">
                            Account
                            </p>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
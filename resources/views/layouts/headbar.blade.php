<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
    <img class="logo-lg logo-line" src="{{ url('assets\images\logo-1.png') }}" alt="logo" height="20">
        <img class="logo-mini" src="{{ url('assets\images\favicon.png') }}" alt="logo" height="30">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu margin-right-logout-nav">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user logout-user-icon"></span><span class="caret"></span></a>
                    <ul class="dropdown-menu custom-dropdown">
                        <li><a><span class="glyphicon glyphicon-log-out pull-left profile-logout-icon"></span><p class="mb-0 text-right" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</p></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

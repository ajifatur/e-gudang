
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="/admin">{{ get_website_name() }}</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav ml-auto ml-md">
        @if(Auth::user()->role == role_admin_sistem())
        <li class="bg-warning d-none d-sm-block"><a class="app-nav__item">Hai <strong>{{ Auth::user()->nama_user }}</strong>, Anda masuk sebagai <strong>SUPER ADMIN</strong></a></li>
        @elseif(Auth::user()->role == role_admin_grup())
        <li class="bg-warning d-none d-sm-block"><a class="app-nav__item">Hai <strong>{{ Auth::user()->nama_user }}</strong>, Anda masuk sebagai <strong>ADMIN GRUP</strong></a></li>
        @elseif(Auth::user()->role == role_admin_kantor())
        <li class="bg-warning d-none d-sm-block"><a class="app-nav__item">Hai <strong>{{ Auth::user()->nama_user }}</strong>, Anda masuk sebagai <strong>ADMIN KANTOR</strong></a></li>
        @endif
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="/admin/profil"><i class="fa fa-cog fa-lg"></i> Profil</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
            <form id="form-logout" method="post" action="/admin/logout">
                {{ csrf_field() }}
            </form>
          </ul>
        </li>
      </ul>
    </header>
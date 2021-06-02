
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar mx-auto" height="100" src="{{ asset('assets/images/logo/'.get_logo()) }}" alt="User Image">
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item {{ Request::path() == 'admin' ? 'active' : '' }}" href="/admin"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @if(Auth::user()->role == role_admin_sistem() || Auth::user()->role == role_admin_grup())
        <li><a class="app-menu__item {{ strpos(Request::url(), '/admin/user') ? 'active' : '' }}" href="/admin/user"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">User</span></a></li>
        @endif
        @if(Auth::user()->role == role_admin_sistem())
        <li><a class="app-menu__item {{ strpos(Request::url(), '/admin/pengaturan') ? 'active' : '' }}" href="/admin/pengaturan"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Pengaturan</span></a></li>
        @endif
        @if(Auth::user()->role == role_admin_grup() || Auth::user()->role == role_admin_kantor())
        <li><a class="app-menu__item {{ strpos(Request::url(), '/admin/stok') ? 'active' : '' }}" href="/admin/stok"><i class="app-menu__icon fa fa-retweet"></i><span class="app-menu__label">Kelola Stok</span></a></li>
        @endif
        <li class="app-menu__submenu"><span class="app-menu__label">Master</span></li>
        @if(Auth::user()->role == role_admin_sistem() || Auth::user()->role == role_admin_grup())
        <li><a class="app-menu__item {{ strpos(Request::url(), '/admin/grup') ? 'active' : '' }}" href="/admin/grup"><i class="app-menu__icon fa fa-dot-circle-o"></i><span class="app-menu__label">Grup</span></a></li>
        <li><a class="app-menu__item {{ strpos(Request::url(), '/admin/kantor') ? 'active' : '' }}" href="/admin/kantor"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Kantor</span></a></li>
        @endif
        <li><a class="app-menu__item {{ strpos(Request::url(), '/admin/barang') ? 'active' : '' }}" href="/admin/barang"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Barang</span></a></li>
      </ul>
    </aside>
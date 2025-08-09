<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
    </ul>
    <!--end::Start Navbar Links-->
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">
      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu-compact">
        <a href="#" class="nav-link dropdown-toggle compact-user-toggle" data-bs-toggle="dropdown">
          <span class="d-none d-lg-inline compact-user-name">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end compact-dropdown">
          <li class="border-top border-bottom">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
              class="dropdown-item compact-logout-btn">
              <i class="bi bi-power text-red"></i>
              <span>ログアウト</span>
            </a>
          </li>
        </ul>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
          @csrf
        </form>
      </li>
      <!--end::User Menu Dropdown-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>

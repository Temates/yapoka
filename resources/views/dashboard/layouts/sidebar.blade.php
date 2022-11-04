<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"  href="/dashboard">
            <span data-feather="home" class="align-text-bottom"></span>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard/EditProfile') ? 'active' : '' }}"  href="/dashboard/EditProfile">
            <span data-feather="user" class="align-text-bottom"></span>
            Edit Profile
          </a>
        </li>
        

      @can('admin')
        
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
        <span>Administrator</span>       
      </h6>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard/angket/add') ? 'active' : '' }}" href="/dashboard/angket/add">
            <span data-feather="file-text" class="align-text-bottom"></span>
            Input Soal
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/dashboard/pilihangket/add/') ? 'active' : '' }}" href="/dashboard/pilihangket/add">
            <span data-feather="file-plus" class="align-text-bottom"></span>
            Buat Laporan
          </a>
        </li>
        
      </ul>

      @endcan

    </div>
  </nav>
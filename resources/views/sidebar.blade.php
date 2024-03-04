<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Noble<span>UI</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="dashboard.html" class="nav-link">
            <i class="link-icon" data-feather="home"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">Menu</li>       
        @role('admin')
        <li class="nav-item">
          <a href="{{route('sekolah')}}" class="nav-link">
            {{-- <i class="mdi mdi-home-modern"></i> --}}
            <i class="link-icon" data-feather="speaker"></i>
            <span class="link-title">Data Sekolah</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('mesin')}}" class="nav-link">
            <i class="link-icon" data-feather="speaker"></i>
            <span class="link-title">Data Mesin</span>
          </a>
        </li>
        @endrole
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="book"></i>
            <span class="link-title">Absensi</span>  
            <i class="link-arrow" data-feather="chevron-down"></i>          
          </a>
          <div class="collapse" id="uiComponents">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{url('/live-absen')}}" class="nav-link">Absensi Live</a>
              </li>
              <li class="nav-item">
                <a href="{{route('absen')}}" class="nav-link">Data Absen</a>
              </li>              
              <li class="nav-item">
                <a href="" class="nav-link">Rekapitulasi Absen</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Sekolah</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('jurusan')}}" class="nav-link">Jurusan</a>
              </li>
              <li class="nav-item">
                <a href="{{route('kelas')}}" class="nav-link">Kelas</a>
              </li>
              <li class="nav-item">
                <a href="{{route('siswa')}}" class="nav-link">Siswa</a>
              </li>              
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a href="dashboard.html" class="nav-link">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Kirim Pesan</span>
          </a>
        </li>
        <li class="nav-item nav-category">Settings</li>
        <li class="nav-item">
          <a href="dashboard.html" class="nav-link">
            <i class="link-icon" data-feather="inbox"></i>
            <span class="link-title">Pesan</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="dashboard.html" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Profile</span>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="false" aria-controls="forms">
            <i class="link-icon" data-feather="inbox"></i>
            <span class="link-title">Forms</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="forms">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/forms/basic-elements.html" class="nav-link">Basic Elements</a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/advanced-elements.html" class="nav-link">Advanced Elements</a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/editors.html" class="nav-link">Editors</a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/wizard.html" class="nav-link">Wizard</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link"  data-bs-toggle="collapse" href="#charts" role="button" aria-expanded="false" aria-controls="charts">
            <i class="link-icon" data-feather="pie-chart"></i>
            <span class="link-title">Charts</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="charts">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/charts/apex.html" class="nav-link">Apex</a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">ChartJs</a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">Flot</a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/morrisjs.html" class="nav-link">Morris</a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/peity.html" class="nav-link">Peity</a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/sparkline.html" class="nav-link">Sparkline</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#tables" role="button" aria-expanded="false" aria-controls="tables">
            <i class="link-icon" data-feather="layout"></i>
            <span class="link-title">Table</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="tables">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/tables/basic-table.html" class="nav-link">Basic Tables</a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data-table.html" class="nav-link">Data Table</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#icons" role="button" aria-expanded="false" aria-controls="icons">
            <i class="link-icon" data-feather="smile"></i>
            <span class="link-title">Icons</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="icons">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/icons/feather-icons.html" class="nav-link">Feather Icons</a>
              </li>
              <li class="nav-item">
                <a href="pages/icons/flag-icons.html" class="nav-link">Flag Icons</a>
              </li>
              <li class="nav-item">
                <a href="pages/icons/mdi-icons.html" class="nav-link">Mdi Icons</a>
              </li>
            </ul>
          </div>
        </li>         --}}
      </ul>
    </div>
  </nav>
  <nav class="settings-sidebar">
    <div class="sidebar-body">
      <a href="#" class="settings-sidebar-toggler">
        <i data-feather="settings"></i>
      </a>
      <h6 class="text-muted mb-2">Sidebar:</h6>
      <div class="mb-3 pb-3 border-bottom">
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          <label class="form-check-label" for="sidebarLight">
            Light
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          <label class="form-check-label" for="sidebarDark">
            Dark
          </label>
        </div>
      </div>
      <div class="theme-wrapper">
        <h6 class="text-muted mb-2">Light Theme:</h6>
        <a class="theme-item active" href="demo1/dashboard.html">
          <img src="assets/images/screenshots/light.jpg" alt="light theme">
        </a>
        <h6 class="text-muted mb-2">Dark Theme:</h6>
        <a class="theme-item" href="demo2/dashboard.html">
          <img src="assets/images/screenshots/dark.jpg" alt="light theme">
        </a>
      </div>
    </div>
  </nav>

  <nav class="settings-sidebar">
    <div class="sidebar-body">
      <a href="#" class="settings-sidebar-toggler">
        <i data-feather="settings"></i>
      </a>
      <h6 class="text-muted mb-2">Sidebar:</h6>
      <div class="mb-3 pb-3 border-bottom">
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          <label class="form-check-label" for="sidebarLight">
            Light
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          <label class="form-check-label" for="sidebarDark">
            Dark
          </label>
        </div>
      </div>
      <div class="theme-wrapper">
        <h6 class="text-muted mb-2">Light Theme:</h6>
        <a class="theme-item active" href="../../../demo1/dashboard.html">
          <img src="../../../assets/images/screenshots/light.jpg" alt="light theme">
        </a>
        <h6 class="text-muted mb-2">Dark Theme:</h6>
        <a class="theme-item" href="../../../demo2/dashboard.html">
          <img src="../../../assets/images/screenshots/dark.jpg" alt="light theme">
        </a>
      </div>
    </div>
  </nav>
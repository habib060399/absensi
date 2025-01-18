<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Flockbase<span>ID</span>
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
          @role('admin')
            <a href="{{route('homeAdmin')}}" class="nav-link">
          @endrole
          @role('sekolah')
            <a href="{{route('homeSekolah')}}" class="nav-link">
          @endrole
          @role('kelas')
            <a href="{{route('homeSekolah')}}" class="nav-link">
          @endrole
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
        </li><li class="nav-item">
          <a href="" class="nav-link">
            <i class="link-icon" data-feather="speaker"></i>
            <span class="link-title">Backup Data</span>
          </a>
        </li>
          <li class="nav-item">
              <a href="{{route('invoice')}}" class="nav-link">
                  <i class="link-icon" data-feather="speaker"></i>
                  <span class="link-title">Invoice</span>
              </a>
          </li>
        @endrole
        @role('kelas|sekolah')
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="book"></i>
            <span class="link-title">Absensi</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="uiComponents">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('live_absen')}}" class="nav-link" id="absensi_live">Absensi Live</a>
              </li>
              <li class="nav-item">
                <a href="{{route('absen')}}" class="nav-link" id="data_absen">Data Absen</a>
              </li>
              <li class="nav-item">
                <a href="{{route('rekap')}}" class="nav-link" id="rekap">Rekapitulasi Absen</a>
              </li>
            </ul>
          </div>
        </li>
        @endrole
        @role('sekolah')
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Sekolah</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
                @jurusan
              <li class="nav-item">
                <a href="{{route('jurusan')}}" class="nav-link" id="jurusan">Jurusan</a>
              </li>
                @endjurusan
              <li class="nav-item">
                <a href="{{route('kelas')}}" class="nav-link" id="kelas">Kelas</a>
              </li>
              <li class="nav-item">
                <a href="{{route('siswa')}}" class="nav-link">Siswa</a>
              </li>
              <li class="nav-item">
                <a href="{{route('guru')}}" class="nav-link">Guru</a>
              </li>
            </ul>
          </div>
        </li>
        @endrole
        @role('kelas')
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Sekolah</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">                              
              <li class="nav-item">
                <a href="{{route('siswa')}}" class="nav-link">Siswa</a>
              </li>              
            </ul>
          </div>
        </li>
        @endrole
        @can('message wa')
        <li class="nav-item">
          <a href="{{route('bc')}}" class="nav-link">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Kirim Pesan</span>
          </a>
        </li>
        @endcan
        @role('sekolah')
        <li class="nav-item nav-category">Settings</li>
        <li class="nav-item">
          <a href="{{route('pesan')}}" class="nav-link">
            <i class="link-icon" data-feather="inbox"></i>
            <span class="link-title">Pesan</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Sekolah</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('wa')}}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Whatssap</span>
          </a>
        </li>
        @endrole
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

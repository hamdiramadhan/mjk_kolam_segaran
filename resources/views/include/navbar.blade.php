<nav class="navbar navbar-expand-lg align-items-center">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center">
                <div class="">
                    <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                </div>
                <div class="">
                    <h4 class="logo-text">{!! env('APP_NAME') !!}</h4>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav align-items-center flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i>
                        </div>
                        <div class="menu-title d-flex align-items-center">Dashboard</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sub_kegiatan') ? 'active' : '' }}"
                        href="{{ route('sub_kegiatan') }}">
                        <div class="parent-icon">
                            <i class="lni lni-bookmark-alt"></i>
                        </div>
                        <div class="menu-title d-flex align-items-center">Sub Kegiatan</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sub_kegiatan_rincian') ? 'active' : '' }}"
                        href="{{ route('sub_kegiatan_rincian') }}">
                        <div class="parent-icon">
                            <i class="fadeIn animated bx bx-shape-polygon"></i>
                        </div>
                        <div class="menu-title d-flex align-items-center">Rincian Murni</div>
                    </a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret 
                    {{ Request::is('pengajuan*') ? 'active' : '' }}"
                        href="javascript:;" data-bs-toggle="dropdown">
                        <div class="parent-icon"><i class='bx bx-comment'></i>
                        </div>
                        <div class="menu-title d-flex align-items-center">Pengajuan Perubahan</div>
                        <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
                    </a>
                    <ul class="dropdown-menu">
                        <li style="text-align: center">
                            <span style="text-align: center"><b><u>OPD</u></b></span>
                        </li>
                        <li><a class="dropdown-item {{ Request::is('pengajuan') ? 'active' : '' }}"
                                href="{{ route('pengajuan.index') }}">Draft</a></li>
                        <li><a class="dropdown-item {{ Request::is('pengajuan/proses') ? 'active' : '' }}"
                                href="{{ route('pengajuan.proses') }}">Proses</a>
                        </li>
                        <li><a class="dropdown-item {{ Request::is('pengajuan/selesai') ? 'active' : '' }}"
                                href="{{ route('pengajuan.selesai') }}">Selesai</a></li>

                        <li style="text-align: center">
                            <span style="text-align: center"><b><u>Verifikator</u></b></span>
                        </li>

                        <li><a class="dropdown-item {{ Request::is('pengajuan/masuk') ? 'active' : '' }}"
                                href="{{ route('pengajuan.masuk') }}">Usulan Masuk</a></li>
                        <li><a class="dropdown-item {{ Request::is('pengajuan/selesai_verif') ? 'active' : '' }}"
                                href="{{ route('pengajuan.selesai_verif') }}">Selesai</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('*report*') ? 'active' : '' }}"
                        href="{{ route('report.index') }}">
                        <div class="parent-icon">
                            <i class="lni lni-book"></i>
                        </div>
                        <div class="menu-title d-flex align-items-center">Report</div>
                    </a>
                </li>
                @if (Auth::user()->role_id == 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret 
                        {{ Request::is('master_opd*') ? 'active' : '' }}
                        {{ Request::is('master_sub_opd*') ? 'active' : '' }}
                        {{ Request::is('usulan*') ? 'active' : '' }}
                        "
                            href="javascript:;" data-bs-toggle="dropdown">
                            <div class="parent-icon"><i class='bx bx-cube'></i>
                            </div>
                            <div class="menu-title d-flex align-items-center">Master</div>
                            <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
                        </a>
                        <ul class="dropdown-menu">

                            <li style="text-align: center">
                                <span style="text-align: center"><b><u>Pengaturan</u></b></span>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('fase*') ? 'active' : '' }}"
                                    href="{{ route('fase.index') }}">
                                    Fase
                                </a>
                            </li>

                            <li style="text-align: center">
                                <span style="text-align: center"><b><u>OPD</u></b></span>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('usulan*') ? 'active' : '' }}"
                                    href="{{ route('jenis_usulan.index') }}">
                                    Jenis Usulan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('master_opd*') ? 'active' : '' }}"
                                    href="{{ route('master_opd') }}">
                                    SKPD
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('master_sub_opd') }}">Sub SKPD</a></li>
                            <li><a class="dropdown-item" href="{{ route('sumber_dana.index') }}">Sumber Dana</a></li>
                            <li style="text-align: center">
                                <span style="text-align: center"><b><u>Pengguna</u></b></span>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    User
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="theme-color" content="#FAD02C" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with Creative Design landing page.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ URL::full() }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link rel="shortcut icon" href="{{ asset('./assets/image/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/favicon-16x16.png') }}" sizes="16x16"/>
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/android-chrome-192x192.png') }}" sizes="192x192"/>
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/android-chrome-512x512.png') }}" sizes="512x512"/>
    <link href="{{ asset(mix('css/all.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/summernote.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.7/viewer.min.css" />
    @stack('link')
    @notifyCss
    <style>
        .pull-left{float:left!important;}
        .pull-right{float:right!important;}
        </style>
</head>
<body id="page-top" data-user="{{ Auth::user()->id }}">
    <div id="wrapper">
        <ul class="navbar-nav sidebar bg-gradient-primary sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:void(0)">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('assets/image/logo.png') }}" width="25">
                </div>
                <div class="sidebar-brand-text ml-3 text-warning">Miftahul Huda</div>
            </a>
            <hr class="sidebar-divider my-0">
            @hasanyrole('ketua yayasan|kepala sekolah|bendahara')
                <li class="nav-item {{ Request::routeIs('home') ? 'active' : '' }}">
                    <a class="nav-link" href="/home">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endhasanyrole
            @hasanyrole('super admin')
                <li class="nav-item {{ Request::routeIs('sekolah.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('sekolah.index')}}">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Sekolah</span>
                    </a>
                </li>
            @endhasanyrole
            @hasanyrole('kepala sekolah|bendahara|admin sekolah')
                <li class="nav-item {{ Request::routeIs('sekolah.show') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('sekolah.show', Auth::user()->karyawan->sekolah_id) }}">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Profil Sekolah</span>
                    </a>
                </li>
            @endhasanyrole
            @hasanyrole('super admin|bendahara|admin sekolah')
                <li class="nav-item {{ Request::routeIs('jabatan.*') || Request::routeIs('karyawan.*') || Request::routeIs('index_guru') || Request::routeIs('gaji.*') || Request::routeIs('tunjangan.*') || Request::routeIs('tunjangan_have_karyawan.*') || Request::routeIs('masa_kerja.*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#karyawan" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Karyawan</span>
                    </a>
                    <div id="karyawan" class="collapse {{ Request::routeIs('jabatan.*') || Request::routeIs('karyawan.*') || Request::routeIs('index_guru') || Request::routeIs('gaji.*') || Request::routeIs('tunjangan.*') || Request::routeIs('tunjangan_have_karyawan.*') || Request::routeIs('masa_kerja.*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Karyawan dan Guru:</h6>
                            @hasanyrole('super admin|admin sekolah')
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('jabatan.*') ? 'active' : '' }}" href="{{ route('jabatan.index') }}">Jabatan</a>
                            @endhasanyrole
                            @hasanyrole('admin sekolah|bendahara')
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('karyawan.*') ? 'active' : '' }}" href="{{ route('karyawan.index') }}">Data Karyawan</a>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('index_guru') ? 'active' : '' }}" href="{{ route('index_guru') }}">Data Guru</a>
                            @endhasanyrole
                            @hasanyrole('super admin')
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('karyawan.*') ? 'active' : '' }}" href="{{ route('karyawan.index') }}">Data Karyawan</a>
                            @endhasanyrole
                            @hasanyrole('bendahara')
                                <h6 class="collapse-header mt-2">Input Tunjangan:</h6>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('gaji.*') ? 'active' : '' }}" href="{{ route('gaji.index') }}">Input Gaji</a>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('tunjangan.*') ? 'active' : '' }}" href="{{ route('tunjangan.index') }}">Jenis Tunjangan</a>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('tunjangan_have_karyawan.*') ? 'active' : '' }}" href="{{ route('tunjangan_have_karyawan.index') }}">Tunjangan Karyawan</a>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('masa_kerja.*') ? 'active' : '' }}" href="{{ route('masa_kerja.index') }}">Input T.Masa Kerja</a>
                            @endhasanyrole
                        </div>
                    </div>
                </li>
            @endhasanyrole
            @hasanyrole('ketua yayasan')
                <li class="nav-item {{ Request::routeIs('belanja') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('belanja') }}">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pengajuan Belanja</span>
                    </a>
                </li>
            @endhasanyrole
            @hasanyrole('admin sekolah|bendahara')
                <li class="nav-item {{ Request::routeIs('siswa.*') || 
                    Request::routeIs('spp.*') || 
                    Request::routeIs('iuran.*') || 
                    Request::routeIs('dps.*') || 
                    Request::routeIs('pembayaran') || 
                    Request::routeIs('cek_pembayaran') || 
                    Request::routeIs('kelas.*') || 
                    Request::routeIs('subkelas.*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#siswa" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Siswa</span>
                    </a>
                    <div id="siswa" class="collapse {{ Request::routeIs('siswa.*') || 
                    Request::routeIs('spp.*') || 
                    Request::routeIs('iuran.*') || 
                    Request::routeIs('dps.*') || 
                    Request::routeIs('pembayaran') || 
                    Request::routeIs('cek_pembayaran') ||
                    Request::routeIs('kelas.*') || 
                    Request::routeIs('subkelas.*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @hasanyrole('admin sekolah')
                                <h6 class="collapse-header">Data Siswa:</h6>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('kelas.*') ? 'active' : '' }}" href="{{ route('kelas.index') }}">Data Kelas</a>
                            @endhasanyrole
                            @hasanyrole('admin sekolah')
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('siswa.*') ? 'active' : '' }}" href="{{ route('siswa.index') }}">Data Siswa</a>
                            @endhasanyrole
                            @hasanyrole('bendahara')
                                <h6 class="collapse-header mt-2">Data Iuran:</h6>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('spp.*') ? 'active' : '' }}" href="{{ route('spp.index') }}">Input SPP</a>
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('iuran.*') ? 'active' : '' }}" href="{{ route('iuran.index') }}">Input Jenis Iuran</a>
                                @if(Auth::user()->karyawan)
                                    @if(Auth::user()->karyawan->sekolah_id == 1)
                                        <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('dps.*') ? 'active' : '' }}" href="{{ route('dps.index') }}">Input Jariyah Peng. Sekolah</a>
                                    @else
                                        <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('dps.*') ? 'active' : '' }}" href="{{ route('dps.index') }}">Input BP/DPS</a>
                                    @endif
                                @endif
                                <a style="gap: .5rem;" class="collapse-item d-flex align-items-center {{ Request::routeIs('pembayaran') || Request::routeIs('cek_pembayaran') ? 'active' : '' }}" href="{{ route('pembayaran') }}">Pembayaran Iuran & SPP</a>
                            @endhasanyrole
                        </div>
                    </div>
                </li>
            @endhasanyrole
            @hasanyrole('bendahara')
                <li class="nav-item {{ Request::routeIs('anggaran_pendapatan.*') || Request::routeIs('pendapatan') || Request::routeIs('belanja') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#anggaran"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Anggaran</span></a>
                    </a>
                    <div id="anggaran" class="collapse {{ Request::routeIs('anggaran_pendapatan.*') || Request::routeIs('pendapatan') || Request::routeIs('belanja') ? 'show' : '' }}" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ Request::routeIs('anggaran_pendapatan.*') ? 'active' : '' }}" href="{{ route('anggaran_pendapatan.index') }}">Anggaran Pendapatan</a>
                            <a class="collapse-item {{ Request::routeIs('pendapatan') ? 'active' : '' }}" href="{{ route('pendapatan') }}">Input Pendapatan</a>
                            <a class="collapse-item {{ Request::routeIs('belanja') ? 'active' : '' }}" href="{{ route('belanja') }}">Pengajuan Belanja</a>
                        </div>
                    </div>
                </li>
            @endhasanyrole
            @hasanyrole('ketua yayasan|kepala sekolah')
                <li class="nav-item {{ Request::routeIs('laporan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('laporan') }}">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            @endhasanyrole
            @hasanyrole('super admin|ketua yayasan')
                <li class="nav-item {{ Request::routeIs('pemilik.*') ? 'active' : '' }}">
                    <a class="nav-link" href={{ route('pemilik.index') }}>
                        <i class="fas fa-fw fa-user"></i>
                        <span>Pemilik</span>
                    </a>
                </li>
            @endhasanyrole
            
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" width="50" style="border: 1px solid blanchedalmond; border-radius: 50%;" src="{{ Auth::user()->pemilik ? Auth::user()->pemilik->picture : Auth::user()->karyawan->picture }}" alt="{{ Auth::user()->name }}">
                <p class="text-center mb-2">
                    <strong class="text-capitalize">{{ Auth::user()->pemilik ? Auth::user()->pemilik->nama : Auth::user()->karyawan->nama }}</strong>
                </p>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        @hasanyrole('ketua yayasan')
                            <li class="nav-item dropdown no-arrow mx-1 show">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <span class="badge badge-danger badge-counter">{{ Auth::user()->unreadNotifications->count() }}</span>
                                </a>
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown" style="width: 400px !important;">
                                    <h5 class="dropdown-header" style="font-size: small;">
                                        Notifikasi Pengajuan Belanja
                                    </h5>
                                    @forelse (auth()->user()->unreadnotifications as $notification)
                                        <form method="get" action="{{ route('asread', $notification->id) }}" onsubmit="return confirm('Lihat notifikasi ini?');">
                                            @csrf
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" style="gap: .3rem">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <div class="text-truncate">{{ $notification->data['sub_belanja'] }}</div>
                                                    <div class="small text-gray-500">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</div>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success">lihat</button>
                                            </a>
                                        </form>
                                    @empty
                                        <div class="p-3">
                                            <p class="text-center">Tidak ada notif</p>
                                        </div>
                                    @endforelse
                                </div>
                            </li>
                        @endhasanyrole
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->karyawan)
                                    @php $jabatan = DB::table('jabatan')->where('id', Auth::user()->karyawan->jabatan_id)->first(); @endphp
                                @endif
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-capitalize">{{ Auth::user()->karyawan ? $jabatan->nama : 'ketua yayasan' }}</span>
                                <img class="img-profile rounded-circle" src="{{ Auth::user()->pemilik ? Auth::user()->pemilik->picture : Auth::user()->karyawan->picture }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ Auth::user()->pemilik ? route('pemilik.show', Auth::user()->pemilik->id) : route('karyawan.show', Auth::user()->karyawan->id) }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Data Diri
                                </a>
                                <div class="dropdown-divider"></div>
                                @hasanyrole('ketua yayasan|bendahara|admin sekolah|kepala sekolah')
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#ganti-password">
                                        <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Ganti Password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endhasanyrole
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid" style="max-height: 750px; overflow-y: scroll;">
                    @yield('content')
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container-fluid">
                    <span>Copyright &copy; Yayasan Miftahul Huda - {{ date('Y') }}</span>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keluar dari aplikasi?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('logout') }}" id="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary"> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ganti-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                    <button class="close" type="button" id="cancel-ganti-password" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('ganti_password') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password_lama" id="password_lama" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <a href="#" id="show_password_lama"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('password_lama'))
                                        <span class="text-danger">{{ $errors->first('password_lama') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password_baru" id="password_baru" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <a href="#" id="show_password_baru"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password_baru')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Konfirm Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="confirm" id="confirm" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <a href="#" id="show_confirm"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    @error('confirm')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-warning" >Ganti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($errors->has('password_lama') || $errors->has('password_baru') || $errors->has('confirm'))
        <script>
            window.addEventListener('load', function() {
                var modal_kelas = document.getElementById('ganti-password');
                var cancel_modal_kelas = document.querySelector('#cancel-ganti-password');
                if (modal_kelas) {
                    modal_kelas.classList.add('show');
                    modal_kelas.style.display = 'block';
                    modal_kelas.setAttribute('aria-modal', 'true');
                }
                if (cancel_modal_kelas) {
                    cancel_modal_kelas.addEventListener('click', function() {
                        if (modal_kelas) {
                            modal_kelas.classList.remove('show');
                            modal_kelas.style.display = 'none';
                            modal_kelas.setAttribute('aria-modal', 'false');
                        }
                    });
                }
            });
        </script>
    @endif
    <div class="modal fade" id="modal-information" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        Selamat datang di aplikasi APBS &nbsp;<span class="badge badge-success">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script defer src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script defer src="{{ asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script defer src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script defer src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script defer src="{{ asset('assets/js/select2/select2.js')}}"></script> 
    <script defer src="{{ asset('assets/js/noty/jquery.noty.js') }} "></script>
    <script defer src="{{ asset('assets/js/noty/layouts/topCenter.js')}} "></script>
    <script defer src="{{ asset('assets/js/noty/themes/default.js') }} "></script>
    <script defer src="{{ asset('/sw.js') }}"></script>
    <script>
        window.onload = function() {
            localStorage.setItem("scrollPos", window.scrollY);
        }

        window.onload = function() {
            var scrollPos = localStorage.getItem("scrollPos");
            if (scrollPos) {
                window.scrollTo(0, scrollPos);
                localStorage.removeItem("scrollPos");
            }
        }

        $(document).ready( function (e) {
            var USER_ID = $('#page-top').data('user');
            Pusher.logToConsole = true;
            var pusher = new Pusher('2029c7471d4c9431b060', {
                cluster: 'ap1',
                encrypted: true
            });

            var channel = pusher.subscribe('pengajuan.' + USER_ID);
            channel.bind('App\\Events\\Belanja', function(data) {
                // Pengecekan apakah user yang sedang login memiliki role "ketua yayasan"
                if (data.recipient_role === 'ketua yayasan') {
                    alert(JSON.stringify(data.pengajuan));
                }
            });

            if(sessionStorage.getItem('WELCOME') !== 'true') {
                $('#modal-information').modal({backdrop: 'static', keyboard: false, show:true});
                sessionStorage.setItem('WELCOME', true);
            }
            setTimeout(function() {
                $('#modal-information').modal('hide');
            }, 2000);
            $('#logout-button').on('click', function() {
                sessionStorage.removeItem('WELCOME');
            });

            $('#show_password_lama').click(function() {
                var password = $('#password_lama');
                var icon = $(this).find('i');

                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye-slash');
                    icon.addClass('fa-eye');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye');
                    icon.addClass('fa-eye-slash');
                }
            });

            $('#show_password_baru').click(function() {
                var password = $('#password_baru');
                var icon = $(this).find('i');

                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye-slash');
                    icon.addClass('fa-eye');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye');
                    icon.addClass('fa-eye-slash');
                }
            });
            $('#show_confirm').click(function() {
                var password = $('#confirm');
                var icon = $(this).find('i');

                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye-slash');
                    icon.addClass('fa-eye');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye');
                    icon.addClass('fa-eye-slash');
                }
            });
        });
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    @stack('javascript')
    @include('notify::messages')
    <x:notify-messages />
    @notifyJs
</body>
</html>

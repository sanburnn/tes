<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="theme-color" content="#FAD02C" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with Creative Design landing page.">
        <meta name="author" content="Yayasan Miftahul Huda">
        <title>Yayasan Miftahul Huda</title>
        <link rel="canonical" href="{{ URL::full() }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <link rel="shortcut icon" href="{{ asset('./assets/image/favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset('./assets/image/favicon-16x16.png') }}" sizes="16x16"/>
        <link rel="apple-touch-icon" href="{{ asset('./assets/image/favicon-32x32.png') }}" sizes="32x32"/>
        <link rel="apple-touch-icon" href="{{ asset('./assets/image/android-chrome-192x192.png') }}" sizes="192x192"/>
        <link rel="apple-touch-icon" href="{{ asset('./assets/image/android-chrome-512x512.png') }}" sizes="512x512"/>
        <link rel="stylesheet" href="{{ asset('assets/index/vendors/themify-icons/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/index/css/creative-design.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>.fixed-top {position: fixed;top: 0;right: 0;left: 0;z-index: 1 !important;}</style>
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
        <nav id="scrollspy" class="navbar page-navbar navbar-light navbar-expand-md fixed-top" data-spy="affix" data-offset-top="20">
            <div class="container">
                <a class="navbar-brand" href="#"><strong class="text-primary">Yayasan</strong> <span class="text-dark">Miftahul Huda</span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#school">School</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item dropdown ml-md-4">
                            @guest
                                <a class="nav-link btn btn-primary" href="{{ route('login') }}">Login</a>
                            @else
                                <a class="nav-link btn btn-primary dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->pemilik ? Auth::user()->pemilik->nama : Auth::user()->karyawan->nama }}</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ Auth::user()->karyawan ? Auth::user()->hasRole('super admin') ? route('sekolah.index') : (Auth::user()->hasRole('admin sekolah') ? route('sekolah.show', Auth::user()->karyawan->sekolah_id) : route('home')) : route('home')  }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="javascript:vdoi(0)" data-toggle="modal" data-target="#logoutModal">Logout</a></li>
                                </ul>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>   
        <header id="home" class="header">
            <div class="overlay"></div>
            <div class="header-content">
                <p>YAYASAN</p>
                <h1>Miftahul Huda</h1> 
            </div>      
        </header> 
        <section id="about">
            <div class="container">
                <div class="about-wrapper">
                    <div class="after"><h2>About Us</h2></div>
                    <div class="content">
                        <h3 class="title mb-3"> Sejarah Yayasan Miftahul Huda.</h3>
                        <div class="row">
                            <div class="col">
                                <p>Seperti kebanyakan pesantren, Pondok Pesantren Miftahul Huda Kroya juga memiliki sejarah perjalanan yang panjang.  Meski diresmikan pada 1960-an, namun cikal bakal pesantren ini telah bermula pada masa sebelum kemerdekaan.</p>                        
                                <p>Embrio pesantren ini berasal dari dua buah asrama sederhana dan sebuah mushola kecil di sebelah selatan stasiun Kroya yang dirintis oleh K. H. M. Minhajul Adzkiya. Tidak diketahui dengan pasti tarikh pendirian pesantren tersebut. Sejauh yang bisa diingat, pesantren tersebut telah ada pra Kemerdekaan. Meski demikian, jumlah santri pada masa awal ini mencapai  200 orang yang berasal dari wilayah Kroya dan sekitarnya.</p>
                            </div>
                            <div class="col">
                                <p>Sayangnya, sebelum sempat berkembang lebih jauh, pada masa Aksi Militer Belanda II (Clash II), Kyai Adzkiya, para santri, dan beberapa warga terpaksa mengungsi. Awalnya, beliau mengungsi ke wilayah Ngasinan, sebuah wilayah di Kebasen, Kabupaten Banyumas, dan kemudian ke Rawaseser, dusun kecil yang merupakan bagian dari Desa Mujur Lor, kecamatan Kroya. Di tengah kesulitan hidup sebagai pengungsi, Kyai Adzkiya tetap istiqomah mengajar para santri yang mengiringi beliau.</p>
                                <p>Ketika kondisi telah aman Pasca Clash II, Kyai Adzkiya dan para santrinya kembali ke Kroya dan mendapati pesantrennya telah rata dengan tanah. Sekali lagi, Kyai Adzkiya harus pindah. Dan, tempat yang kali ini dituju adalah Kauman, Kroya.</p>
                            </div>
                        </div>                
                    </div>
                </div>        
            </div>       
        </section>
        <section>
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <div class="img-wrapper">
                            <div class="after"></div>
                            <img src="assets/index/imgs/foto1.jpg" loading="lazy" class="w-100" width="auto" height="auto" alt="About Us" title="About Us">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h3 class="title mb-3">Lanjutan Sejarah.</h3>
                        <p align="justify">Selama beberapa waktu Kyai Adzkiya tinggal di Kauman, Kroya, mengajar santri  sembari menjadi pimpinan Kantor Urusan Agama (KUA) kecamatan Kroya hingga kemudian harus pindah lagi ketika diminta untuk memimpin Pengadilan Agama di Kabupaten Wonosobo. Di Wonosobo, Kyai Adzkiya tinggal hingga tahun 1962 seiring dengan datangnya masa pension. Selepas pensiun, Kyai Adzkiya kembali ke Kroya dan kali ini beliau tinggal di wilayah Semingkir, Bajing Kulon. Pada tahun 1960-an, bersama dengan beberapa kolega kyai lainnya, di antaranya K. H. Munawir al-Hafidz, Kyai Adzkiya kembali merintis pesantren yang hingga saat ini dikenal dengan nama Pesantren Miftahul Huda. Sepeninggal kiai Adzkiya, pondok pesantren Miftahul Huda diasuh secara berturut-turut oleh KH Tarmidzi Affandi, KH Zainuddin, KH. Hamam Adzkiya, KH Suíada, dan Hj Mas’adah Machali untuk pondok pesantren putri al-Hidayah.<p>
                    </div>
                </div>
            </div>  
        </section>  
        <section>
            <div class="container">
                <div class="row justify-content-between align-items-center">                
                    <div class="col-md-5">
                        <h3 class="title mb-3">Lanjutan Sejarah.</h3>
                        <p align="justify">Saat ini, pondok pesantren Miftahul Huda dan pondok pesantren putri Al-Hidayah mendidik sekitar 350-an santri dan diasuh oleh putra KHM Minhajul Adzkiya yang egaliter, tetapi tetap tegas, yaitu KH Hamam Adzkiya, KH Suíada Adzkiya, dan Hj Masíadah Machali, juga KH. Mudatsir Mughni yang, dibantu oleh para pengurus dan dewan asatidz. Lebih kurang 75% santri mengikuti pendidikan formal baik SD, SLTP, dan SMA/SMK yang diselenggarakan oleh Yayasan Miftahul Huda Kroya dan di luar yayasan, seperti SMP Negeri, SMA Negeri, MAN, dan lain-lain. Sebanyak 25% lainnya, khusus mendalami kajian ilmu-ilmu keagamaan masuk di dalam Halaqah Diniyah, yang terdiri atas kelas persiapan (Iídad), kelas satu, dua, dan kelas tiga.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="img-wrapper">
                            <div class="after right"></div>
                            <img src="assets/index/imgs/foto2.webp" loading="lazy" class="w-100" width="auto" height="auto" alt="About Us" title="About Us">
                        </div>                      
                    </div>
                </div>          
            </div>    
        </section>
        <section class="has-bg-img" id="features">
            <div class="overlay"></div>
            <a href="javascript:void()" data-toggle="modal" data-target="#exampleModalCenter">
                <i></i>
            </a>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <iframe width="100%" height="500" src="https://www.youtube.com/embed/XeI95AQYzd0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
            </div>   
        </section>  
        <section>
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <div class="img-wrapper">
                            <div class="after"></div>
                            <img src="assets/index/imgs/header.jpg" loading="lazy" class="w-100" width="auto" height="auto" alt="About us" title="About us">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h3 class="title mb-3">Lanjutan Sejarah.</h3>
                        <p align="justify">Konsep pengelolaannya lebih diorientasikan pada peningkatan dan pengembangan secara kualitatif, dengan tanpa mengabaikan yang kuantitatif. Semua santri diperlakukan sama. Qanun pesantren berlaku untuk semua santri tanpa kecuali. Kurikulum pesantren disusun berdasarkan kebutuhan dan tingkat kemampuan santri. Tetapi pesantren memberikan kebebasan kepada seluruh santri, untuk bereksplorasi sendiri, dengan memanfaatkan perpustakaan yang tersedia. Untuk mengikuti perkembangan situasi sosial politik budaya, dan lain-lain, pesantren berlangganan Suara Merdeka.</p>
                    </div>
                </div>       
            </div>    
        </section> 
        <section class="text-center" id="school">
            <div class="container">
                <h3 class="mt-3 mb-5 pb-5">Our School</h3>
                <div class="row">
                    @forelse ($sekolah as $item)
                        @if ($item->id == 2)
                            <div class="col-sm-10 col-md-3 m-auto">
                                <div class="testmonial-wrapper">
                                    <img src="{{ asset($item->picture) }}" loading="lazy" alt="Client Image" title="SMP Masyitoh Kroya" width="auto" height="auto">
                                    <h4 class="title mb-3" style="font-size: larger;">SMP Masyitoh Kroya</h4>
                                    <p align="justify">{{ $item->keterangan ?? '' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-10 col-md-3 m-auto">
                                <div class="testmonial-wrapper">
                                    <img src="{{ asset($item->picture) }}" loading="lazy" alt="Client Image" title="{{ $item->nama ?? '' }}" width="auto" height="auto">
                                    <h4 class="title mb-3" style="font-size: larger;">{{ $item->nama ?? '' }}</h4>
                                    <p align="justify">{{ $item->keterangan ?? '' }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <h4 class="text-center">Data sekolah belum ditambahkan</h4>
                    @endforelse
                </div>          
            </div>
        </section>
        <section class="pb-0" id="contact">
            <div class="container">
                <div class="pre-footer">
                    <ul class="list">
                        <li class="list-head">
                            <h5 class="font-weight-bold">ABOUT US</h5>
                        </li>
                        <li class="list-body">
                            <p>
                            <div class="social-links">
                                <a href="https://www.facebook.com/mifda.putri.90"><i class="ti-facebook"></i></a>
                                <a href="https://twitter.com/mifdakroya"><i class="ti-twitter-alt"></i></a>
                                <a href="https://www.youtube.com/c/MifdaPutraKroya"><i class="ti-youtube"></i></a>
                                <a href="https://www.instagram.com/mifda_kroya/"><i class="ti-instagram"></i></a>
                            </div></p>
                            <a href="{{ url('/') }}"><strong class="text-primary">YAYASAN</strong> <span class="text-dark">Miftahul Huda</span></a>
                        </li>
                    </ul>
                    <ul class="list">
                        <li class="list-head">
                            <h5 class="font-weight-bold">CONTACT INFO</h5>
                        </li>
                        <li class="list-body">
                            <p>Contact us and we'll get back to you within 24 hours.</p>
                            <p><i class="ti-location-pin"></i> Jalan Merak No. 28, -, Kec. Kroya, Kab. Cilacap Prov. Jawa Tengah</p>
                            <p><i class="ti-email"></i>  yayasanmiftahulhudakroya@yahoo.co.id</p>
                            <p><i class="fa fa-phone"></i> 0282494689</p>
                        </li>
                    </ul> 
                </div>         
                <footer class="footer">            
                    <p>Copyright <script>document.write(new Date().getFullYear())</script> &copy; <a>Yayasan Miftahul Huda</a></p>
                </footer> 
            </div>    
        </section>
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
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
                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-primary">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <script defer src="{{ asset(mix('js/home.min.js')) }}"></script>
        <script defer src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function (reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>
</html>

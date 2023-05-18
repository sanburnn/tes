<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with Creative Design landing page.">
    <meta name="author" content="Devcrud">
    <title>Yayasan Miftahul Huda</title>
    <link rel="shortcut icon" href="{{ asset('./assets/image/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/favicon-16x16.png') }}" sizes="16x16"/>
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/android-chrome-192x192.png') }}" sizes="192x192"/>
    <link rel="apple-touch-icon" href="{{ asset('./assets/image/android-chrome-512x512.png') }}" sizes="512x512"/>
    <link rel="stylesheet" href="{{ asset ('assets/index/vendors/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset ('assets/index/css/creative-design.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="bg-gradient" style="background-color: #f8f9fa">
    <div class="login-center">
        <div class="about-wrapper">
            <div class="after"><h1>WELCOME</h1></div>
            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif
            <div class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img class="img" src="{{asset('assets/image/logo.png')}}" style="width: 300px; margin-top: 25px; margin-left: 80px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h4><strong style="color: #FAD02C">Welcome</strong> <strong>Back!</strong></h4>
                            </div>
                            <form method="POST" action="{{ route('login') }}" class="user">
                                @csrf
                                <input type="hidden" name="returnUrl" value="{{ $returnUrl ?? '' }}">
                                <div class="form-group">
                                    <input type="email" id="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" aria-describedby="emailHelp" placeholder="Masukan email" autofocus="" required autocomplete="off">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <a href="#" id="show_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <button class="btn btn btn-user btn-block submit" type="submit" style="background-color: #FAD02C">Login</button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a class="btn btn-secondary btn-user btn-block" style="margin-bottom: 5px" href="/">Kembali</a>
                                    </div>
                                </div>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    </div>
    <div class="loading-page">
        <svg id="svg" width="309.4700073242187px" height="153.44000549316405px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="95.26499633789064 -1.7200027465820256 309.4700073242187 153.44000549316405" style="background: rgba(0, 0, 0, 0);" preserveAspectRatio="xMidYMid"><defs><filter id="editing-reflect" x="-100%" y="-100%" width="300%" height="300%" primitiveUnits="objectBoundingBox"><feFlood flood-color="#704601" result="flood"></feFlood><feComposite operator="in" in="flood" in2="SourceAlpha" result="flood-in"></feComposite><feImage width="100%" height="100%" x="0" y="0" preserveAspectRatio="none" xlink:href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMTIuODQ1NTk2MzEzNDc2NTZweCIgaGVpZ2h0PSI5OC4xMTc2NTI4OTMwNjY0cHgiIHZpZXdCb3g9IjAgMCAyMTIuODQ1NTk2MzEzNDc2NTYgOTguMTE3NjUyODkzMDY2NCI+CjxkZWZzPgogIDxsaW5lYXJHcmFkaWVudCBpZD0icmVmbGVjdC1ncmFkaWVudCIgeDE9IjAiIHgyPSIwIiB5MT0iMCIgeTI9IjEiPgogICAgPHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZmZmNGI3IiBzdG9wLW9wYWNpdHk9IjAuMCIvPgogICAgPHN0b3Agb2Zmc2V0PSIwLjMiIHN0b3AtY29sb3I9IiNmZmY0YjciIHN0b3Atb3BhY2l0eT0iMC4wIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmZmY0YjciIHN0b3Atb3BhY2l0eT0iMC45Ii8+CiAgPC9saW5lYXJHcmFkaWVudD4KPC9kZWZzPgo8cGF0aCBkPSJNMCAwIEwwIDQ0LjE1Mjk0MzgwMTg3OTg4NiBRMTA2LjQyMjc5ODE1NjczODI4IDYzLjc3NjQ3NDM4MDQ5MzE3IDIxMi44NDU1OTYzMTM0NzY1NiA0NC4xNTI5NDM4MDE4Nzk4ODYgTDIxMi44NDU1OTYzMTM0NzY1NiAwIFoiIGZpbGw9InVybCgjcmVmbGVjdC1ncmFkaWVudCkiLz4KPC9zdmc+" result="image"></feImage><feComposite operator="in" in="image" in2="SourceAlpha" result="image-in"></feComposite><feGaussianBlur in="flood-in" stdDeviation="0.003 0.03" result="blur"></feGaussianBlur><feOffset in="blur" dx="0" dy="0.03" result="offset"></feOffset><feComponentTransfer in="offset" result="comp"><feFuncA type="linear" slope="0.5" intercept="0"></feFuncA></feComponentTransfer><feMerge><feMergeNode in="comp"></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode><feMergeNode in="image-in"></feMergeNode></feMerge></filter></defs><g filter="url(#editing-reflect)"><g transform="translate(146.0994291305542, 104.40000343322754)"><path d="M38.30 1.68L38.30 1.68L38.30 1.68Q27.55 1.68 26.54-13.61L26.54-13.61L12.10-13.61L12.10-13.61Q10.42-9.74 9.24-6.38L9.24-6.38L7.06 0L-4.70 0L21.76-55.44L39.82-55.44L43.34-14.62L43.34-14.62Q44.18-5.80 47.54-3.19L47.54-3.19L47.54-3.19Q45.11 1.68 38.30 1.68ZM19.32-30.41L14.70-19.74L26.29-19.74L25.28-41.33L25.28-43.60L19.32-30.41ZM85.26-56.03L85.26-56.03L85.26-56.03Q105.84-56.03 105.84-41.50L105.84-41.50L105.84-41.50Q105.84-33.52 100.72-28.73L100.72-28.73L100.72-28.73Q95.68-23.94 86.86-23.94L86.86-23.94L86.86-23.94Q82.74-23.94 79.55-26.29L79.55-26.29L79.55-26.29Q78.04-27.30 77.03-28.64L77.03-28.64L77.03-28.64Q83.16-28.64 86.39-32.38L86.39-32.38L86.39-32.38Q89.63-36.12 89.63-43.43L89.63-43.43L89.63-43.43Q89.63-50.74 82.40-50.74L82.40-50.74L80.39-50.74L80.39-50.74Q79.88-50.74 79.46-50.65L79.46-50.65L69.80 0L51.58 0L61.91-55.02L61.91-55.02Q70.90-55.86 76.10-55.94L76.10-55.94L76.10-55.94Q81.31-56.03 85.26-56.03ZM105.42-0.42L105.42-0.42L116.00-55.44L116.00-55.44Q125.92-56.28 132.30-56.28L132.30-56.28L132.30-56.28Q138.68-56.28 142.80-55.73L142.80-55.73L142.80-55.73Q146.92-55.19 149.69-53.76L149.69-53.76L149.69-53.76Q155.23-51.07 155.23-43.68L155.23-43.68L155.23-43.68Q155.23-39.40 151.54-35.78L151.54-35.78L151.54-35.78Q148.09-32.51 144.31-31.75L144.31-31.75L144.31-31.75Q148.34-31.08 151.20-28.06L151.20-28.06L151.20-28.06Q154.22-24.86 154.22-19.91L154.22-19.91L154.22-19.91Q154.22-10.33 147.08-4.75L147.08-4.75L147.08-4.75Q139.94 0.84 125.92 0.84L125.92 0.84L125.92 0.84Q116.26 0.84 105.42-0.42ZM128.27-27.05L124.07-5.29L124.07-5.29Q124.82-5.21 124.99-5.21L124.99-5.21L125.75-5.21L125.75-5.21Q132.64-5.21 135.58-9.74L135.58-9.74L135.58-9.74Q137.76-13.27 137.76-19.74L137.76-19.74L137.76-19.74Q137.76-23.18 135.53-25.03L135.53-25.03L135.53-25.03Q133.31-26.88 128.27-27.05L128.27-27.05ZM141.04-43.60L141.04-43.60L141.04-43.60Q141.04-50.57 134.32-50.57L134.32-50.57L133.56-50.57L133.56-50.57Q133.22-50.57 132.72-50.48L132.72-50.48L129.36-32.76L130.20-32.76L130.20-32.76Q141.04-33.01 141.04-43.60ZM192.53-38.81L192.53-38.81L192.53-38.81Q193.79-41.33 193.79-43.68L193.79-43.68L193.79-43.68Q193.79-46.03 193.54-47.33L193.54-47.33L193.54-47.33Q193.28-48.64 192.70-49.64L192.70-49.64L192.70-49.64Q191.44-51.83 188.92-51.83L188.92-51.83L188.92-51.83Q185.81-51.83 183.29-49.56L183.29-49.56L183.29-49.56Q180.60-47.21 180.60-43.51L180.60-43.51L180.60-43.51Q180.60-41.16 182.24-39.35L182.24-39.35L182.24-39.35Q183.88-37.55 186.40-35.87L186.40-35.87L186.40-35.87Q188.92-34.19 191.77-32.51L191.77-32.51L191.77-32.51Q194.63-30.83 197.15-28.81L197.15-28.81L197.15-28.81Q202.94-24.19 202.94-17.98L202.94-17.98L202.94-17.98Q202.94-13.78 200.72-10.21L200.72-10.21L200.72-10.21Q198.49-6.64 194.80-4.03L194.80-4.03L194.80-4.03Q186.73 1.68 176.06 1.68L176.06 1.68L176.06 1.68Q167.41 1.68 162.96-1.13L162.96-1.13L162.96-1.13Q158.51-3.95 158.51-8.23L158.51-8.23L158.51-8.23Q158.51-15.88 164.47-17.81L164.47-17.81L164.47-17.81Q166.15-18.40 168.71-18.40L168.71-18.40L168.71-18.40Q171.28-18.40 174.22-17.30L174.22-17.30L174.22-17.30Q172.87-13.86 172.87-10.75L172.87-10.75L172.87-10.75Q172.87-4.03 177.66-4.03L177.66-4.03L177.66-4.03Q180.77-4.03 183.33-6.30L183.33-6.30L183.33-6.30Q185.89-8.57 185.89-11.13L185.89-11.13L185.89-11.13Q185.89-13.69 184.25-15.54L184.25-15.54L184.25-15.54Q182.62-17.39 180.18-18.86L180.18-18.86L180.18-18.86Q177.74-20.33 174.93-21.76L174.93-21.76L174.93-21.76Q172.12-23.18 169.68-25.20L169.68-25.20L169.68-25.20Q163.97-29.82 163.97-37.21L163.97-37.21L163.97-37.21Q163.97-42 166.32-45.74L166.32-45.74L166.32-45.74Q168.67-49.48 172.45-52.00L172.45-52.00L172.45-52.00Q180.01-57.12 189.29-57.12L189.29-57.12L189.29-57.12Q198.58-57.12 203.07-54.35L203.07-54.35L203.07-54.35Q207.56-51.58 207.56-46.87L207.56-46.87L207.56-46.87Q207.56-42.76 204.37-40.15L204.37-40.15L204.37-40.15Q201.60-37.97 198.24-37.97L198.24-37.97L198.24-37.97Q194.88-37.97 192.53-38.81Z" fill="#f7c551"></path></g></g>
        </svg>
        <div class="name-container">
            <div class="logo-name">Miftahul Huda</div>
        </div>
    </div>
    <script src="{{ asset('assets/index/vendors/jquery/jquery-3.4.1.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/index/js/creative-design.js') }}"></script>
    <script src="{{ asset('assets/js/login.js') }}"></script>
</body>
</html>
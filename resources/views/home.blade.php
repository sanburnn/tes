@extends('layouts.app')
@section('title', isset($title) ? $title : 'Beranda - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
    <div class="row">
        @hasanyrole('bendahara|kepala sekolah')
            <div class="col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_pendapatan) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belanja</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_belanja) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="lineChart" width="600" height="250"></canvas>
        @endhasanyrole
        @hasanyrole('ketua yayasan')
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan SD masyitoh kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_pendapatan_sd) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belanja SD masyitoh kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_belanja_sd) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan SMP masyitoh kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_pendapatan_smp) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belanja SMP masyitoh kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_belanja_smp) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan SMP masyitoh kroya INTENSIVE</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_pendapatan_smp_intv) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belanja SMP masyitoh kroya INTENSIVE</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_belanja_smp_intv) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan SMA ma`arif kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_pendapatan_sma) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belanja SMA ma`arif kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_belanja_sma) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan SMK ma`arif kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_pendapatan_smk) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belanja SMK ma`arif kroya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total_belanja_smk) }}</div>
                            </div>
                            <div class="col-auto font-weight-bold text-gray-800 h1">
                                <i class="fa fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <p class="h4 text-capitalize text-center">pendapatan dan belanja seluruh sekolah</p>
            </div>
            <canvas id="lineChart" width="600" height="250"></canvas>
        @endhasanyrole
    </div>
@endsection
@push('javascript')
    <script src="{{ asset('assets/js/Chart.js')}}"></script>
    <script type="text/javascript">
        var ctxL = document.getElementById("lineChart").getContext('2d');
        $.ajax({
            url: '{{ route("chart") }}',
            dataType: 'json',
            success: function(response) {
                const chart = new Chart(ctxL, {
                    type: 'line',
                    data: response.data,
                    options: {
                        scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value, index, values) {
                                    return formatNumber(value);
                                }
                            }
                        }]
                        }
                    }
                });
            }
        });

        const formatNumber = (number) => {
            const suffix = ['', ' rb', ' jt', ' miliar', ' triliun'];
            const precision = [0, 0, 1, 1, 1];
            const divider = [1, 1e3, 1e6, 1e9, 1e12];
            let i;
            for (i = suffix.length - 1; i > 0; i--) {
                if (number >= divider[i]) {
                break;
                }
            }
            let formattedNumber = (number / divider[i]).toFixed(precision[i]);
            if (formattedNumber.includes('.')) {
                formattedNumber = formattedNumber.replace(/\.?0*$/, '');
            }
            return formattedNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + suffix[i];
        };
    </script>
@endpush

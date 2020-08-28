        @extends('layouts.master')

        @section('content')
        <div class="right_col" role="main">
            <div class="">
                <div class="row">&nbsp;</div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                            <div class="x_title">
                                <h2>Jumlah Transaksi <small>dalam sebulan</small></h2>
                                <!-- <div class="filter">
                                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                    </div>
                                </div> -->
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-12 col-sm-12 ">
                                    <div class="demo-container">
                                        <canvas id="chartTotalTrx"></canvas>
                                    </div>
                                    <div class="tiles">
                                        <div class="col-md-4 tile">
                                            <span>Total Pembelian</span>
                                            <h2>Rp{{ number_format($total_pembelian['nilai_pembelian'], 0, ',', '.') }}</h2>
                                            <div class="chart-container" style="height: 300px;">
                                                <canvas id="chartTotalPembelian" width="200" height="160" style="display: inline-block; vertical-align: top; width: 94px; height: 300px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4 tile">
                                            <span>Total Revenue</span>
                                            <h2>Rp{{ number_format($total_revenue['nilai_revenue'], 0, ',', '.') }}</h2>
                                            <div class="chart-container" style="height: 300px;">
                                                <canvas id="chartTotalRevenue" width="200" height="160" style="display: inline-block; vertical-align: top; width: 94px; height: 300px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4 tile">
                                            <span>Total Laba/Rugi</span>
                                            <h2>Rp{{ number_format($total_laba['nilai_laba'], 0, ',', '.') }}</h2>
                                            <div class="chart-container" style="height: 300px;">
                                                <canvas id="chartLabaRugi" width="200" height="160" style="display: inline-block; vertical-align: top; width: 94px; height: 300px;"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('script')
        <!-- Chart.js -->
        <script src="{{ asset('vendors/Chart.js-2.9.3/dist/Chart.min.js') }}"></script>

        <script>
            var ctx = document.getElementById('chartTotalTrx').getContext('2d');
            var chartTotalTrx = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?= htmlentities($total_trx['tgl_penjualan']) ?>],
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: [<?= htmlentities($total_trx['trx']) ?>],
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        // borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                stepSize: 5,
                                suggestedMin: 0,
                                suggestedMax: 30
                            },
                        }]
                    }
                }
            });

            var ctx = document.getElementById('chartTotalPembelian').getContext('2d');
            var chartTotalPembelian = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?= htmlentities($total_pembelian['tgl_pembelian']) ?>],
                    datasets: [{
                        label: 'Total Pembelian',
                        data: [<?= htmlentities($total_pembelian['trx']) ?>],
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        // borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            stacked: true,
                            // ticks: {
                            //     stepSize: 5,
                            //     suggestedMin: 0,
                            //     suggestedMax: 30
                            // },
                        }]
                    }
                }
            });

            var ctx = document.getElementById('chartTotalRevenue').getContext('2d');
            var chartTotalRevenue = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?= htmlentities($total_revenue['tgl_penjualan']) ?>],
                    datasets: [{
                        label: 'Total Revenue',
                        data: [<?= htmlentities($total_revenue['trx']) ?>],
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        // borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            stacked: true,
                            // ticks: {
                            //     stepSize: 5,
                            //     suggestedMin: 0,
                            //     suggestedMax: 30
                            // },
                        }]
                    }
                }
            });

            var ctx = document.getElementById('chartLabaRugi').getContext('2d');
            var chartLabaRugi = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?= htmlentities($total_laba['tgl_penjualan']) ?>],
                    datasets: [{
                        label: 'Total Laba',
                        data: [<?= htmlentities($total_laba['trx']) ?>],
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        // borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            stacked: true,
                            // ticks: {
                            //     stepSize: 5,
                            //     suggestedMin: 0,
                            //     suggestedMax: 30
                            // },
                        }]
                    }
                }
            });
        </script>
        @endsection
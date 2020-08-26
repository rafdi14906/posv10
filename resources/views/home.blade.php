        @extends('layouts.master')

        @section('content')
        <div class="right_col" role="main">
            <div class="">
                <div class="row">&nbsp;</div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Transaction Summary <small>Weekly progress</small></h2>
                                <div class="filter">
                                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-12 col-sm-12 ">
                                    <div class="demo-container" style="height:280px">
                                        <div id="chart_plot_02" class="demo-placeholder"></div>
                                    </div>
                                    <div class="tiles">
                                        <div class="col-md-4 tile">
                                            <span>Total Sessions</span>
                                            <h2>231,809</h2>
                                            <span class="sparkline11 graph" style="height: 160px;">
                                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                            </span>
                                        </div>
                                        <div class="col-md-4 tile">
                                            <span>Total Revenue</span>
                                            <h2>$231,809</h2>
                                            <span class="sparkline22 graph" style="height: 160px;">
                                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                            </span>
                                        </div>
                                        <div class="col-md-4 tile">
                                            <span>Total Sessions</span>
                                            <h2>231,809</h2>
                                            <span class="sparkline11 graph" style="height: 160px;">
                                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('script')
        <!-- FastClick -->
        <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
        <!-- NProgress -->
        <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
        <!-- Chart.js -->
        <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
        <!-- jQuery Sparklines -->
        <script src="{{ asset('vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
        <!-- Flot -->
        <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
        <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
        <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
        <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
        <!-- Flot plugins -->
        <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
        <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
        <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
        <!-- DateJS -->
        <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

        <script>
            function init_sparklines() {
                void 0 !== jQuery.fn.sparkline && (console.log("init_sparklines"), $(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
                    type: "bar",
                    height: "125",
                    barWidth: 13,
                    colorMap: {
                        7: "#a1a1a1"
                    },
                    barSpacing: 2,
                    barColor: "#26B99A"
                }), $(".sparkline_two").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
                    type: "bar",
                    height: "40",
                    barWidth: 9,
                    colorMap: {
                        7: "#a1a1a1"
                    },
                    barSpacing: 2,
                    barColor: "#26B99A"
                }), $(".sparkline_three").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
                    type: "line",
                    width: "200",
                    height: "40",
                    lineColor: "#26B99A",
                    fillColor: "rgba(223, 223, 223, 0.57)",
                    lineWidth: 2,
                    spotColor: "#26B99A",
                    minSpotColor: "#26B99A"
                }), $(".sparkline11").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
                    type: "bar",
                    height: "40",
                    barWidth: 8,
                    colorMap: {
                        7: "#a1a1a1"
                    },
                    barSpacing: 2,
                    barColor: "#26B99A"
                }), $(".sparkline22").sparkline([10, 10, 10, 15, 20, 2], {
                    type: "line",
                    height: "40",
                    width: "200",
                    lineColor: "#26B99A",
                    fillColor: "#ffffff",
                    lineWidth: 3,
                    spotColor: "#34495E",
                    minSpotColor: "#34495E"
                }), $(".sparkline_bar").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
                    type: "bar",
                    colorMap: {
                        7: "#a1a1a1"
                    },
                    barColor: "#26B99A"
                }), $(".sparkline_area").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7], {
                    type: "line",
                    lineColor: "#26B99A",
                    fillColor: "#26B99A",
                    spotColor: "#4578a0",
                    minSpotColor: "#728fb2",
                    maxSpotColor: "#6d93c4",
                    highlightSpotColor: "#ef5179",
                    highlightLineColor: "#8ba8bf",
                    spotRadius: 2.5,
                    width: 85
                }), $(".sparkline_line").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
                    type: "line",
                    lineColor: "#26B99A",
                    fillColor: "#ffffff",
                    width: 85,
                    spotColor: "#34495E",
                    minSpotColor: "#34495E"
                }), $(".sparkline_pie").sparkline([1, 1, 2, 1], {
                    type: "pie",
                    sliceColors: ["#26B99A", "#ccc", "#75BCDD", "#D66DE2"]
                }), $(".sparkline_discreet").sparkline([4, 6, 7, 7, 4, 3, 2, 1, 4, 4, 2, 4, 3, 7, 8, 9, 7, 6, 4, 3], {
                    type: "discrete",
                    barWidth: 3,
                    lineColor: "#26B99A",
                    width: "85"
                }))
            }
        </script>
        @endsection
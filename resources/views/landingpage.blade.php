@extends('template.master')
@section('content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6 p-2">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Dashboard</a></li>

                    <li><span></span></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <!-- seo fact area start -->
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-4 mt-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg1">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="ti-book"></i> Buku</div>
                                <h2>{{$book}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-md-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg2">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="ti-user"></i> Pengunjung</div>
                                <h2>{{$rating}}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-md-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg4">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="ti-star"></i> Semua Rating</div>
                                <h2>{{$rating}}</h2>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">User Statistics</h4>
                            <div id="user-statistics"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- seo fact area end -->
        <div class="col-4 mt-5">
                <div class="card">
                    <div class="card-body pb-0">
                        <h4 class="header-title">Rating Terbanyak</h4>
                        <div id="socialads" style="height: 245px;"></div>
                    </div>
                </div>
        </div>



    </div>
</div>
@endsection
@push('js')
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script>
    /*--------------  bar chart 14 highchart start ------------*/
if ($('#socialads').length) {
    const url = "{{route('dashboard.chart1')}}"

    $.ajax({
            url: url,
            method: 'GET',
            success: function(res){
                // console.log(res.data);

                Highcharts.chart('socialads', {
                    chart: {
                        type: 'column'
                    },
                    title: false,
                    xAxis: {
                        categories: [res.data[0].judul, res.data[1].judul, res.data[2].judul , res.data[3].judul, res.data[4].judul]
                    },
                    colors: ['#F5CA3F', '#E5726D', '#12C599', '#5F73F2'],
                    yAxis: {
                        min: 0,
                        title: false
                    },
                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                        shared: true
                    },
                    plotOptions: {
                        column: {
                            stacking: 'column'
                        }
                    },
                    series: [{
                            name: 'Rating Rata-rata',
                            data: [res.data[0].avg , res.data[1].avg, res.data[2].avg, res.data[3].avg, res.data[4].avg]
                        }
                    ]
                    });
            },
            error:function (xhr) {
                console.log(xhr);
            },

        });

}
/*--------------  bar chart 14 highchart END ------------*/



/*-------------- 10 line chart amchart start ------------*/
if ($('#user-statistics').length) {
    const url = "{{route('dashboard.chart2')}}";

    $.ajax({
            url: url,
            method: 'GET',
            success: function(res){
                // var dates =;
                // for (let index = 0; index < res.data.length; index++) {
                //      dates =
                //          [{"date": res.data[index].date, "value":res.data[index].count}];
                // }
                console.log(res.data[0].date);

                var chart = AmCharts.makeChart("user-statistics", {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 0,
                    "marginLeft": 40,
                    "autoMarginOffset": 20,
                    "dataDateFormat": "YYYY-MM-DD",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "position": "left",
                        "ignoreAxisWidth": true
                    }],
                    "balloon": {
                        "borderThickness": 1,
                        "shadowAlpha": 0
                    },
                    "graphs": [{
                        "id": "g1",
                        "balloon": {
                            "drop": true,
                            "adjustBorderColor": false,
                            "color": "#ffffff",
                            "type": "smoothedLine"
                        },
                        "fillAlphas": 0.2,
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "bulletColor": "#FFFFFF",
                        "bulletSize": 5,
                        "hideBulletsCount": 50,
                        "lineThickness": 2,
                        "title": "red line",
                        "useLineColorForBulletBorder": true,
                        "valueField": "value",
                        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                    }],
                    "chartCursor": {
                        "valueLineEnabled": true,
                        "valueLineBalloonEnabled": true,
                        "cursorAlpha": 0,
                        "zoomable": false,
                        "valueZoomable": true,
                        "valueLineAlpha": 0.5
                    },
                    "valueScrollbar": {
                        "autoGridCount": true,
                        "color": "#5E72F3",
                        "scrollbarHeight": 30
                    },
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "dashLength": 1,
                        "minorGridEnabled": true
                    },
                    "export": {
                        "enabled": false
                    },
                    "dataProvider":
                    //     {
                    //     "date": "2012-07-27",
                    //     "value": 13
                    // }
                    res.data

                });

            },
            error:function (xhr) {

            },

        });
}

/*-------------- 10 line chart amchart end ------------*/
    </script>
@endpush

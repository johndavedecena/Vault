<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <title>Reports | Vault</title>
        @include('Includes.css_tb')
		@include("Includes.Scripts.scripts")
		<script src="{{ URL() }}/highcharts/js/highcharts.js"></script>
		<script src="{{ URL() }}/highcharts/js/modules/exporting.js"></script>
		<script type="text/javascript">
		$(function () {
		    $('#container').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Historic World Population by Region'
		        },
		        subtitle: {
		            text: 'Source: Wikipedia.org'
		        },
		        xAxis: {
		            categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Population (millions)',
		                align: 'high'
		            },
		            labels: {
		                overflow: 'justify'
		            }
		        },
		        tooltip: {
		            valueSuffix: ' millions'
		        },
		        plotOptions: {
		            bar: {
		                dataLabels: {
		                    enabled: true
		                }
		            }
		        },
		        legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'top',
		            x: -40,
		            y: 100,
		            floating: true,
		            borderWidth: 1,
		            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
		            shadow: true
		        },
		        credits: {
		            enabled: false
		        },
		        series: [{
		            name: 'Year 1800',
		            data: [107, 31, 635, 203, 2]
		        }, {
		            name: 'Year 1900',
		            data: [133, 156, 947, 408, 6]
		        }, {
		            name: 'Year 2008',
		            data: [973, 914, 4054, 732, 34]
		        }]
		    });
		});
		</script>
</head>
<body>
<div class="container">
            <nav class="navbar" role="navigation">
                @include('Includes.Menu.admin_menu')
            </nav><!-- /navbar -->

            <div class="main_contain">
                <div class="space"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="{{ URL() }}/employees">All Employees</a></li>
                    <li @if(!empty($status) && $status=="on-board") class="active" @endif><a href="{{ URL() }}/employees/filter/on-board" role="tab">On-Board</a></li>
                    <li @if(!empty($status) && $status=="temporary") class="active" @endif><a href="{{ URL() }}/employees/filter/temporary" role="tab">Temporary Employees</a></li>
                    <li @if(!empty($status) && $status=="ojt") class="active" @endif><a href="{{ URL() }}/employees/filter/ojt" role="tab">OJT</a></li>
                    <li @if(!empty($status) && $status=="academy") class="active" @endif><a href="{{ URL() }}/employees/filter/academy" role="tab">Academy</a></li>
                    @if(Session::get("user_type")!="User")
                    <li style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/import">Import Data</a></li>
                    <li style="float:right"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                    @else
                    <li style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                    @endif
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="col-md-4 fright checkbox-tab">
                                		<div class="form-group" style="padding-right:-10px">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                </span>            
                                            </div>
                                        </div>               
                                </div><div class="row">
                                    <div class="col-md-4 checkbox-tab">
                                        @if(Session::get("user_type")!="User")
                                        <button class="btn btn-sm delete-employ" type="button" onclick="parent.location='{{ URL() }}/employees/addemployee'"><i class="fa fa-plus-circle fa-lg"></i> Add Employee</button>
                                        @endif
                                        @if(Session::get('user_type')=="Root")
                                        <button class="btn btn-sm delete-employ" type="submit"><i class="fa fa-minus-circle fa-lg"></i> Delete Employees</button>
                                        @endif
                                        <div class="tab_space"><p class="text-extrasmall"></p></div>
                                    </div>
                                </div>
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
        @include('Includes.footer')
</body>
</html>
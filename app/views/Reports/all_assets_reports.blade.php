<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <title>All Assets Reports | Vault</title>
        @include('Includes.css_tb')
</head>
<body>
<div class="container">
            <nav class="navbar" role="navigation">
                @include('Includes.Menu.admin_menu')
            </nav><!-- /navbar -->
            <div class="main_contain">
                <div class="space"></div>
                <ul class="nav nav-tabs" role="tablist">
                    @include("Includes.Tabs.Reports.reports_tabs")
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                            	<div class="row">
                                    <div class="col-md-4 checkbox-tab">
                                        <h5 class="in-line">All Assets Reports</h5>
                                    </div>
                                </div>
                                <div id="container" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Asset Type</th>
                                        <th width="40%">No. of Assets</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">Client Assets</td>
                                        <td class="text-left">{{ number_format($clientCount) }}</td>
                                        <td>{{ number_format($clientPercentage,2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Network Assets</td>
                                        <td class="text-left">{{ number_format($networkCount) }}</td>
                                        <td>{{ number_format($networkPercentage,2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Office</td>
                                        <td class="text-left">{{ number_format($officeCount) }}</td>
                                        <td>{{ number_format($officePercentage,2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Software</td>
                                        <td class="text-left">{{ number_format($softwareCount) }}</td>
                                        <td>{{ number_format($softwarePercentage,2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Assets :</strong></h6> {{ number_format($totalAssets) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="space"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
        @include('Includes.footer')
        @include('Includes.Scripts.scripts')
		<script src="{{ URL() }}/highcharts/js/highcharts.js"></script>
		<script src="{{ URL() }}/highcharts/js/modules/exporting.js"></script>
		<script type="text/javascript">
		
		$(function () {
		    $('#container').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'All Assets: Summary',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Client Assets','Network Assets','Office Assets','Software Assets'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Assets',
		                align: 'high'
		            },
		            labels: {
		                overflow: 'justify'
		            }
		        },
		        plotOptions: {
		            bar: {
		                dataLabels: {
		                    enabled: true
		                }
		            }
		        },
		        colors: ['#001E4C'],
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
		            name: 'Assets',
		            data: [{{ $clientCount }}, {{ $networkCount }}, {{ $officeCount }}, {{ $softwareCount }}]
		        }]
		    });
		});
		</script>
</body>
</html>
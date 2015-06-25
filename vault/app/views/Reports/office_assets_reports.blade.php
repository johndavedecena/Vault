<?php 
function getPercentage($assets,$totalAssets){
	
	if($assets>0 && $totalAssets>0){
		$percentage = ($assets/$totalAssets)*100;
		return number_format($percentage,2);
	}
	
	else{
		return number_format(0,2) ;
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <title>Office Assets Reports | Vault</title>
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
                                        <h5 class="in-line">Office Assets Reports</h5>
                                    </div>
                                </div>
                                <div id="summary" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Office Assets Classifications</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Printers</td>
	                                        <td class="text-left">{{ number_format($printers) }}</td>
	                                        <td>{{ number_format($printersPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Projectors</td>
	                                        <td class="text-left">{{ number_format($projectors) }}</td>
	                                        <td>{{ number_format($projectorsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Other Assets</td>
	                                        <td class="text-left">{{ number_format($otherAssets) }}</td>
	                                        <td>{{ number_format($otherAssetsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Office Assets :</strong></h6> {{ $totalOfficeAssets }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="printer-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Status</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Available</td>
	                                        <td class="text-left">{{ number_format($p_available) }}</td>
	                                        <td>{{ getPercentage($p_available,$printers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($p_for_repair) }}</td>
	                                        <td>{{ getPercentage($p_for_repair,$printers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($p_installed) }}</td>
	                                        <td>{{ getPercentage($p_installed,$printers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($p_lost) }}</td>
	                                        <td>{{ getPercentage($p_lost,$printers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($p_retired) }}</td>
	                                        <td>{{ getPercentage($p_retired,$printers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Printers:</strong></h6> {{ $printers }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="projector-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Status</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Available</td>
	                                        <td class="text-left">{{ number_format($pro_available) }}</td>
	                                        <td>{{ getPercentage($pro_available,$projectors) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($pro_for_repair) }}</td>
	                                        <td>{{ getPercentage($pro_for_repair,$projectors) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($pro_installed) }}</td>
	                                        <td>{{ getPercentage($pro_installed,$projectors) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($pro_lost) }}</td>
	                                        <td>{{ getPercentage($pro_lost,$projectors) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($pro_retired) }}</td>
	                                        <td>{{ getPercentage($pro_retired,$projectors) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Projectors:</strong></h6> {{ $projectors }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="oa-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Status</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Available</td>
	                                        <td class="text-left">{{ number_format($o_available) }}</td>
	                                        <td>{{ getPercentage($o_available,$otherAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($o_for_repair) }}</td>
	                                        <td>{{ getPercentage($o_for_repair,$otherAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($o_installed) }}</td>
	                                        <td>{{ getPercentage($o_installed,$otherAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($o_lost) }}</td>
	                                        <td>{{ getPercentage($o_lost,$otherAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($o_retired) }}</td>
	                                        <td>{{ getPercentage($o_retired,$otherAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Other Assets:</strong></h6> {{ $otherAssets }} </td>
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
		    $('#summary').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Office Assets: Summary',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Printers','Projectors','Other Assets'],
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
		            data: [{{ $printers }},{{ $projectors }}, {{ $otherAssets }}]
		        }]
		    });
		});

		$(function () {
		    $('#printer-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Printers: Status Reports',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','For Repair','Installed', 'Lost', 'Retired'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Printers',
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
		            name: 'Printers',
		            data: [
				            {{ $p_available }},
				            {{ $p_for_repair }},
				            {{ $p_installed}},
				            {{ $p_lost }},
				            {{ $p_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#projector-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Projectors: Status Reports',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','For Repair','Installed', 'Lost', 'Retired'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Projectors',
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
		            name: 'Projectors',
		            data: [
				            {{ $pro_available }},
				            {{ $pro_for_repair }},
				            {{ $pro_installed}},
				            {{ $pro_lost }},
				            {{ $pro_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#oa-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Other Assets: Status Reports',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','For Repair','Installed', 'Lost', 'Retired'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Other Assets',
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
		            name: 'Other Assets',
		            data: [
				            {{ $o_available }},
				            {{ $o_for_repair }},
				            {{ $o_installed}},
				            {{ $o_lost }},
				            {{ $o_retired }}
						  ]
		        }]
		    });
		});
		</script>
</body>
</html>
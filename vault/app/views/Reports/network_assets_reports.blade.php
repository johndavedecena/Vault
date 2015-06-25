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
        <title>Network Assets Reports | Vault</title>
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
                                        <h5 class="in-line">Network Assets Reports</h5>
                                    </div>
                                </div>
                                <div id="summary" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Network Assets Classification</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Access Points</td>
	                                        <td class="text-left">{{ number_format($accessPoints) }}</td>
	                                        <td>{{ number_format($accessPointsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Routers</td>
	                                        <td class="text-left">{{ number_format($routers) }}</td>
	                                        <td>{{ number_format($routersPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Switches</td>
	                                        <td class="text-left">{{ number_format($switches) }}</td>
	                                        <td>{{ number_format($switchesPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">SFP</td>
	                                        <td class="text-left">{{ number_format($sfp) }}</td>
	                                        <td>{{ number_format($sfpPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">UPS</td>
	                                        <td class="text-left">{{ number_format($ups) }}</td>
	                                        <td>{{ number_format($upsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">VoIP Phones</td>
	                                        <td class="text-left">{{ number_format($voip) }}</td>
	                                        <td>{{ number_format($voipPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Servers</td>
	                                        <td class="text-left">{{ number_format($servers) }}</td>
	                                        <td>{{ number_format($serversPercentage,2) }}%</td>
	                                    </tr>
	                                    
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Client Assets :</strong></h6> {{ $totalNetworkAssets }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="ap-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($a_available) }}</td>
	                                        <td>{{ getPercentage($a_available,$accessPoints) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($a_for_repair) }}</td>
	                                        <td>{{ getPercentage($a_for_repair,$accessPoints) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($a_installed) }}</td>
	                                        <td>{{ getPercentage($a_installed,$accessPoints) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($a_lost) }}</td>
	                                        <td>{{ getPercentage($a_lost,$accessPoints) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($a_retired) }}</td>
	                                        <td>{{ getPercentage($a_retired,$accessPoints) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Access Points:</strong></h6> {{ $accessPoints }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="routers-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($r_available) }}</td>
	                                        <td>{{ getPercentage($r_available,$routers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($r_for_repair) }}</td>
	                                        <td>{{ getPercentage($r_for_repair,$routers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($r_installed) }}</td>
	                                        <td>{{ getPercentage($r_installed,$routers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($r_lost) }}</td>
	                                        <td>{{ getPercentage($r_lost,$routers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($r_retired) }}</td>
	                                        <td>{{ getPercentage($r_retired,$routers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Routers:</strong></h6> {{ $routers }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="switches-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($s_available) }}</td>
	                                        <td>{{ getPercentage($s_available,$switches) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($s_for_repair) }}</td>
	                                        <td>{{ getPercentage($s_for_repair,$switches) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($s_installed) }}</td>
	                                        <td>{{ getPercentage($s_installed,$switches) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($s_lost) }}</td>
	                                        <td>{{ getPercentage($s_lost,$switches) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($s_retired) }}</td>
	                                        <td>{{ getPercentage($s_retired,$switches) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Switches:</strong></h6> {{ $switches }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="sfp-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($sfp_available) }}</td>
	                                        <td>{{ getPercentage($sfp_available,$sfp) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($sfp_for_repair) }}</td>
	                                        <td>{{ getPercentage($sfp_for_repair,$sfp) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($sfp_installed) }}</td>
	                                        <td>{{ getPercentage($sfp_installed,$sfp) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($sfp_lost) }}</td>
	                                        <td>{{ getPercentage($sfp_lost,$sfp) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($sfp_retired) }}</td>
	                                        <td>{{ getPercentage($sfp_retired,$sfp) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of SFPs:</strong></h6> {{ $sfp }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="ups-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($u_available) }}</td>
	                                        <td>{{ getPercentage($u_available,$ups) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($u_for_repair) }}</td>
	                                        <td>{{ getPercentage($u_for_repair,$ups) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($u_installed) }}</td>
	                                        <td>{{ getPercentage($u_installed,$ups) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($u_lost) }}</td>
	                                        <td>{{ getPercentage($u_lost,$ups) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($u_retired) }}</td>
	                                        <td>{{ getPercentage($u_retired,$ups) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of UPS:</strong></h6> {{ $ups }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="voip-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($v_available) }}</td>
	                                        <td>{{ getPercentage($v_available,$voip) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($v_for_repair) }}</td>
	                                        <td>{{ getPercentage($v_for_repair,$voip) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($v_installed) }}</td>
	                                        <td>{{ getPercentage($v_installed,$voip) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($v_lost) }}</td>
	                                        <td>{{ getPercentage($v_lost,$voip) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($v_retired) }}</td>
	                                        <td>{{ getPercentage($v_retired,$voip) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of VoIP Phones:</strong></h6> {{ $voip }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="servers-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($se_available) }}</td>
	                                        <td>{{ getPercentage($se_available,$servers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($se_for_repair) }}</td>
	                                        <td>{{ getPercentage($se_for_repair,$servers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Installed</td>
	                                        <td class="text-left">{{ number_format($se_installed) }}</td>
	                                        <td>{{ getPercentage($se_installed,$servers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($se_lost) }}</td>
	                                        <td>{{ getPercentage($se_lost,$servers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($se_retired) }}</td>
	                                        <td>{{ getPercentage($se_retired,$servers) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Servers:</strong></h6> {{ $servers }} </td>
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
		            text: 'Network Assets: Summary',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Access Points','Routers','Switches', 'SFP', 'UPS', 'VoIP Phones', 'Servers'],
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
		            data: [{{ $accessPoints }},{{ $routers }}, {{ $switches}},{{ $sfp }},{{ $ups }},{{ $voip}},{{ $servers }} ]
		        }]
		    });
		});

		$(function () {
		    $('#ap-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Access Points: Status Reports',
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
		                text: 'No. of Access Points',
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
		            name: 'Access Points',
		            data: [
				            {{ $a_available }},
				            {{ $a_for_repair }},
				            {{ $a_installed}},
				            {{ $a_lost }},
				            {{ $a_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#routers-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Routers: Status Reports',
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
		                text: 'No. of Routers',
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
		            name: 'Routers',
		            data: [
				            {{ $r_available }},
				            {{ $r_for_repair }},
				            {{ $r_installed}},
				            {{ $r_lost }},
				            {{ $r_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#switches-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Switches: Status Reports',
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
		                text: 'No. of Switches',
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
		            name: 'Switches',
		            data: [
				            {{ $s_available }},
				            {{ $s_for_repair }},
				            {{ $s_installed}},
				            {{ $s_lost }},
				            {{ $s_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#sfp-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'SFP: Status Reports',
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
		                text: 'No. of SFPs',
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
		            name: 'SFPs',
		            data: [
				            {{ $sfp_available }},
				            {{ $sfp_for_repair }},
				            {{ $sfp_installed}},
				            {{ $sfp_lost }},
				            {{ $sfp_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#ups-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'UPS: Status Reports',
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
		                text: 'No. of UPS',
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
		            name: 'UPS',
		            data: [
				            {{ $u_available }},
				            {{ $u_for_repair }},
				            {{ $u_installed}},
				            {{ $u_lost }},
				            {{ $u_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#voip-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'VoIP Phones: Status Reports',
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
		                text: 'No. of VoIP Phones',
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
		            name: 'VoIP Phones',
		            data: [
				            {{ $v_available }},
				            {{ $v_for_repair }},
				            {{ $v_installed}},
				            {{ $v_lost }},
				            {{ $v_retired }}
						  ]
		        }]
		    });
		});

		$(function () {
		    $('#servers-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Servers: Status Reports',
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
		                text: 'No. of Servers',
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
		            name: 'Servers',
		            data: [
				            {{ $se_available }},
				            {{ $se_for_repair }},
				            {{ $se_installed}},
				            {{ $se_lost }},
				            {{ $se_retired }}
						  ]
		        }]
		    });
		});
		</script>
</body>
</html>
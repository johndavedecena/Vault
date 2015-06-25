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
        <title>Software Assets Reports | Vault</title>
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
                                        <h5 class="in-line">Software Assets Reports</h5>
                                    </div>
                                </div>
                                <div id="summary" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Software Assets Status</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Available</td>
	                                        <td class="text-left">{{ number_format($available) }}</td>
	                                        <td>{{ getPercentage($available,$totalSoftwareAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">PWU</td>
	                                        <td class="text-left">{{ number_format($pwu) }}</td>
	                                        <td>{{ getPercentage($pwu,$totalSoftwareAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($retired) }}</td>
	                                        <td>{{ getPercentage($retired,$totalSoftwareAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Test Case</td>
	                                        <td class="text-left">{{ number_format($test_case) }}</td>
	                                        <td>{{ getPercentage($test_case,$totalSoftwareAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($lost) }}</td>
	                                        <td>{{ getPercentage($lost,$totalSoftwareAssets) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Software Assets :</strong></h6> {{ $totalSoftwareAssets }} </td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Software Types</th>
	                                        <th width="40%">No. of Software Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<?php foreach($softwareTypes as $st) {?>
	                                	<tr>
	                                        <td class="text-left">{{ $st->software_type }}</td>
	                                        <td class="text-left">{{ number_format(count($st->softwareassets)) }}</td>
	                                        <td>{{ getPercentage(count($st->softwareassets),$totalSoftwareAssets) }}%</td>
	                                    </tr>
	                                	<?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Software Assets :</strong></h6> {{ $totalSoftwareAssets }} </td>
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
		            text: 'Software Assets: Status',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','PWU','Retired','Test Case','Lost'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Software Assets',
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
		            name: 'Software Assets',
		            data: [
				            {{ $available }},
				            {{ $pwu }},
				            {{ $retired }},
				            {{ $test_case }},
				            {{ $lost }}
				          ]
		        }]
		    });
		});
		</script>
</body>
</html>
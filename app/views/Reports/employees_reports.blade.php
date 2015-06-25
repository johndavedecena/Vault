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
        <title>Employees Reports | Vault</title>
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
                                        <h5 class="in-line">Employees Reports</h5>
                                    </div>
                                </div>
                                <div id="summary" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Employees Status</th>
	                                        <th width="40%">No. of Employees</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Academy</td>
	                                        <td class="text-left">{{ number_format($academy) }}</td>
	                                        <td>{{ getPercentage($academy,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Contractual</td>
	                                        <td class="text-left">{{ number_format($contractual) }}</td>
	                                        <td>{{ getPercentage($contractual,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Graduate</td>
	                                        <td class="text-left">{{ number_format($graduate) }}</td>
	                                        <td>{{ getPercentage($graduate,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">NSN Guest</td>
	                                        <td class="text-left">{{ number_format($nsnGuest) }}</td>
	                                        <td>{{ getPercentage($nsnGuest,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Obsolete</td>
	                                        <td class="text-left">{{ number_format($obsolete) }}</td>
	                                        <td>{{ getPercentage($obsolete,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">OJT</td>
	                                        <td class="text-left">{{ number_format($ojt) }}</td>
	                                        <td>{{ getPercentage($ojt,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">OJT Graduate</td>
	                                        <td class="text-left">{{ number_format($ojtGraduate) }}</td>
	                                        <td>{{ getPercentage($ojtGraduate,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">On-Board</td>
	                                        <td class="text-left">{{ number_format($onBoard) }}</td>
	                                        <td>{{ getPercentage($onBoard,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Resigned</td>
	                                        <td class="text-left">{{ number_format($resigned) }}</td>
	                                        <td>{{ getPercentage($resigned,$totalEmployees) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Employees :</strong></h6> {{ $totalEmployees }} </td>
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
		            text: 'Employees: Status',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: [
			     		        'Academy',
		     		            'Contractual',
		     		            'Graduate',
		     		            'NSN Guest',
		     		            'Obsolete',
		     		            'OJT',
		     		            'OJT Graduate',
		     		            'On-Board',
		     		            'Resigned'
		     		            ],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Employees',
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
		            name: 'Employees',
		            data: [
				            {{ $academy }},
				            {{ $contractual }},
				            {{ $graduate }},
				            {{ $nsnGuest }},
				            {{ $obsolete }},
				            {{ $ojt }},
				            {{ $ojtGraduate }},
				            {{ $onBoard }},
				            {{ $resigned }}
				          ]
		        }]
		    });
		});
		</script>
</body>
</html>
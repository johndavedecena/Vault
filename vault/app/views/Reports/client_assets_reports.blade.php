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
        <title>Client Assets Reports | Vault</title>
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
                                        <h5 class="in-line">Client Assets Reports</h5>
                                    </div>
                                </div>
                                <div id="summary" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
                                <div class="space"></div>
                                <table class="table table-condensed table-striped" style="width:800px;margin:auto">
	                                <thead>
	                                    <tr>
	                                        <th width="40%" class="text-left">Client Assets Classification</th>
	                                        <th width="40%">No. of Assets</th>
	                                        <th width="20%">%</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-left">Laptops</td>
	                                        <td class="text-left">{{ number_format($laptops) }}</td>
	                                        <td>{{ number_format($laptopsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Monitors</td>
	                                        <td class="text-left">{{ number_format($monitors) }}</td>
	                                        <td>{{ number_format($monitorsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Docking Stations</td>
	                                        <td class="text-left">{{ number_format($dockingStations) }}</td>
	                                        <td>{{ number_format($dockingStationsPercentage,2) }}%</td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Client Assets :</strong></h6> {{ number_format($totalClientAssets) }}</td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="laptops-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($l_available) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_available,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Available for Issuance</td>
	                                        <td class="text-left">{{ number_format($l_available_for_issuance) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_available_for_issuance,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                     <tr>
	                                        <td class="text-left">Available for Test Case</td>
	                                        <td class="text-left">{{ number_format($l_available_for_test_case) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_available_for_test_case,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                     <tr>
	                                        <td class="text-left">PWU - Cebu</td>
	                                        <td class="text-left">{{ number_format($l_pwu_cebu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_pwu_cebu,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">EWU</td>
	                                        <td class="text-left">{{ number_format($l_ewu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_ewu,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Checking</td>
	                                        <td class="text-left">{{ number_format($l_for_checking) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_for_checking,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($l_for_repair) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_for_repair,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">IT Use</td>
	                                        <td class="text-left">{{ number_format($l_it_use) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_it_use,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($l_lost) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_lost,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">PWU</td>
	                                        <td class="text-left">{{ number_format($l_pwu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_pwu,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Recruitment</td>
	                                        <td class="text-left">{{ number_format($l_recruitment) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_recruitment,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($l_retired) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_retired,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Test Case</td>
	                                        <td class="text-left">{{ number_format($l_test_case) }}</td>
	                                        <td>
	                                        	{{ getPercentage($l_test_case,$laptops) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Laptops :</strong></h6> {{ number_format($laptops) }}</td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="laptop-models" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                <?php foreach($laptopModels as $lm) { ?>
	                                    <tr>
	                                        <td class="text-left">{{ $lm->name }}</td>
	                                        <td class="text-left">{{ number_format(count($lm->assets)) }}</td>
	                                        <td>
	                                        	{{ getPercentage(count($lm->assets),$laptops) }}%
	                                        </td>
	                                    </tr>
		                        	<?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Laptops :</strong></h6> {{ number_format($laptops) }}</td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="row" align="center">
                            	<h5>Laptop Status by Models</h5>
                            </div>
                            <div class="row" align="center">
                            	<h6>Available</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_available[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_available[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Available Laptops :</strong></h6> {{ number_format(array_sum($l_models_available)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>Available for Issuance</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_available_for_issuance[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_available_for_issuance[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Available for Issuance Laptops :</strong></h6> {{ number_format(array_sum($l_models_available_for_issuance)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                             <div class="row" align="center">
                            	<h6>Available for Test Case</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_available_for_test_case[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_available_for_test_case[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Available for Test Case Laptops :</strong></h6> {{ number_format(array_sum($l_models_available_for_test_case)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                             <div class="row" align="center">
                            	<h6>PWU - Cebu</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_pwu_cebu[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_pwu_cebu[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of PWU - Cebu :</strong></h6> {{ number_format(array_sum($l_models_pwu_cebu)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>EWU</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_ewu[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_ewu[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of EWU Laptops :</strong></h6> {{ number_format(array_sum($l_models_ewu)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>For Checking</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_for_checking[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_for_checking[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of For Checking Laptops :</strong></h6> {{ number_format(array_sum($l_models_for_checking)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>For Repair</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_for_repair[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_for_repair[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of For Repair Laptops :</strong></h6> {{ number_format(array_sum($l_models_for_repair)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>IT Use</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_it_use[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_it_use[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of IT Use Laptops :</strong></h6> {{ number_format(array_sum($l_models_it_use)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>Lost</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_lost[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_lost[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Lost Laptops :</strong></h6> {{ number_format(array_sum($l_models_lost)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>PWU</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_pwu[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_pwu[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of PWU Laptops :</strong></h6> {{ number_format(array_sum($l_models_pwu)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>Recruitment</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_recruitment[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_recruitment[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Recruitment Laptops :</strong></h6> {{ number_format(array_sum($l_models_recruitment)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>Retired</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_retired[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_retired[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Retired Laptops :</strong></h6> {{ number_format(array_sum($l_models_retired)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="row" align="center">
                            	<h6>Test Case</h6>
                            </div>
                           	<table class="table table-condensed table-striped" style="width:800px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="40%" class="text-left">Laptop Model</th>
                                        <th width="40%">No. of Laptops</th>
                                        <th width="20%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($laptopModels as $lm) {?>
                                    <tr>
                                        <td class="text-left">{{ $lm->name }}</td>
                                        <td class="text-left">{{ number_format($l_models_test_case[$lm->id]) }}</td>
                                        <td>
                                        	{{ getPercentage($l_models_test_case[$lm->id],$laptops) }}%
                                        </td>
                                    </tr>
                                    <?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><h6 class="text-small"><strong>Total Number of Test Case Laptops :</strong></h6> {{ number_format(array_sum($l_models_test_case)) }}</td>
	                                    </tr>
	                                </tbody>
                            </table>
                            <div class="space"></div>
                            <div id="monitors-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($m_available) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_available,$monitors) }}%
	                                        </td>
	                                    </tr>
<!-- 	                                       <tr> -->
<!-- 	                                        <td class="text-left">Available for Issuance</td> -->
<!-- 	                                        <td class="text-left">{{ number_format($m_available_for_issuance) }}</td> -->
<!-- 	                                        <td> -->
<!-- 	                                        	{{ getPercentage($m_available_for_issuance,$monitors) }}% -->
<!-- 	                                        </td> -->
<!-- 	                                    </tr> -->
<!-- 	                                     <tr> -->
<!-- 	                                        <td class="text-left">Available for Test Case</td> -->
<!-- 	                                        <td class="text-left">{{ number_format($m_available_for_test_case) }}</td> -->
<!-- 	                                        <td> -->
<!-- 	                                        	{{ getPercentage($m_available_for_test_case,$monitors) }}% -->
<!-- 	                                        </td> -->
<!-- 	                                    </tr> -->
<!-- 	                                     <tr> -->
<!-- 	                                        <td class="text-left">PWU - Cebu</td> -->
<!-- 	                                        <td class="text-left">{{ number_format($m_pwu_cebu) }}</td> -->
<!-- 	                                        <td> -->
<!-- 	                                        	{{ getPercentage($m_pwu_cebu,$monitors) }}% -->
<!-- 	                                        </td> -->
<!-- 	                                    </tr> -->
	                                    <tr>
	                                        <td class="text-left">EWU</td>
	                                        <td class="text-left">{{ number_format($m_ewu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_ewu,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Checking</td>
	                                        <td class="text-left">{{ number_format($m_for_checking) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_for_checking,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($m_for_repair) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_for_repair,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">IT Use</td>
	                                        <td class="text-left">{{ number_format($m_it_use) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_it_use,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($m_lost) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_lost,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">PWU</td>
	                                        <td class="text-left">{{ number_format($m_pwu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_pwu,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Recruitment</td>
	                                        <td class="text-left">{{ number_format($m_recruitment) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_recruitment,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($m_retired) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_retired,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Test Case</td>
	                                        <td class="text-left">{{ number_format($m_test_case) }}</td>
	                                        <td>
	                                        	{{ getPercentage($m_test_case,$monitors) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Monitors :</strong></h6> {{ number_format($monitors) }}</td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="monitor-models" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                <?php foreach($monitorModels as $mm) { ?>
	                                    <tr>
	                                        <td class="text-left">{{ $mm->name }}</td>
	                                        <td class="text-left">{{ number_format(count($mm->assets)) }}</td>
	                                        <td>
	                                        	{{ getPercentage(count($mm->assets),$monitors) }}%
	                                        </td>
	                                    </tr>
		                        	<?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Monitors :</strong></h6> {{ number_format($monitors) }}</td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="docking-status" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                        <td class="text-left">{{ number_format($d_available) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_available,$dockingStations) }}%
	                                        </td>
	                                    </tr>
<!-- 	                                      <tr> -->
<!-- 	                                        <td class="text-left">Available for Issuance</td> -->
<!-- 	                                        <td class="text-left">{{ number_format($d_available_for_issuance) }}</td> -->
<!-- 	                                        <td> -->
<!-- 	                                        	{{ getPercentage($d_available_for_issuance,$dockingStations) }}% -->
<!-- 	                                        </td> -->
<!-- 	                                    </tr> -->
<!-- 	                                     <tr> -->
<!-- 	                                        <td class="text-left">Available for Test Case</td> -->
<!-- 	                                        <td class="text-left">{{ number_format($d_available_for_test_case) }}</td> -->
<!-- 	                                        <td> -->
<!-- 	                                        	{{ getPercentage($d_available_for_test_case,$dockingStations) }}% -->
<!-- 	                                        </td> -->
<!-- 	                                    </tr> -->
<!-- 	                                     <tr> -->
<!-- 	                                        <td class="text-left">PWU - Cebu</td> -->
<!-- 	                                        <td class="text-left">{{ number_format($d_pwu_cebu) }}</td> -->
<!-- 	                                        <td> -->
<!-- 	                                        	{{ getPercentage($d_pwu_cebu,$dockingStations) }}% -->
<!-- 	                                        </td> -->
<!-- 	                                    </tr> -->
	                                    <tr>
	                                        <td class="text-left">EWU</td>
	                                        <td class="text-left">{{ number_format($d_ewu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_ewu,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Checking</td>
	                                        <td class="text-left">{{ number_format($d_for_checking) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_for_checking,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">For Repair</td>
	                                        <td class="text-left">{{ number_format($d_for_repair) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_for_repair,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">IT Use</td>
	                                        <td class="text-left">{{ number_format($d_it_use) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_it_use,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Lost</td>
	                                        <td class="text-left">{{ number_format($d_lost) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_lost,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">PWU</td>
	                                        <td class="text-left">{{ number_format($d_pwu) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_pwu,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Recruitment</td>
	                                        <td class="text-left">{{ number_format($d_recruitment) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_recruitment,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Retired</td>
	                                        <td class="text-left">{{ number_format($d_retired) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_retired,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-left">Test Case</td>
	                                        <td class="text-left">{{ number_format($d_test_case) }}</td>
	                                        <td>
	                                        	{{ getPercentage($d_test_case,$dockingStations) }}%
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Docking Stations :</strong></h6> {{ number_format($dockingStations) }}</td>
	                                    </tr>
	                                </tbody>
                            	</table>
                            <div class="space"></div>
                            <div id="docking-models" style="min-width: 310px; width:1100px; height: 400px; margin: 0 auto"></div>
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
	                                <?php foreach($dockingStationModels as $dsm) { ?>
	                                    <tr>
	                                        <td class="text-left">{{ $lm->name }}</td>
	                                        <td class="text-left">{{ number_format(count($dsm->assets)) }}</td>
	                                        <td>
	                                        	{{ getPercentage(count($dsm->assets),$dockingStations) }}%
	                                        </td>
	                                    </tr>
		                        	<?php } ?>
	                                    <tr>
	                                        <td colspan="3" class="text-left"><strong><h6 class="text-small"><strong>Total Number of Docking Stations :</strong></h6> {{ number_format($dockingStations) }}</td>
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
		            text: 'Client Assets: Summary',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Laptops','Monitors','Docking Stations'],
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
		            data: [{{ $laptops }},{{ $monitors }}, {{ $dockingStations}}]
		        }]
		    });
		});

		$(function () {
		    $('#laptops-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Laptops: Status Reports',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','Available for Issuance','Available for Test Case','PWU - Cebu','EWU','For Checking','For Repair','IT Use','Lost','PWU','Recruitment','Retired','Test Case'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Laptops',
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
		            name: 'Laptops',
		            data: [
				            {{ $l_available }},
				            {{ $l_available_for_issuance }},
				            {{ $l_available_for_test_case }},
				            {{ $l_pwu_cebu }},
				            {{ $l_ewu }},
				            {{ $l_for_checking }},
				            {{ $l_for_repair }},
				            {{ $l_it_use }},
				            {{ $l_lost }},
				            {{ $l_pwu }},
				            {{ $l_recruitment }},
				            {{ $l_retired }},
				            {{ $l_test_case }},
				          ]
		        }]
		    });
		});

		$(function () {
		    $('#laptop-models').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Laptops: Models',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: [
		                        <?php foreach($laptopModels as $lm) { ?>
								'{{ $lm->name }}',
		                        <?php } ?>
		     		            ],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Laptops',
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
		            name: 'Laptops',
		            data: [
							<?php foreach($laptopModels as $lm) { ?>
							{{ count($lm->assets) }},
							<?php } ?>
				          ]
		        }]
		    });
		});

		$(function () {
		    $('#monitors-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Monitors: Status Reports',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','EWU','For Checking','For Repair','IT Use','Lost','PWU','Recruitment','Retired','Test Case'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Monitors',
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
		            name: 'Monitors',
		            data: [
				            {{ $m_available }},
// 				            {{ $m_available_for_issuance }},
// 				            {{ $m_available_for_test_case }},
// 				            {{ $m_pwu_cebu }},
				            {{ $m_ewu }},
				            {{ $m_for_checking }},
				            {{ $m_for_repair }},
				            {{ $m_it_use }},
				            {{ $m_lost }},
				            {{ $m_pwu }},
				            {{ $m_recruitment }},
				            {{ $m_retired }},
				            {{ $m_test_case }},
				          ]
		        }]
		    });
		});

		$(function () {
		    $('#monitor-models').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Monitors: Models',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: [
		                        <?php foreach($monitorModels as $mm) { ?>
								'{{ $mm->name }}',
		                        <?php } ?>
		     		            ],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Monitors',
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
		            name: 'Monitors',
		            data: [
							<?php foreach($monitorModels as $mm) { ?>
							{{ count($mm->assets) }},
							<?php } ?>
				          ]
		        }]
		    });
		});
		
		$(function () {
		    $('#docking-status').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Docking Stations: Status Reports',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: ['Available','EWU','For Checking','For Repair','IT Use','Lost','PWU','Recruitment','Retired','Test Case'],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Docking Stations',
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
		            name: 'Docking Stations',
		            data: [
				            {{ $d_available }},
// 				            {{ $d_available_for_issuance }},
// 				            {{ $d_available_for_test_case }},
// 				            {{ $d_pwu_cebu }},
				            {{ $d_ewu }},
				            {{ $d_for_checking }},
				            {{ $d_for_repair }},
				            {{ $d_it_use }},
				            {{ $d_lost }},
				            {{ $d_pwu }},
				            {{ $d_recruitment }},
				            {{ $d_retired }},
				            {{ $d_test_case }},
				          ]
		        }]
		    });
		});

		$(function () {
		    $('#docking-models').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Docking Stations: Models',
		            style: { color:"#00005C", fontSize:"24px" }
		        },
		        xAxis: {
		            categories: [
		                        <?php foreach($dockingStationModels as $dsm) { ?>
								'{{ $dsm->name }}',
		                        <?php } ?>
		     		            ],
		            title: {
		                text: null
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'No. of Docking Stations',
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
		            name: 'Docking Stations',
		            data: [
							<?php foreach($dockingStationModels as $dsm) { ?>
							{{ count($dsm->assets) }},
							<?php } ?>
				          ]
		        }]
		    });
		});
		</script>
</body>
</html>
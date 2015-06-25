<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Asset Liability Waiver</title>
		<link href="{{ URL() }}/bootstrap/css/bootstrap-switch.min.css" rel="stylesheet">
		<style>
			table{
			font-size:80%;
			}
			
			tr.bigger{
			font-size:90%;
			}
		</style>
	</head>
	<body>
		<table width="530">
			<tr>
				<td colspan="2"><img src="{{ URL() }}/images/nwl_logo.png" width="240"/><hr/></td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2"><div align="center"><strong>ASSET LIABILITY WAIVER</strong></div></td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td width="30%"><div align="left">Employee:</div></td>
				<td><div align="left"><strong>{{ $asset->employee->first_name." ".$asset->employee->last_name }}</strong></div></td>
				
			</tr>
			<tr>
				<td width="30%"><div align="left">ID Number:</div></td>
				<td><strong>{{ $asset->employee->employee_number }}</strong></td>
			</tr>
			<tr>
				<td width="30%"><div align="left">Cost Center:</div></td>
				<td>___________________________</td>
			</tr>
			<tr>
				<td width="30%"><div align="left">Asset Number:</div></td>
				<td><strong>{{ $asset->asset_tag }}</strong></td>
			</tr>
			<tr>
				<td width="30%"><div align="left">Type:</div></td>
				<td><strong>{{ $asset->classification->singular }}</strong></td>
			</tr>
			<tr>
				<td width="30%"><div align="left">Serial Number:</div></td>
				<td><strong>{{ $asset->serial_number }}</strong></td>
			</tr>
			<tr>
				<td width="30%"><div align="left">Reason for Issuance:</div></td>
				<td><img src="{{ URL() }}/images/checkbox.png" width="20" height="20"/> New  <img src="{{ URL() }}/images/checkbox.png" width="20" height="20"/> Replacement</td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:292px">Reason for Replacement</div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:292px"><img src="{{ URL() }}/images/checkbox.png" width="20" height="20"/>Lost (attach incident report and police report, if applicable)</div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px"><i>To be filled out by IT:</i></div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px">Unit Lost ____________</div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px">Asset No. ____________</div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px">Replacement Cost ____________</div></td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:292px"><img src="{{ URL() }}/images/checkbox.png" width="20" height="20"/>Upgrade</div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px"><i>To be filled out by IT:</i></div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px">Previous Unit ____________</div></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:295px">Asset No. ____________</div></td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2"><div style="text-indent:292px"><img src="{{ URL() }}/images/checkbox.png" width="20" height="20"/>Others, please specify ________________</div></td>
			</tr>
			<tr>
				<td colspan="2"><br/><hr/></td>
			</tr>
			<tr class="bigger">
				<td colspan="2">
				I hereby acknowledge that I have received the following items in good working condition:<br/>
				<strong>{{ $asset->model->name }} ({{ $asset->classification->singular }})</strong> unit with asset number stated above with the following accessories<br/>
				__Laptop Charger<br/>
				__Mouse<br/>
				__Power and VGA Cable<br/>
				__Docking Station Charger<br/>
				__Others
				
				<br/><br/>
				Upon signing this waiver, I am aware of the following terms and conditions:<br/>
				<ul>
					<li>In case of theft/loss, I will immediately inform IT.</li>
					<li>I understand that I am responsible for the repair or replacement needed resulting from improper handling or misuse of the unit(s), its accessories and appurtenances unless it is covered by the warranty.</li>
					<li>I will not use the unit(s) for any illegal or immoral activities. I guarantee NetworkLabs Inc. its executives, associates, representatives and volunteers for any ramifications resulting from the use of the unit(s).</li>
					<li>I am aware that the unit(s) remains a property of NetworkLabs Inc. and must be surrendered upon separation from the company or upon demand.</li>
					<li>I will abide by the applicable rules and regulation in accordance to the IT policy.</li>
				</ul>
				</td>
			</tr>
			<tr class="bigger">
				<td colspan="2">
					<br/><br/>
					<div align="center">
					<u>{{ $asset->employee->first_name." ".$asset->employee->last_name }}</u><br/>
					<strong><p style="font-size:80%;">Signature Over Printed Name</p></strong>
					</div>
				</td>
			</tr>
			<tr class="bigger">
				<td colspan="2">
					<div align="center">
					<strong>DATE & TIME:</strong>________________________________
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>
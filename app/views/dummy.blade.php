<?php 
	$logs = UserLog::orderBy("id","desc")->take(10)->get();
?>
<b>System Logs</b>
<table border="1">
	@foreach($logs as $log)
	<tr>
		<td>{{ $log->description }}</td>	
	</tr>
	@endforeach
</table>
<br/>

<?php 
	$assetLogs = AssetLog::orderBy("id","desc")->take(10)->get();
?>

<b>Asset Logs</b>
	<table border="1">
	@foreach($assetLogs as $log)
	<tr>
		<td>{{ $log->description }}</td>	
	</tr>
	@endforeach
	</table>
<br/>

<?php 
	$softwareLogs = SoftwareLog::orderBy("id","desc")->take(10)->get();
?>
<b>Software Asset Logs</b>
	<table border="1">
	@foreach($softwareLogs as $log)
	<tr>
		<td>{{ $log->description }}</td>	
	</tr>
	@endforeach
	</table>
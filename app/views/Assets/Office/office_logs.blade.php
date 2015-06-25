<?php 
if(Session::has("page2")){
	$returnPage = Session::get("page2");
}
else if(Session::has("page")){
	$returnPage = Session::get("page");
}
else{
	$returnPage = URL();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Office Asset Logs | Vault</title>
    @include('Includes.css_tb')
</head>
<body>
    <div class="container">
        <nav class="navbar" role="navigation">
            @include('Includes.Menu.admin_menu')
        </nav><!-- /navbar -->

        <div class="main_contain">
            <div class="space"></div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="fleft btn arrow-back"><a href="<?php echo $returnPage ?>"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    @if(Session::get("user_type")=="Root" || Session::get("user_type")=="Admin")
                    {{ Form::select("transaction",
                    					array(
                    						"all"=>"All",
                    						"history"=>"History",
                    						"updates"=>"Updates"
                    					),
                    					$transaction,
                    					array(
                    						"id"=>"transaction",
                    						"name"=>"transaction",
                    						"onchange"=>"filterLogs()",
                    						"class"=>"form-control input-sm fright",
                    						"style"=>"width:200px;"
                    					)
                    				)
                    }}
                    @endif
                    <h5>Office Asset Logs</h5>
                    <div class="tab_space"><p class="text-extrasmall"><b>Logs Count :</b> {{ number_format($logCount) }} </p></div>
                    <div class="form-group">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="65%"><p>Details</p></th>
                                    <th width="15%"><p>Logged by</p></th>
                                    <th width="20%"><p>Date / Time</p></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($logs as $log) { ?>
                                <tr>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ "<strong>(".$log->user->username.") </strong>".$log->user->first_name." ".$log->user->last_name }}</td>
                                    <td>{{ DateTime::createFromFormat("Y-m-d H:i:s",$log->datetime)->format("F d, Y g:iA") }}</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="pagination center">
							@if($logs->links()!=null)
                                {{ $logs->links() }}
                            @endif
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div><!-- /.container -->
    @include('Includes.footer')
    <!-- /.footer -->
<!-- Load JS here for greater good =============================-->
@include('Includes.Scripts.scripts')
<script>
    function filterLogs(){
            var transaction = document.getElementById("transaction").value;
            if(transaction=="all"){
                parent.location="{{ URL() }}/assets/office/logs/{{ $asset->id }}";}
            else{ 
                parent.location="{{ URL() }}/assets/office/logs/{{ $asset->id }}/"+transaction;}
    }
</script>
</body>
</html>
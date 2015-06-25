<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Assets Logs | Vault</title>
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
	                @include('Includes.Tabs.Logs.logs_tabs')
	            </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                    	<div class="tab_space text-center">
                    	<h5>Assets Logs</h5>
                    	</div>
                        @if(Session::get('message'))
		            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                {{ Session::get('message') }}
		                </div>
		                @endif
                        {{ Form::open(array("method"=>"get","url"=>"logs/assets/filter")) }}
                            <div class="form-group">
                                <table class="table table-condensed table-striped table-hover" style="margin:auto;width:800px">
                                    <thead>
                                        <tr>
                                            <th width="25%"></th>
                                            <th width="25%"></th>
                                            <th width="25%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                            	<div class="input-group input-group-sm" style="width:220px"><span class="input-group-addon">>></span>
                                                    {{ Form::text("username",'',array("class"=>"form-control","placeholder"=>"Username")) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width:220px"><span class="input-group-addon">>></span>
                                                    {{ Form::text("start_date",'',array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"From Date")) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width:220px"><span class="input-group-addon">>></span>
                                                    {{ Form::text("end_date",'',array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"To Date")) }}
                                                </div>
                                            </td>
                                             <td>
                                                <div class="input-group input-group-sm" style="width:200px"><span class="input-group-addon">>></span>
                                             		 
                                                	{{ 
                                                	Form::select("asset",
                                                					array( 
                                                						   "" => "All",                                                						   
																		  'Client' => array('1' => 'Laptop', '3' => "Monitor", '2' => "Docking Station"),
																		  'Network' => array('4' => "Access Points", '5' => "Routers", '6' => "Switches", '7' => "SFP", '10' => "UPS", '11' => "VoIP Phones", '13' => "Servers"),
																		  'Office Equipment' => array('8' => "Printers", '9' => "Projectors", '12' => "Other Assets"),
																		 ),
                                                    				'',                                            
                                                    			    
                                                    				array("class"=>"form-control")) }}
                                           
                                                </div>
                                            </td>
                                            <td>{{ Form::button('Filter',array("class"=>"btn btn-sm btn-info","type"=>"submit","name"=>"filter")) }}</td>
                                            <td>{{ Form::button('Export',array("class"=>"btn btn-sm btn-default","type"=>"submit","name"=>"export")) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
		                		<div class="tab_space"><p class="text-extrasmall"><b>Logs Count : {{ number_format($logsCount) }}</b></p></div>
                                <table class="table table-condensed table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="15%"><p class="text-center">User</p></th>
                                            <th width="60%"><p class="text-center">Description</p></th>
                                            <th width="25%"><p class="text-center">Date/Time</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($assetsLogs as $l) {?>
                                        <tr>
                                            <td class="text-left"><b>({{ $l->user->user_type }})</b> {{ $l->user->username }}</td>
                                            <td>{{ $l->description }}</td>
                                            <td class="text-center">{{ DateTime::createFromFormat("Y-m-d H:i:s",$l->datetime)->format("F d, Y g:iA") }}</td>
                                        </tr>
                                    <?php } ?>
                             
                                    </tbody>
                                </table>
                            </div>
                         {{ Form::close() }}
                         <div class="pagination center">
                             @if($assetsLogs->links()!=null)
                                {{ $assetsLogs->appends(Input::except('token'))->links() }}
                             @endif
                         </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
        @include('Includes.footer')
	<!-- /.footer -->
    <!-- Load JS here for greater good =============================-->
    @include('Includes.Scripts.scripts')
    </body>
</html>
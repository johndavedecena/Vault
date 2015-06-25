<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Export Office Assets | Vault</title>
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
                @include('Includes.Tabs.Export.export_tabs')
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                	@if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif    
                    <div class="tab-content">
                        <div class="tab-pane active">    
                            <div class="table_space"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- advanced search -->
                                    {{ Form::open(array("url"=>URL("export/office/begin"),"method"=>"get","class"=>"form-horizontal")) }}
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Asset Tag</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("asset_tag",'',array("class"=>"form-control","placeholder"=>"Asset Tag")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Serial Number</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("serial_number",'',array("class"=>"form-control","placeholder"=>"Serial Number")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Employee</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("employee",'',array("class"=>"form-control","placeholder"=>"Employee Name or Number")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Asset Type</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::select("classification_id",$assetClassifications,'',array("class"=>"form-control")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Asset Status</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{
                                                    Form::select("asset_status",array(
                                                            ""=>"--Select One--",
                                                            "Available"=>"Available",
                                                            "For Repair"=>"For Repair",
                                                            "Installed"=>"Installed",
                                                            "Lost"=>"Lost",
                                                            "Retired"=>"Retired"),'',array("class"=>"form-control"));

                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Model</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::select("model",$assetModels,'',array("class"=>"form-control")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Warranty Start Date</label>
                                            <div class="col-sm-7 input-group-sm">
                                                {{ Form::text("warranty_start",'',array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Warranty End Date</label>
                                            <div class="col-sm-7 input-group-sm"> 
                                                {{ Form::text("warranty_end",'',array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date")) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Format</label>
                                            <div class="col-sm-7 input-group-sm">
                                            	<span class="col-md-1"><input type="checkbox" name="format" checked value="human"></span><p class="text-extrasmall">Human Readable Format</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-7">
                                                <button name="search" type="submit" class="btn btn-sm delete-employ">Search</button>
                                                <button name="export" type="submit" class="btn btn-sm delete-employ">Export</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                    <!-- end of advanced search -->
                                </div>
                                <div class="col-md-8">
                                        <div class="col-md-4 tab_space"><p class="text-extrasmall"><b>Results : {{ number_format($results) }}</b> </p></div>
                                        <div class="sub_space"></div>
                                        <table class="table table-condensed table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="10%"><p>Action</p></th>
                                                    <th width="13%"><p>Asset Tag</p></th>
                                                    <th width="15%"><p>Serial Number</p></th>
                                                    <th width="12%"><p>Asset Type</p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($assets as $a) {?>
                                                <tr>
                                                    <td><div class="row">
                                                        <span class="col-md-1 fa-stack fa-lg"><a href="#" data-toggle="modal" data-target="#moreInfo{{ $a->id }}" title="More Information"><i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i></a></span>
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="employee-modal modal fade" id="moreInfo{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="width:900px">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title" id="myModalLabel"><strong>{{ $a->asset_tag }}</strong></h6>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                @if(!empty($a->employee->last_name))
                                                                                <tr>
                                                                                    <td><p class="bold fright">Issued To :</p></td>
                                                                                    <td>{{ $a->employee->last_name.", ".$a->employee->first_name }}</td>
                                                                                </tr>
                                                                                @endif
                                                                                <tr>
                                                                                    <td><p class="bold fright">Serial Number :</p></td>
                                                                                    <td>@if(!empty($a->serial_number)) {{ $a->serial_number }} @else {{ "No Information." }}@endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Model Name :</p></td>
                                                                                    <td>@if(!empty($a->model->name)) {{ $a->model->name }} @else {{ "No Information." }}@endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Warranty Start Date :</p></td>
                                                                                    <td>@if(!empty($a->warranty_start)) {{ DateTime::createFromFormat('Y-m-d', $a->warranty_start)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Warranty End Date :</p></td>
                                                                                    <td>@if(!empty($a->warranty_end)) {{ DateTime::createFromFormat('Y-m-d', $a->warranty_end)->format('F d, Y') }} @else {{ "No Information." }} @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><p class="bold fright">Status :</p></td>
                                                                                    <td>{{ $a->status }}</td>
                                                                                </tr>
		                                                                        <tr>
		                                                                            <td><p class="bold fright">Notes :</p></td>
		                                                                            <td>{{ htmlentities($a->notes) }}</td>
		                                                                        </tr>
		                                                                        <tr>
	                                                                            <td><p class="bold fright">Date Added :</p></td>
		                                                                            <td>{{ DateTime::createFromFormat('Y-m-d H:i:s', $a->date_added)->format('F d, Y g:iA') }}</td>
		                                                                        </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                      <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End of Modal -->
                                                    </td>
                                                    <td>{{ $a->asset_tag }}</td>
                                                    <td>@if(!empty($a->serial_number)) {{ $a->serial_number }} @else {{ "No Information." }}@endif</td>
                                                    <td>{{ $a->classification->name }}</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="pagination">
										@if($assets->links()!=null)
                                            {{ $assets->appends(Input::except('token'))->links() }}
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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
</body>
</html>
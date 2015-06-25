<?php Session::put("page2",URL()."/assets/office/update/".$asset_key."/".$asset->id)?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Office Asset | Vault</title>
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
                	<div class="fleft btn arrow-back"><a href="<?php echo Session::get('page')!=null ? Session::get('page'): URL() ?>"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    <div class="fright">
                        <button type="button" onclick="parent.location='{{ URL() }}/assets/office/logs/{{ $asset->id }}'" class="btn btn-sm btn-info">View Logs</button>
                    </div>
                    <h5>Update Office Asset @if($asset->status=="Lost") (This asset is marked as LOST) @endif</h5>
                    @if(Session::get('message'))
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Information Update Failed. </strong> {{ Session::get('message') }}
                    </div>
                    @endif           
                    @if(Session::get('success'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Information Update Successful. </strong> {{ htmlentities(Session::get('success')) }}
                    </div>
                    @endif
                    @if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif
                    {{ Form::open(array("url"=>"assets/office/submitassetupdate","method"=>"post")) }}
                        {{ Form::hidden("asset_key",$asset_key) }}
                        {{ Form::hidden("id",$asset->id) }}
                        <div class="form-group">
                        	@if($asset->status!="Lost" || Session::get("user_type")=="Root")
                            <table class="table table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="20%"></th>
                                        <th width="30%"></th>
                                        <th width="30%"></th>
                                        <th width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr>
                                        <td><p style="float:right;font-weight:900">Issued to</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                @if(!empty($asset->employee->last_name))
                                                    {{ Form::text("employee",$asset->employee->first_name." ".$asset->employee->last_name,array("class"=>"form-control input-sm","disabled")) }}
                                                @else
                                                    {{ Form::text("employee","None",array("class"=>"form-control input-sm","disabled")) }}
                                                    @endif
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                	<tr>
                                        <td><p style="float:right;font-weight:900">Asset Type *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("asset_class_id",$assetClassifications,$asset_class_id,array("class"=>"form-control input-sm","id"=>"asset_class","onchange"=>"redirector()")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Status *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{
                                                    Form::select("asset_status",array(
                                                            ""=>"--Select One--",
                                                            "Available"=>"Available",
															"PWU"=>"PWU",
                                                            "For Repair"=>"For Repair",
                                                            "Installed"=>"Installed",
                                                            "Retired"=>"Retired",
                                                            "For Borrowing" =>"For Borrowing",
                                                            ),$asset->status,array("class"=>"form-control input-sm"));

                                                }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Asset Tag *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("asset_tag",$asset->asset_tag,array("class"=>"form-control input-sm","placeholder"=>"Asset Tag")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Serial Number *</p></td>
                                        <td><div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("serial_number",$asset->serial_number,array("class"=>"form-control input-sm","placeholder"=>"Serial Number")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Model</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("model_id",$assetModels,$asset->model_id,array("class"=>"form-control input-sm")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Location</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("location",$locations,$asset->location,array("class"=>"form-control input-sm")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Warranty Start / End</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_start",$asset->warranty_start,array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date")) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_end",$asset->warranty_end,array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                     <tr>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes",$asset->notes,array("class"=>"form-control","style"=>"width:375px;height:200px;")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>  
                                        <td></td>
                                        <td>
                                        @if($asset->status!="Lost")
                                        		{{
                                                    Form::select("action",array(
                                                            ""=>"--Select Action--",
                                                            "update"=>"Update",
                                                            "transfer"=>"Transfer Asset",
                                                            "lost"=>"Log as Lost"),
                                                            "update",array("class"=>"form-control input-sm"));

                                                }}
                                        @else
                                        		{{
                                                    Form::select("action",array(
                                                            ""=>"--Select Action--",
                                                            "update"=>"Update"),
                                                            "update",array("class"=>"form-control input-sm"));

                                                }}
                                        @endif
                                        </td>
                                        <td>
                                            {{ Form::button("Revert",array("type"=>"reset","class"=>"fright btn btn-sm"))}}
                                            {{ Form::button("Go",array("type"=>"submit","class"=>"fright btn btn-sm btn-info"))}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @elseif($asset->status=="Lost" && Session::get("user_type")!="Root")
                            <table class="table table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="20%"></th>
                                        <th width="30%"></th>
                                        <th width="30%"></th>
                                        <th width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr>
                                        <td><p style="float:right;font-weight:900">Issued to</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                @if(!empty($asset->employee->last_name))
                                                    {{ Form::text("employee",$asset->employee->first_name." ".$asset->employee->last_name,array("class"=>"form-control input-sm","disabled")) }}
                                                @else
                                                    {{ Form::text("employee","None",array("class"=>"form-control input-sm","disabled")) }}
                                                    @endif
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                	<tr>
                                        <td><p style="float:right;font-weight:900">Asset Type</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("asset_class_id",$assetClassifications,$asset_class_id,array("class"=>"form-control input-sm","id"=>"asset_class","onchange"=>"redirector()","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Status</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{
                                                    Form::select("asset_status",array(
                                                            ""=>"Lost",
                                                            "Available"=>"Available",
                                                            "For Repair"=>"For Repair",
                                                            "Installed"=>"Installed",
                                                            "Lost"=>"Lost",
                                                            "Retired"=>"Retired"
                                                            ),$asset->status,array("class"=>"form-control input-sm","disabled"));

                                                }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Asset Tag</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("asset_tag",$asset->asset_tag,array("class"=>"form-control input-sm","placeholder"=>"Asset Tag","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Serial Number</p></td>
                                        <td><div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("serial_number",$asset->serial_number,array("class"=>"form-control input-sm","placeholder"=>"Serial Number","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Model</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("model_id",$assetModels,$asset->model_id,array("class"=>"form-control input-sm","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Warranty Start / End</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_start",$asset->warranty_start,array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date","disabled")) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_end",$asset->warranty_end,array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                     <tr>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes",$asset->notes,array("class"=>"form-control","style"=>"width:375px;height:200px;","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>  
                                        <td></td>
                                        <td>
                                        		{{
                                                    Form::select("action",array(
                                                            ""=>"--Select Action--",
                                                            "update"=>"Update",
                                                            "transfer"=>"Transfer Asset",
                                                            "return"=>"Log as Returned",
                                                            "lost"=>"Log as Lost"),
                                                            "update",array("class"=>"form-control input-sm","disabled"));

                                                }}
                                        </td>
                                        <td>
                                            {{ Form::button("Revert",array("type"=>"reset","class"=>"fright btn btn-sm","disabled"))}}
                                            {{ Form::button("Go",array("type"=>"submit","class"=>"fright btn btn-sm btn-info","disabled"))}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
    @include('Includes.footer')
    <!-- /.footer -->
<!-- Load JS here for greater good =============================-->
@include('Includes.Scripts.scripts')
<script type="text/javascript">
    function redirector(){
        var asset_id = document.getElementById("asset_class").value;
        if(asset_id!="0"){
                parent.location="{{ URL() }}/assets/office/redirector/"+asset_id+"/update/{{ $asset->id }}";
        }
    }
</script>
</body>
</html>

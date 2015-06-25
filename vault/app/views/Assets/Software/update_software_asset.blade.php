<?php Session::put("page2",URL()."/assets/software/update/".$software->id)?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Software Asset | IT Assets</title>
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
                        <button type="button" onclick="parent.location='{{ URL() }}/assets/software/logs/{{ $software->id }}'" class="btn btn-sm btn-info">View Logs</button>
                    </div>
                    <h5>Update Software Asset @if($software->status=="Lost") (This asset is marked as LOST) @endif</h5>
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
                    {{ Form::open(array("method"=>"post","url"=>"assets/software/submitassetupdate")) }}
                    {{ Form::hidden("id",$software->id) }}
                        <div class="form-group">
                    		@if($software->status!="Lost" || Session::get("user_type")=="Root")
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
                                        <td><p style="float:right;font-weight:900">Software Asset Tag *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("asset_tag",$software->asset_tag,array("class"=>"form-control input-sm","placeholder"=>"Software Asset Tag")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @if(Session::has("secure") && Session::get("user_type")=="Root")
                                	<tr>
                                        <td><p style="float:right;font-weight:900">Product Key *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("product_key",$software->product_key,array("class"=>"form-control input-sm","placeholder"=>"Product Key")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Issued To</p></td>
                                        <td>
                                             @if(!empty($software->employee->last_name))
                                                    {{ Form::text("employee",$software->employee->first_name." ".$software->employee->last_name,array("class"=>"form-control input-sm","disabled")) }}
                                             @else
                                                   {{ Form::text("employee","None",array("class"=>"form-control input-sm","disabled")) }}
									         @endif
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Assigned to Laptop</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("serial_number",$software->assigned_to_serial_number,array("class"=>"form-control input-sm","placeholder"=>"Laptop Serial Number")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Location</p></td>
                                        <td><div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("location",$software->location,array("class"=>"form-control input-sm","placeholder"=>"Location")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Software Type *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("software_type",$softwareTypes,$software->software_type_id,array("class"=>"form-control input-sm")) }}
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
                                                {{ Form::text("warranty_start",$software->warranty_start,array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date")) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_end",$software->warranty_end,array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date")) }}
                                            </div>
                                        </td>
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
                                                            "PWU"=>"PWU (Personal Work Unit)",
                                                            "Retired"=>"Retired",
                                                            "Test Case"=>"Test Case"),$software->status,array("class"=>"form-control input-sm"));

                                                }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes",$software->notes,array("class"=>"form-control","style"=>"width:375px;height:200px;")) }}
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
                                        @if($software->status!="Lost")
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
		                    @else
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
                                        <td><p style="float:right;font-weight:900">Software Asset Tag *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("asset_tag",$software->asset_tag,array("class"=>"form-control input-sm","placeholder"=>"Software Asset Tag","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @if(Session::has("secure") && Session::get("user_type")=="Root")
                                	<tr>
                                        <td><p style="float:right;font-weight:900">Product Key *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("product_key",$software->product_key,array("class"=>"form-control input-sm","placeholder"=>"Product Key","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Issued To</p></td>
                                        <td>
                                             @if(!empty($software->employee->last_name))
                                                    {{ Form::text("employee",$software->employee->first_name." ".$software->employee->last_name,array("class"=>"form-control input-sm","disabled")) }}
                                             @else
                                                   {{ Form::text("employee","None",array("class"=>"form-control input-sm","disabled")) }}
									         @endif
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Assigned to Laptop</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("serial_number",$software->assigned_to_serial_number,array("class"=>"form-control input-sm","placeholder"=>"Asset Tag","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Location</p></td>
                                        <td><div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("location",$software->location,array("class"=>"form-control input-sm","placeholder"=>"Location","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Software Type *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("software_type",$softwareTypes,$software->software_type_id,array("class"=>"form-control input-sm","disabled")) }}
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
                                                {{ Form::text("warranty_start",$software->warranty_start,array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date","disabled")) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_end",$software->warranty_end,array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date","disabled")) }}
                                            </div>
                                        </td>
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
                                                            "PWU"=>"PWU (Personal Work Unit)",
                                                            "Retired"=>"Retired",
                                                            "Test Case"=>"Test Case"),$software->status,array("class"=>"form-control input-sm","disabled"));

                                                }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes",$software->notes,array("class"=>"form-control","style"=>"width:375px;height:200px;","disabled")) }}
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
</body>
</html>

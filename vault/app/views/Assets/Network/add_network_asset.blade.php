<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Network Asset | Vault</title>
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
                    <h5>Add New Network Asset</h5>
                    @if(Session::get('message'))
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Registration Failed. </strong> {{ Session::get('message') }}
                    </div>
                    @endif
                    @if(Session::get('success'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Registration Successful. </strong> {{ htmlentities(Session::get('success')) }}
                    </div>
                    @endif
                    @if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif
                    {{ Form::open(array("method"=>"post","url"=>"assets/network/submitnewasset")) }}
                    {{ Form::hidden("asset_key",$asset_key) }}
                        <div class="form-group">
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
                                        <td><p style="float:right;font-weight:900">Asset Tag *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("asset_tag",'',array("class"=>"form-control input-sm","placeholder"=>"Asset Tag")) }}
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
                                                {{ Form::text("serial_number",'',array("class"=>"form-control input-sm","placeholder"=>"Serial Number")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Issue to</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::text("employee_number","",array("style"=>"width:407px","id"=>"employee_search","placeholder"=>"Employee")) }}
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
                                                {{ Form::select("model_id",$assetModels,'',array("class"=>"form-control input-sm")) }}
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
                                                {{ Form::select("location",$locations,$asset_class_id,array("class"=>"form-control input-sm")) }}
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
                                                {{ Form::text("warranty_start",'',array("class"=>"form-control","id"=>"start-datepicker","placeholder"=>"Start Date")) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="start-datepicker" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                                                {{ Form::text("warranty_end",'',array("class"=>"form-control","id"=>"end-datepicker","placeholder"=>"End Date")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Asset Type * / Status *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("asset_class_id",$assetClassifications,$asset_class_id,array("class"=>"form-control input-sm","id"=>"asset_class","onchange"=>"redirector()")) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{
                                                    Form::select("asset_status",array(
                                                            ""=>"--Select One--",
                                                            "Available"=>"Available",
                                                            "For Repair"=>"For Repair",
                                                            "Installed"=>"Installed",
                                                            "Lost"=>"Lost",
                                                            "Retired"=>"Retired"
                                                            ),'',array("class"=>"form-control input-sm"));

                                                }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                     <tr>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes","",array("class"=>"form-control","style"=>"width:375px;height:200px;")) }}
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
                                            {{ Form::button('Clear',array('class'=>'fright btn btn-sm','type'=>'reset')) }}
                                            {{ Form::button('Submit',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Add new network asset?')","type"=>"submit")) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
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
    var root = '{{ URL("/") }}';
</script>
<script type="text/javascript">

	function redirector(){
	    var asset_id = document.getElementById("asset_class").value;
	    if(asset_id!="0"){
	            parent.location="{{URL()}}/assets/network/redirector/"+asset_id+"/add";
	    }
	}

    function hasKeyword(){
    	var s = document.getElementById("search").value;
        if(s=="" || s.trim()==0){
                return false;
        }
        else{
                return true;
        }
    }
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add IP Asset | Vault</title>
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
                    <h5>Add New IP Asset</h5>
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
                    {{ Form::open(array("method"=>"post","url"=>"assets/IP/submitnewasset")) }}
                        <div class="form-group">
                            <table class="table table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th width="20%"></th>
                                        <th width="30%"></th>
                                        <th width="30%"></th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">IP Type *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                <!--<div class="form-control input-sm" id="iptype"><select name="ip_type"></div> -->
                                                {{ Form::select("ip_type",$IPTypes,'',array("class"=>"form-control input-sm", "onchange"=>"typeSelector()","id"=>"iptype")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">IP *</p></td>
                                        <td>
                                            <div id ="ipv4" class="input-group input-group-sm" style="">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("ipv4",'',array("class"=>"form-control input-sm ipv4","placeholder"=>"IP Address (IPv4)","id"=>"ipv4")) }}
                                            </div>
                                            <div id ="ipv6" class="input-group input-group-sm" style="display:none;">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("ipv6",'',array("class"=>"form-control input-sm","placeholder"=>"IP Address (IPv6)","id"=>"ipv6")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Subnet *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("subnet",'',array("class"=>"form-control input-sm","placeholder"=>"Subnet", "id"=>"subnet")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Requestor *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("employee_number",'',array("id"=>"employee_search","placeholder"=>"Requestor")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <!--<tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Team *</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("team",$IPTypes,'',array("class"=>"form-control input-sm","id"=>"team")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr> -->
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                        	<div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes",'',array("class"=>"form-control","style"=>"width:375px;height:200px;")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            {{ Form::button('Clear',array('class'=>'fright btn btn-sm','type'=>'reset')) }}
                                            {{ Form::button('Submit',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Add new IP asset?')","type"=>"submit")) }}
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
<script type="text/javascript">
    var root = '{{ URL("/") }}';

    function typeSelector(){
	    	var input = document.getElementById("iptype");
	    	if(input.value == "IPv4"){
		    	$("#ipv4").show();
				$("#ipv6").hide();

				var options =  { 
					    onChange: function(cep, event, currentField, options){
					        if(cep){
					            var ipArray = cep.split(".");
					            for (i in ipArray){
					                if(ipArray[i] != "" && parseInt(ipArray[i]) > 255){
					                    ipArray[i] =  '255';
					                }
					            }
					            var resultingValue = ipArray.join(".");
					            $(currentField).val(resultingValue);
					        }
					    }
					};

				$('.ipv4').mask("000.000.000.000", options);
				$('#subnet').mask("000.000.000.000", options);
		    }else if(input.value = "IPv6"){
			    $("#ipv6").show();
			    $("#ipv4").hide(); 
			}
       	}
    
</script>
        <!-- /.footer -->
<!-- Load JS here for greater good =============================-->
@include('Includes.Scripts.scripts')
</body>
</html>
<?php Session::put("page2",URL()."/assets/IP/update/".$ip->id)?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update IP Asset | IT Assets</title>
    @include('Includes.css_tb')
    <script>
    function ping(){
	alert("ping");
	
        }
    </script>
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
                        <button type="button" onclick="parent.location='{{ URL() }}/assets/IP/logs/{{ $ip->id }}'" class="btn btn-sm btn-info">View Logs</button>
                    </div>
                    <h5>Update IP Asset</h5>
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
                    {{ Form::open(array("method"=>"post","url"=>"assets/IP/submitassetupdate")) }}
                    {{ Form::hidden("id",$ip->id) }}
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
                                        <td><p style="float:right;font-weight:900">IP Type </p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::select("ip_type",$IPTypes,$ip->ip_type,array("class"=>"form-control input-sm", "onchange"=>"typeSelector()","id"=>"iptype")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">IP </p></td>
                                        <td>
                                            <div id ="ipv4" class="input-group input-group-sm" style="">
                                                <span class="input-group-addon">>></span>
                                                <?php 
                                                $ip4 = "";
                                                if($ip->ip_type == "IPv4"){
                                                	$ip4 = $ip->ip;
                                                }
                                                echo Form::text("ipv4",$ip4,array("class"=>"form-control input-sm ipv4","onselect"=>"typeSelector()", "placeholder"=>"IP Address (IPv4)","id"=>"ipv4"));
                                                ?>
                                            </div>
                                            <div id ="ipv6" class="input-group input-group-sm" style="display:none;">
                                                <span class="input-group-addon">>></span>
                                                <?php 
                                                $ip6 = "";
                                                if($ip->ip_type == "IPv6"){
                                                	$ip6 = $ip->ip."6";
                                                }
                                                echo Form::text("ipv6",$ip6,array("class"=>"form-control input-sm","onselect"=>"typeSelector()", "placeholder"=>"IP Address (IPv6)","id"=>"ipv6"));
                                                ?>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Subnet </p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("subnet",$ip->subnet,array("class"=>"form-control input-sm","placeholder"=>"Subnet", "id"=>"subnet")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Requestor </p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("requestor",$ip->employee->last_name.', '.$ip->employee->first_name,array("class"=>"form-control input-sm","placeholder"=>"Requestor","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Team </p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                <?php
                                                		if($ip->employee->unit == null){
                                                			echo Form::text("team","No Information.",array("class"=>"form-control input-sm","placeholder"=>"Team","disabled"));
                                                		}else{
                                                			echo Form::text("team",$ip->employee->unit->name,array("class"=>"form-control input-sm","placeholder"=>"Team","disabled"));
                                                		}
                                                ?>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><p style="float:right;font-weight:900">Notes</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	{{ Form::textarea("notes",$ip->notes,array("class"=>"form-control","style"=>"width:375px;height:200px;")) }}
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
                                                            "transfer"=>"Transfer Asset"),
                                                            "update",array("class"=>"form-control input-sm"));

                                                }}
                                        </td>
                                        <td>
                                            {{ Form::button("Revert",array("type"=>"reset","class"=>"fright btn btn-sm"))}}
                                            {{ Form::button("Go",array("type"=>"submit","class"=>"fright btn btn-sm btn-info"))}}
                                        </td>
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

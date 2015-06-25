<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Asset Remarks | Vault</title>
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
                    <div class="fleft btn arrow-back"><a href="{{ URL() }}/assets/client/remarks/{{ $remark->asset->id }}"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    <h5>Update Remarks</h5>
                    @if(Session::get('message'))
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Remark Update Failed. </strong> {{ Session::get('message') }}
                    </div>
                    @endif           
                    @if(Session::get('success'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Remark Update Successful. </strong> {{ htmlentities(Session::get('success')) }}
                    </div>
                    @endif
                    @if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif
                    {{ Form::open(array("url"=>"assets/client/submitremarkupdate","method"=>"post")) }}
                    {{ Form::hidden("id",$remark->id) }}
                        <div class="form-group">
                            <table class="table table-condensed table-hover" style="width:900px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="20%"></th>
                                        <th width="15%"></th>
                                        <th width="45%"></th>
                                        <th width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Asset Part</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            	<span class="input-group-addon">>></span>
                                                {{ Form::select("part",$assetParts,$remark->part,array("class"=>"form-control input-sm","style"=>"width:270px","disabled")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Part Status</p></td>
                                        <td>
                                            <div class="input-group input-group-sm"><span class="input-group-addon">>></span>
                                                @if($remark->asset->classification->name=="Laptops")
                                            	
                                            	{{ Form::select("part_status",
                                            				array(""=>"--Select One--","Okay"=>"Okay","Not OK"=>"Not OK", "Used"=>"Used"),
                                            				$remark->part_status,
                                            				array("class"=>"form-control input-sm","style"=>"width:270px")
                                            	) }}
                                            	
                                            	@elseif($remark->asset->classification->name=="Monitors")
                                            	
                                            	{{ Form::select("part_status",
                                            				array(""=>"--Select One--","Okay"=>"Okay","Not OK"=>"Not OK", "Shattered"=>"Shattered"),
                                            				$remark->part_status,
                                            				array("class"=>"form-control input-sm","style"=>"width:270px")
                                            	) }}
                                            	
                                            	@elseif($remark->asset->classification->name=="Docking Stations")
                                            	
                                            	{{ Form::select("part_status",
                                            				array(""=>"--Select One--","Okay"=>"Okay","Not OK"=>"Not OK"),
                                            				$remark->part_status,
                                            				array("class"=>"form-control input-sm","style"=>"width:270px")
                                            	) }}
                                            	
                                            	@endif
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Remarks</p></td>
                                        <td>
                                            <div class="input-group input-group-sm"><span class="input-group-addon">>></span>
                                                {{ Form::textarea("remarks",$remark->remarks,array("class"=>"form-control","style"=>"width:450px;height:300px")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button type="submit" class="fleft btn btn-sm btn-info" style="margin-left:0px">Update Remark</button>
                                            <button type="reset" class="fright btn btn-sm">Revert</button>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                {{ Form::close() }}
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
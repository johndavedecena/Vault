<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Settings - Transfer Employees to a New Manager | Vault</title>
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
                        <h5>Transfer Employees to a New Manager</h5>
                            	<div class="text-left small well">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Note:</strong> Only currently working employees will be transferred. The records of former employees will not be affected.</div>
		            	@if(Session::get('message'))
		            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Employees Transfer Failed. </strong> {{ Session::get('message') }}
		                </div>
		                @endif
		                @if(Session::get('success'))
		            	<div class="alert alert-success alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Employees Transfer Successful. </strong> {{ htmlentities(Session::get('success')) }}
		                </div>
		                @endif
		                @if(Session::get('info'))
		            	<div class="alert alert-info alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
		                </div>
		                @endif
                        {{ Form::open(array("method"=>"post","url"=>"settings/employees/committransfer")) }}
                            <div class="form-group">
                                <table class="table table-condensed table-striped table-hover" style="margin:auto;width:900px">
                                    <thead>
                                        <tr>
                                            <th width="20%"></th>
                                            <th width="20%"></th>
                                            <th width="20%"></th>
                                            <th width="20%"></th>
                                            <th width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td><b>Old Manager</b></td>
                                            <td></td>
                                            <td><b>New Manager</b></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width:200px">
                                                    {{ Form::select("old_manager",$managers,'',array('class'=>'form-control input-sm')); }}
                                                </div>
                                            </td>
                                            <td><div style="text-align:center">to</div></td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width:200px">
                                                    {{ Form::select("new_manager",$managers,'',array('class'=>'form-control input-sm')); }}
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{ Form::button('Transfer',array("class"=>"btn btn-sm btn-info","style"=>"margin-left:30px",'onclick'=>"return confirm('Are you sure you want to transfer the employees to a new manager?')","type"=>"submit")) }}</td>
                                            <td></td>
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
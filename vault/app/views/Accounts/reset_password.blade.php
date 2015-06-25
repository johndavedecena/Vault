<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>User Accounts - Root Administrator | Vault</title>
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
                    <li class="active"><a href="#" role="tab">Reset User Password</a></li>
                    <li><a href="{{ URL() }}/accounts/passwordgenerator">Password Generator</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="fleft btn arrow-back"><a href="<?php echo Session::get('page')!=null ? Session::get('page'): URL() ?>"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                                <h5 class="reset_header">Reset User Password</h5>
                                @if(Session::get('message'))
				            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
					                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					                <strong>Password Reset Failed. </strong> {{ Session::get('message') }}
				                </div>
				                @endif
				                @if(Session::get('success'))
				            	<div class="alert alert-success alert-dismissible text-center" role="alert">
					                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					                <strong>Password Reset Successful. </strong> {{ Session::get('success') }}
				                </div>
				                @endif
	                            <div class="table_space"></div>
                                {{ Form::open(array("url"=>"accounts/resetpassword","method"=>"post")) }}
                                    <div class="form-group">
                                        <table class="table table-condensed table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="10%"></th>
                                                    <th width="35%"></th>
                                                    <th width="35%"></th>
                                                    <th width="20%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Username</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-addon">>></span>
                                                            {{ Form::text('username','',array('class'=>'form-control','placeholder'=>'Username')) }}
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>New Password</td>
		                                            <td>
		                                                <div class="input-group input-group-sm">
		                                                    <span class="input-group-addon">>></span>
		                                                    {{ Form::password('new_password',array('class'=>'form-control','placeholder'=>'New Password')) }}
		                                                </div>
		                                            </td>
		                                            <td>
		                                                <div class="input-group input-group-sm">
		                                                    <span class="input-group-addon">>></span>
		                                                    {{ Form::password('new_password2',array('class'=>'form-control','placeholder'=>'Retype Password')) }}
		                                                </div>
		                                            </td>
		                                            <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Root Account Password</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-addon">>></span>
                                                            {{ Form::password("root_password",array('class'=>'form-control','placeholder'=>'Root Password')) }}
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
		                                                <input type="hidden" name="dateRegistered" />
		                                                <button type="button" class="fright btn btn-sm" onclick="parent.location='{{ URL() }}'">Return Home</button>
		                                                {{ Form::button('Submit',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Reset user password?')","type"=>"submit")) }}
		                                            </td>
		                                        </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                {{ Form::close() }}
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
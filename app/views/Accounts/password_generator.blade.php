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
                    <li><a href="{{ URL() }}/accounts/passwordmanager">Reset User Password</a></li>
                    <li class="active"><a href="#" role="tab" data-toggle="tab">Password Generator</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="fleft btn arrow-back"><a href="<?php echo Session::get('page')!=null ? Session::get('page'): URL() ?>"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                                <h5 class="reset_header">Password Generator</h5>
                                @if(isset($message))
				            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
					                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					                <strong>Password Generation Failed. </strong> {{ $message }}
				                </div>
				                @endif
	                            <div class="table_space"></div>
                                {{ Form::open(array("url"=>"accounts/generatepassword","method"=>"post")) }}
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
                                                    <td>Enter Password to Hash (Encrypt)</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-addon">>></span>
                                                            {{ Form::password('password',array('class'=>'form-control','placeholder'=>'Password to Hash')) }}
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @if(isset($hashedPassword))
                                                <tr>
                                                    <td>Encrypted Password</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <b>{{ $hashedPassword }}</b>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                                <tr>
		                                            <td></td>
		                                            <td></td>
		                                            <td></td>
		                                            <td>
		                                                <input type="hidden" name="dateRegistered" />
		                                                <button type="button" class="fright btn btn-sm" onclick="parent.location='{{ URL() }}'">Return Home</button>
		                                                {{ Form::button('Generate',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Generate encrypted password?')","type"=>"submit")) }}
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
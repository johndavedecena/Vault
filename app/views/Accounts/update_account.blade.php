<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Update User Account - Root Administrator | Vault</title>
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
                        <h5>Update User Account</h5>
		            	@if(Session::get('message'))
		            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>User Account Update Failed. </strong> {{ Session::get('message') }}
		                </div>
		                @endif
		                @if(Session::get('success'))
		            	<div class="alert alert-success alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>User Account Update Successful. </strong> {{ htmlentities(Session::get('success')) }}
		                </div>
		                @endif
		                @if(Session::get('info'))
		            	<div class="alert alert-info alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
		                </div>
		                @endif
                        {{ Form::open(array('url'=>'accounts/submitaccountupdate')) }}
                        {{ Form::hidden('id',$user->id,null) }}
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
                                                    {{ Form::text('username',$user->username,array('class'=>'form-control','placeholder'=>'Username')) }}
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>First Name
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon">>></span>
                                                    {{ Form::text('first_name',$user->first_name,array('class'=>'form-control','placeholder'=>'First Name')) }}
                                                </div>
                                            </td>
                                            <td>Last Name
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon">>></span>
                                                    {{ Form::text('last_name',$user->last_name,array('class'=>'form-control','placeholder'=>'Last Name')) }}
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                         @if($user->id!=1)
                                        <tr>
                                            <td><br/>Department</td>
                                            <td><br/>
                                            	{{ Form::select('user_class',array(""=>"--Select One--","Root"=>"Root Admin","IT"=>"IT","LAB"=>"LAB","F&A"=>"F&A"),$user->user_class,array("class"=>"form-control input-sm")) }}
                                            	
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @else
                                        	{{ Form::hidden('user_class',$user->user_class,null) }}
                                        @endif
                                        
                                        @if($user->id!=1)
                                        <tr>
                                            <td><br/>User Type</td>
                                            <td><br/>
                                            	{{ Form::select('user_type',array(""=>"--Select One--","Root"=>"Root Admin","Admin"=>"Admin","User"=>"User"),$user->user_type,array("class"=>"form-control input-sm")) }}
                                            	
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @else
                                        	{{ Form::hidden('user_type',$user->user_type,null) }}
                                        @endif
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="dateRegistered" />
                                                {{ Form::button('Cancel',array('class'=>'fright btn btn-sm','type'=>'button','onclick'=>"parent.location='".Session::get('page')."'")) }}
                                                {{ Form::button('Submit',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Update account?')","type"=>"submit")) }}
                                            </td>
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
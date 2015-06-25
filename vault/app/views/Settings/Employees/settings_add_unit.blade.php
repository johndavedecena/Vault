<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add Unit | Vault</title>
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
                        <h5>Add Unit</h5>
		            	@if(Session::get('message'))
		            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Registration Failed. </strong> {{ Session::get('message') }}
		                </div>
		                @endif
		                @if(Session::get('success'))
		            	<div class="alert alert-success alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Registration Successful. </strong> {{ htmlentities(Session::get('success')) }}
		                </div>
		                @endif
		                @if(Session::get('info'))
		            	<div class="alert alert-info alert-dismissible text-center" role="alert">
			                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
		                </div>
		                @endif
		                {{ Form::open(array("method"=>"post","url"=>URL('settings/employees/submitnewunit'))) }}
                            <div class="form-group">
                                <table class="table table-condensed table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="30%"></th>
                                            <th width="5%"></th>
                                            <th width="35%"></th>
                                            <th width="30%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>Unit Name</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon">>></span>
                                                    {{ Form::text('name','',array("class"=>"form-control","placeholder"=>"Unit Name")) }}
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Business Line</td>
                                            <td><div class="input-group input-group-sm">
                                                    <span class="input-group-addon">>></span>
                                                    {{ Form::select('business_line',$businessLines,'',array('class'=>'form-control input-sm','id'=>'businessLine',"onchange"=>"unitChanger()")) }}
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="dateRegistered" />
                                                {{ Form::button('Cancel',array('class'=>'fright btn btn-sm','type'=>'button','onclick'=>"parent.location='".Session::get('page')."'")) }}
                                                {{ Form::button('Submit',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Add new unit?')","type"=>"submit")) }}
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
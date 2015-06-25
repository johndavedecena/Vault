<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Start Secure Session | Vault</title>
    @include('Includes.css_tb')
</head>
<body>
    <div class="container">
        <nav class="navbar" role="navigation">
            @include('Includes.Menu.admin_menu')
        </nav>
        <!-- /navbar -->
        <div class="main_contain">
            <div class="space"></div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="fleft btn arrow-back"><a href="<?php echo Session::get('page')!=null ? Session::get('page'): URL() ?>"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    <h5>Start Secure Session</h5>
                        @if(Session::get('message'))
                        <div class="alert alert-danger alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <strong>Failed to Start Secure Session. </strong> {{ Session::get('message') }}
                        </div>
                        @endif
                        @if(Session::get('success'))
                        <div class="alert alert-success alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <strong>Secure Session Ended. </strong> {{ htmlentities(Session::get('success')) }}
                        </div>
                        @endif
                        @if(Session::get('info'))
                        <div class="alert alert-info alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                        </div>
                        @endif
                    	{{ Form::open(array("url"=>"accounts/startsecuresession","method"=>"post")) }}
                        <div class="form-group">
                            <table class="table table-condensed table-striped table-hover" style="margin:auto;width:900px">
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
                                        <td><p style="float:right;font-weight:900">Root Password</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::password('root_password',array("class"=>"form-control","placeholder"=>"Enter Your Root Account Password")) }}
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
                                            {{ Form::button('Cancel',array('class'=>'fright btn btn-sm','type'=>'button','onclick'=>"parent.location='".Session::get('page')."'")) }}
                                            {{ Form::button('Start Session',array("class"=>"fright btn btn-sm btn-info",'onclick'=>"return confirm('Start secure session?')","type"=>"submit")) }}
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
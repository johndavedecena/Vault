<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>User Login | Vault</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        @include('Includes.css_tb');
    </head>
    <body>
        <div class="container">           
            <div class="log_in-container"><br/>
                <section class="log_in">
                    <img src="{{ URL() }}/images/nwl/nwllogo.png"/>
                    <p class="log_in-subhead">Welcome to NetworkLabs<br/>IT Vault - Assets Management System.<br/></p>
                    @if(Session::get('message'))
	            	<div class="alert alert-danger alert-dismissible text-center" role="alert">
		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		                <strong>Authentication Failed. </strong> {{ Session::get('message') }}
	                </div>
	                @endif
	                <br/>
                    <div class="well">
                    {{ Form::open(array('url'=>'authenticate','method'=>'post')) }}
                            <div class="form-group">
                            {{ Form::text('username','',array('placeholder'=>'Username', 'class'=>'form-control')) }}
                            </div>
                            <div class="form-group">
                            {{ Form::password('password',array('placeholder'=>'Password', 'class'=>'form-control')) }}
                            </div>
                            <div class="form-group">
                                <!-- <p><a class="fleft" href="#"><< Forgot Password</a></p> -->
                                {{ Form::submit('Login',array('class'=>'btn btn-primary btn-wide fright')) }}
                            </div>
                    {{ Form::close() }}
                    </div>
                </section>
            </div>
        </div><!-- /.container -->
        <!-- Load JS here -->
        @include('Includes.Scripts.scripts')
    </body>
</html>
<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Import Employees | Vault</title>
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
                    <li><a href="{{ URL() }}/employees">All Employees</a></li>
                    <li @if(!empty($status) && $status=="on-board") class="active" @endif><a href="{{ URL() }}/employees/filter/on-board" role="tab">On-Board</a></li>
                    <li @if(!empty($status) && $status=="temporary") class="active" @endif><a href="{{ URL() }}/employees/filter/temporary" role="tab">Temporary Employees</a></li>
                    <li @if(!empty($status) && $status=="ojt") class="active" @endif><a href="{{ URL() }}/employees/filter/ojt" role="tab">OJT</a></li>
                    <li @if(!empty($status) && $status=="academy") class="active" @endif><a href="{{ URL() }}/employees/filter/academy" role="tab">Academy</a></li>
                    <li class="active" style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/import">Import Data</a></li>
                    <li style="float:right"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                            	<h5 class="in-line">Import Employees <a class="text-small" href="{{ URL() }}/forms/import_employees.xlsx" >(Download Form)</a> </h5>
                                @if(Session::get('message'))
                                <div class="alert alert-danger alert-dismissible text-center" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <strong>Import Failed. </strong> {{ Session::get('message') }}
                                </div><br/>
                                @endif
                                {{ Form::open(array("url"=>"employees/postimport","method"=>"post","files"=>true)) }} 
                                <div class="input-group input-group-sm col-md-4 col-md-offset-4">
                                	{{ Form::file('file',array("class"=>"form-control","style"=>"width:300px;height:40px","enctype"=>"multipart/form-data")) }}
                                	{{ Form::button('Upload',array("type"=>"submit","class"=>"btn btn-info")) }}
                                </div>
                            	{{ Form::close() }}
                                <div class="space"></div>
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
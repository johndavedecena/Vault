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
                    <li style="float:right;margin-right:-2px"><a href="{{ URL() }}/employees/import">Import Data</a></li>
                    <li style="float:right"><a href="{{ URL() }}/employees/advancedsearch">Advanced Search</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                        	<div class="tab-pane active">
                        		@if($fileHasError && !$hasCorrectRows)
                        		<section class="text-center"><h5>Import Failed.</h5></section>
		                        <div class="alert alert-danger alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        		<strong>Import Failed. </strong> 0 rows have been saved to the database.</div>
                        		@elseif($fileHasError && $hasCorrectRows)
                        		<section class="text-center"><h5>Import Partially Successful</h5></section>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        		<strong>Import Partially Successful. </strong> You have successfully updated the employees database with {{ count($rowsWithErrors) }} error(s).</div>
                        		@elseif(!$fileHasError)
                        		<section class="text-center"><h5>Import Successful</h5></section>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        		<strong>Import Successful. </strong> You have successfully updated the employees database without any errors.</div>
                        		@endif
                                @if($fileHasError)
                                <section class="text-center text-medium">These row(s) were skipped due to errors.</section>
                                <table class="table table-bordered" style="width:1000px;margin:auto">
                                    <thead>
                                        <tr>
                                            <th width="20%" class="text-center">Row Number</th>
                                            <th width="80%">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($rowsWithErrors)) { foreach($rowsWithErrors as $row) { ?>
                                        <tr>
                                            <td class="text-center">{{ $row }}</td>
                                            <td>
                                            <?php foreach($errorDetails[$row] as $errors) { ?>
                                            	{{ $errors }}
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    } ?>
                                    </tbody>
                                </table>
                             @endif
                            </div>
                        </div>
                        <div class="space"></div>
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
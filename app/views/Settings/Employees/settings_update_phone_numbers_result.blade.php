<?php Session::put('page',Request::url()."?page=".Input::get('page')); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Update Employees Phonue Numbers | Vault</title>
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
                    @include("Includes.Tabs.Settings.settings_employees_tabs")
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                        	<div class="tab-pane active">
                        		@if($fileHasError && !$hasCorrectRows)
                        		<section class="text-center"><h5>Update Failed.</h5></section>
		                        <div class="alert alert-danger alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        		<strong>Update Failed. </strong> 0 rows have been saved to the database.</div>
                        		@elseif($fileHasError && $hasCorrectRows)
                        		<section class="text-center"><h5>Import Partially Successful</h5></section>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        		<strong>Import Partially Successful. </strong> You have successfully updated the employees database with {{ count($rowsWithErrors) }} error(s).</div>
                        		@elseif(!$fileHasError)
                        		<section class="text-center"><h5>Import Successful</h5></section>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        		<strong>Update Successful. </strong> You have successfully updated the employees database without any errors.</div>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add/Change OS Image | Vault</title>
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
                    <div class="fleft btn arrow-back"><a href="{{ URL() }}/assets/client/update/laptops/{{ $asset->id }}"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    <h5>Add/Change OS Image</h5>
                    <p style="padding-left:1.8cm;"><b>Asset :</b> {{ $asset->asset_tag }}, <b>SN :</b> {{ $asset->serial_number }}</p>
                    @if(Session::get('message'))
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>OS Image Update Failed. </strong> {{ Session::get('message') }}
                    </div>
                    @endif
                    @if(Session::get('success'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>OS Image Update Successful. </strong> {{ htmlentities(Session::get('success')) }}
                    </div>
                    @endif
                    @if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif
                    {{ Form::open(array("url"=>"assets/client/saveimage","method"=>"post")) }}
                    {{ Form::hidden("id",$asset->id) }}
                        <div class="form-group">
                            <table class="table table-condensed table-striped table-hover" style="width:900px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="30%"></th>
                                        <th width="40%"></th>
                                        <th width="30%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                            <span class="input-group-addon">>></span>
                                            	{{ Form::select("image",$images,$asset->image,array("class"=>"form-control","style"=>"width:360px")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <button class="fright btn btn-sm">Cancel</button>
                                            <button class="fright btn btn-sm btn-info">Save</button>
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
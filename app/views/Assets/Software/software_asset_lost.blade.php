<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Log Asset as Lost | Vault</title>
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
                    <div class="fleft btn arrow-back"><a href="{{ URL() }}/assets/software/update/{{ $software->id }}"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    <h5>Log as Lost</h5>
                    <p style="padding-left:1.8cm;"><b>Software :</b> {{ $software->asset_tag }}</p>
                    @if(Session::get('message'))
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Update Failed. </strong> {{ Session::get('message') }}
                    </div>
                    @endif
                    @if(Session::get('success'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Asset Update Successful. </strong> {{ htmlentities(Session::get('success')) }}
                    </div>
                    @endif
                    @if(Session::get('info'))
                    <div class="alert alert-info alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Information. </strong> {{ htmlentities(Session::get('info')) }}
                    </div>
                    @endif
                    {{ Form::open(array("url"=>"assets/software/lost","method"=>"post")) }}
                        {{ Form::hidden("id",$software->id) }}
                        <div class="form-group">
                            <table class="table table-condensed table-striped table-hover" style="width:900px;margin:auto">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th width="30%"></th>
                                        <th width="50%"></th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody><tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Current User :</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                @if(!empty($software->employee->last_name))
                                                <input type="text" value="{{ $software->employee->first_name.' '.$software->employee->last_name }}" class="form-control input-sm" disabled>
                                                    @else
                                                    <input type="text" value="None" class="form-control input-sm" disabled>
                                                    @endif
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><p style="float:right;font-weight:900">Assign to :</p></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">>></span>
                                                {{ Form::text("employee_number","",array("id"=>"employee_search","placeholder"=>"Employee")) }}
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>  
                                        <td></td>
                                        <td>
                                            <button type="button" class="fright btn btn-sm" onclick="parent.location='{{ URL() }}/assets/software/update/{{ $software->id }}'">Cancel</button>
                                            {{ Form::button("Save",array("name"=>"save","type"=>"submit","class"=>"fright btn btn-sm btn-info")) }}
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
<script type="text/javascript">
    var root = '{{URL("/")}}';
</script>
</body>
</html>
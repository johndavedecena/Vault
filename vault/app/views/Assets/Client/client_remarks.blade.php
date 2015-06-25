<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Client Asset Remarks | Vault</title>
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
                    <div class="fleft btn arrow-back"><a href="{{ URL() }}/assets/client/update/{{ $asset->classification->url_key }}/{{ $asset->id }}"><i class="fa fa-arrow-circle-o-left fa-3x"></i></a></div>
                    <div class="fright">
                        <button type="button" onclick="parent.location='{{ URL() }}/assets/client/addremarks/{{ $asset->id }}'" class="btn btn-sm btn-info">Add Remarks</button>
                    </div>
                    <h5>Asset Remarks ({{ $asset->status }})</h5>
                    <p style="padding-left:1.8cm;"><b>Asset :</b> {{ $asset->asset_tag }}, <b>SN :</b> {{ $asset->serial_number }}</p>
                    <div class="form-group">
                        <table class="table table-bordered table-condensed table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30%"><p>Part</p></th>
                                    <th width="30%"><p>Part Status</p></th>
                                    <th width="32%"><p>Remarks</p></th>
                                    <th width="8%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($assetRemarks as $ar) { ?>
                                <tr>
                                    <td>{{ $ar->part }}</td>
                                    <td>{{ $ar->part_status }}</td>
                                    <td>@if(!empty($ar->remarks)) {{ $ar->remarks }} @else {{ "No additional remarks." }} @endif</td>
                                    <td>
                                        <div class="row">
                                            @if(Session::get("user_type")=='Root')
                                            <span class="col-md-1 fa-stack fa-lg" onclick="confirmDelete({{ $ar->id }})"><a href="#" title="Delete"><i class="fa fa-remove fa-stack-1x fa-inverse"></i></a></span>
                                            @endif
                                            <span class="col-md-1 fa-stack fa-lg"><a href="{{ URL() }}/assets/client/updateremark/{{ $ar->id }}" title="Update"><i class="fa fa-file fa-stack-1x fa-inverse"></i></a></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="pagination center">
                            @if($assetRemarks->links()!=null)
                                {{ $assetRemarks->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
    @include('Includes.footer')
    <script type="text/javascript">
    function confirmDelete(id){
            var con = confirm("Are you sure you want to delete this asset remark?");
            if(con==true){
                    parent.location="{{ URL() }}/assets/client/deleteremark/"+id;
            }
    }
	</script>
    <!-- /.footer -->
<!-- Load JS here for greater good =============================-->
@include('Includes.Scripts.scripts')
</body>
</html>
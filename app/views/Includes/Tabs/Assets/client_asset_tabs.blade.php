<li @if(isset($tab) && $tab=="laptops") class="active" @endif><a href="{{ URL() }}/assets/client/view/laptops">Laptops</a></li>
<li @if(isset($tab) && $tab=="monitors") class="active" @endif><a href="{{ URL() }}/assets/client/view/monitors">Monitors</a></li>
<li @if(isset($tab) && $tab=="dockingstations") class="active" @endif><a href="{{ URL() }}/assets/client/view/dockingstations">Docking Stations</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="import") class="active" @endif><a href="{{ URL() }}/assets/client/import">Import Data</a></li>
<li style="float:right"  @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/client/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px"  @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/client/advancedsearch">Advanced Search</a></li>
@endif

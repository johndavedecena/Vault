<li @if(isset($tab) && $tab=="printers") class="active" @endif><a href="{{ URL() }}/assets/office/view/printers">Printers</a></li>
<li @if(isset($tab) && $tab=="projectors") class="active" @endif><a href="{{ URL() }}/assets/office/view/projectors">Projectors</a></li>
<li @if(isset($tab) && $tab=="otherassets") class="active" @endif><a href="{{ URL() }}/assets/office/view/otherassets">Other Assets</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="import") class="active" @endif><a href="{{ URL() }}/assets/office/import">Import Data</a></li>
<li style="float:right" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/office/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/office/advancedsearch">Advanced Search</a></li>
@endif

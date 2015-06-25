<li @if(isset($tab) && $tab=="General Information") class="active" @endif><a href="{{ URL() }}/assets/IP">General Information</a></li>
<li @if(isset($tab) && $tab=="Usage Status") class="active" @endif><a href="{{ URL() }}/assets/IP">Usage Status</a></li>
<li @if(isset($tab) && $tab=="Reports") class="active" @endif><a href="{{ URL() }}/assets/IP">Reservation</a></li>
<li @if(isset($tab) && $tab=="Reports") class="active" @endif><a href="{{ URL() }}/assets/IP">Reports</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="import") class="active" @endif><a href="{{ URL() }}/assets/software/import">Import Data</a></li>
<li style="float:right" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/software/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/IP/advancedsearch">Advanced Search</a></li>
@endif

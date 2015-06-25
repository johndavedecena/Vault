<li @if(isset($tab) && $tab=="software") class="active" @endif><a href="{{ URL() }}/assets/software">Software Assets</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="import") class="active" @endif><a href="{{ URL() }}/assets/software/import">Import Data</a></li>
<li style="float:right" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/software/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/software/advancedsearch">Advanced Search</a></li>
@endif

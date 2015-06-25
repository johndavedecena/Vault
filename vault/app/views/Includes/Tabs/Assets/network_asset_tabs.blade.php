<li @if(isset($tab) && $tab=="accesspoints") class="active" @endif><a href="{{ URL() }}/assets/network/view/accesspoints">Access Points</a></li>
<li @if(isset($tab) && $tab=="routers") class="active" @endif><a href="{{ URL() }}/assets/network/view/routers">Routers</a></li>
<li @if(isset($tab) && $tab=="switches") class="active" @endif><a href="{{ URL() }}/assets/network/view/switches">Switches</a></li>
<li @if(isset($tab) && $tab=="sfp") class="active" @endif><a href="{{ URL() }}/assets/network/view/sfp">SFP</a></li>
<li @if(isset($tab) && $tab=="ups") class="active" @endif><a href="{{ URL() }}/assets/network/view/ups">UPS</a></li>
<li @if(isset($tab) && $tab=="voip") class="active" @endif><a href="{{ URL() }}/assets/network/view/voip">VoIP Phones</a></li>
<li @if(isset($tab) && $tab=="servers") class="active" @endif><a href="{{ URL() }}/assets/network/view/servers">Servers</a></li>
@if(Session::get("user_type")!="User")
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="import") class="active" @endif><a href="{{ URL() }}/assets/network/import">Import Data</a></li>
<li style="float:right" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/network/advancedsearch">Advanced Search</a></li>
@else
<li style="float:right;margin-right:-2px" @if(isset($tab) && $tab=="search") class="active" @endif><a href="{{ URL() }}/assets/network/advancedsearch">Advanced Search</a></li>
@endif

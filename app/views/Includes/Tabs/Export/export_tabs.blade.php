<li @if(isset($tab) && $tab=="client") class="active" @endif><a href="{{ URL() }}/export/client">Client Assets</a></li>
<li @if(isset($tab) && $tab=="network") class="active" @endif><a href="{{ URL() }}/export/network">Network Assets</a></li>
<li @if(isset($tab) && $tab=="office") class="active" @endif><a href="{{ URL() }}/export/office">Office Assets</a></li>
<li @if(isset($tab) && $tab=="software") class="active" @endif><a href="{{ URL() }}/export/software">Software Assets</a></li>
<li @if(isset($tab) && $tab=="employees") class="active" @endif><a href="{{ URL() }}/export/employees">Employees</a></li>

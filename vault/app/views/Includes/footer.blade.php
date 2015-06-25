<footer class="footer">
	<div class="header_footer">
		<p>&copy; 2014 NetworkLabs Inc.
		@if(Session::has("username") && Session::get("user_type")=="Root")
			| <a href="{{ URL() }}/manual/root_manual_vault.pdf"> Help </a>
		@elseif(Session::has("username") && Session::get("user_type")=="Admin")
			| <a href="{{ URL() }}/manual/it_manual_vault.pdf"> Help </a>
		@else
			| <a href="{{ URL() }}/manual/user_manual_vault.pdf"> Help </a>
		@endif
		</p>
        <img src="{{ URL() }}/images/footer/nwl-logo-footer.png"/>
    </div>
</footer>
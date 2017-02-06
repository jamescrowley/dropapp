<header class="header-top">
	<div class="header-top-inner container-fluid">
 		<div class="pull-left">
			<a href="#" class="menu-btn visible-xs">&#9776;</a>
			{if $smarty.session.user.usertype=='family'}
				<a href="/flip/?action=status" class="brand">{$translate['site_name']}</a>
			{else}
				<a href="/flip" class="brand">{$translate['site_name']}</a>
			{/if}
 		</div>
 		<div class="camp-menu">
 		</div>
		<ul class="nav pull-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user visible-xs"></i><span class="hidden-xs">{$smarty.session.user.naam} {if $smarty.session.user2}({$smarty.session.user2.naam}){/if}</span><b class="caret"></b></a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="?action=cms_profile">{$translate['cms_menu_settings']}</a></li>
{if $smarty.session.user2}<li><a href="?action=exitloginas">{$translate['cms_menu_exitloginas']|replace:'%user%':$smarty.session.user2.naam}</a></li>{/if}
					<li><a href="?action=logout">{$translate['cms_menu_logout']}</a></li>
				</ul>
			</li>
		</ul>
 		<ul id="usersonline" class="pull-right hidden-xs"></ul>
	</div>
</header>

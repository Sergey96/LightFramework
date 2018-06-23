<ul class='sidebar-menu'>
	<li class='sidebar-header'></li>
	<?php
		foreach($menus as $id => $menu){
			echo $this->render('li', [
					'section'=>$menu[0]['section'],
					'menu'=>$menu
				]); 
		}
	?>
</ul>
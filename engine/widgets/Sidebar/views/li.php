<li>
	<a href='#'><span><?= $section ?></span></a>
	<ul class='sidebar-submenu'>
		<?php
			foreach($menu as $value){
				echo $this->render('submenu', [
						'href'=>$value['link'],
						'title'=>$value['submenu']
					]);
			}
			?>
	</ul>
</li>
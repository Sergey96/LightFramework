<?php
	
use engine\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->params['breadcrumbs'] = array();
?>

<!DOCTYPE html>
<html>
<?php $this->startHead() ?>
	<title><?= $this->title ?></title>
	
<?php $this->endHead() ?>
<body>
	<div id="page">
		<div id="sidebar">
			<ul class='sidebar-menu'>
			  <li class='sidebar-header'>MAIN NAVIGATION</li>
			  <li>
				<a href='#'><span>HOME</span></a>
				<ul class='sidebar-submenu'>
				  <li><a href='/home/'>HOME index</a></li>
				</ul>
			  </li>
			  <li>
				<a href='#'><span>FILMS</span></a>
				<ul class='sidebar-submenu'>
				  <li><a href='/films/'>FILMS index</a></li>
				  <li><a href='/films/create'>FILMS create</a></li>
				  <li><a href='/films/view?id=1'>FILMS view</a></li>
				  <li><a href='/films/update?id=1'>FILMS update</a></li>
				</ul>
			  </li>
			  <li>
				<a href='#'><span>Генератор кода</span></a>
				<ul class='sidebar-submenu'>
				  <li><a href='/gii/'>GII index</a></li>
				  <li><a href='/gii/crud'>GII CRUD</a></li>
				  <li><a href='/gii/models'>GII Models</a></li>
				</ul>
			  </li>
			</ul>
		</div>
		<div id="wrapper">
			<div id="wrapper-title">
				<div id="breadcrumbs">
					<?php Breadcrumbs::View($this->params['breadcrumbs']);?>
				</div>
				<div id="content-title">
					<div id="content-title-string">
						<p><?= $this->title ?></p>
					</div>
					<div id="content-title-img">
						<img src=''>
					</div>
				</div>
				<div id="reminder">
					<img src=''>
				</div>
			</div>
			<div id="content">
				<!-- FILTERS -->
				<?php 
				/*
					$FILTER = new Filter();
					print_r($FILTER->printFilters(array(	
											"category"=>"Категория", 
											"key"=>"Ключ", 
											"value"=>"Значение"
										)));
										*/
				?>
				
				<div id="data">
					<!-- TABLE -->
					<?php echo $content;?>
				</div>
			</div>
		</div>
	</div>
<?php $this->endBody() ?>
</body>
<script src="/dist/sidebar-menu.js"></script>
<script type='text/javascript'>
	$.sidebarMenu($('.sidebar-menu'))
	var HH = 71;
	function hideBox(el){
		if($("#filters-body").hasClass( "v" )){
			$("#filters-body").height(1)
			$("#filters-body").removeClass( "v" )
			el.style.transform  = "rotate(0deg)";
		}
		else {
			$("#filters-body").addClass( "v" )
			$("#filters-body").height(HH)
			el.style.transform  = "rotate(-90deg)";
		}
		
	}
</script>
</html>
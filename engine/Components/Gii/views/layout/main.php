<?php
	
use engine\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->params['breadcrumbs'] = array();
?>

<!DOCTYPE html>
<html>
<head>
	<title><?= $this->title ?></title>
	<link rel="stylesheet" href="/css/maket.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="/dist/sidebar-menu.css">
	
</head>
<body>
	<div id="page">
		<div id="sidebar">
			<?php //print_r($side->printSideBar()); ?>

		</div>
		<div id="wrapper">
			<div id="wrapper-title">
				<div id="breadcrumbs">
					<?php Breadcrumbs::printBreadcrumbs($this->params['breadcrumbs']);?>
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
<script src="/js/jquery-3.0.0.min.js"></script>
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
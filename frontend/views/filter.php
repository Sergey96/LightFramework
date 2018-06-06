<?php
	
class Filter{
	
	public function printFilters($properties ){
		$string = "<div id='filters'>
					<div id='filters-header'>
						<div id='filters-title'>
							<p>Фильтры</p>
						</div>
						<div id='filters-title-img'>
							<p onclick='hideBox(this)'><</p>
						</div>
					</div>
					<div id='filters-body' class=''>";
					
			foreach($properties as $k => $v){
				$string .="<div class='filters-field'>
							<label><p>".$v."</p>
								<input type='text' name='".$k."' onchange=''>
							</label>
						</div>";
					}
						
				$string .= "<div id='filters-clear'>
							<button class='btn-standart btn-gray' onclick='filtersClear();'>Сбросить</button>
						</div>
					</div>
				</div>";
		return $string;
	}
}
	
?>
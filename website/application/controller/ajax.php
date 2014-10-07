<?php
class Ajax extends Controller {
	public function searchStation($query = ""){
		$stationService = $this->loadModel("StationService");

		$stations = $stationService->searchStation($query);
		require 'application/views/ajax/searchstation.php';
	}
}
?>
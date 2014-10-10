<?php
class Ajax extends Controller {
	public function searchStation($query = ""){
        $this->title = "Search Station";
        $stationService = new StationService($this->db);

		$stations = $stationService->searchStation($query);
		require 'application/views/ajax/searchstation.php';
	}
}
?>
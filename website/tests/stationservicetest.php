<?php
require '../website/application/config/config.php';
class StationServiceTest extends PHPUnit_Framework_TestCase
{

	private $db = null;
	function __construct(){
		parent::__construct();
		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->db, "utf8");

	}

	public function testValidate()
	{
		//arrange
		$stationService = new StationService($this->db);
		
		$station = new Station(1, "test station name", "test address", 57.1, 9.2);
		$result = $stationService->validate($station);
		$this->AssertEquals(true, $result);
	}

	public function testReadStation()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "test station name", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations

		$stationService->create($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertEquals(10000, $station->station_id);
		$this->AssertEquals("test station name", $station->name);
		$this->AssertEquals("test address", $station->address);
		$this->AssertEquals(57.1, $station->latitude);
		$this->AssertEquals(9.2, $station->longitude);

		$stationService->delete($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertEquals(null, $result);
	}

	public function testreadAllStations()
	{
		$stationService = new StationService($this->db);

		$resultbefore = $stationService->readAllStations();
		$station = new Station(10000, "test station name", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations

		$stationService->create($station);
		$resultafter = $stationService->readAllStations();

		$this->AssertEquals(count($resultbefore), count($resultafter) - 1);

		$stationService->delete($station);
		$resultafterdeletion = $stationService->readAllStations();
		$this->AssertEquals(count($resultbefore), count($resultafterdeletion));
	}

	//TODO later
	public function testReadAllAvailableStations()
	{

	}

	public function testReadAllValableDocks()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "test station name", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);

		$resultwithoutdocks = $stationService->readAllAvailableDocks();
		$this->AssertEquals(0, $resultwithoutdocks[10000]);

		//Give the station some docks
		$dockService = new DockService($this->db);
		
		$dock1 = $dockService->create(new Dock(null, 10000, null));
		$dock2 = $dockService->create(new Dock(null, 10000, null));

		$resultwithdocks = $stationService->readAllAvailableDocks();
		$this->AssertEquals(2, $resultwithdocks[10000]);

		$stationService->delete($station);
	}

	//To be continued
	public function testSearchStation()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojiokoate test station", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);

		$this->AssertEquals(count($stationService->readAllStations()), count($stationService->searchStation()));
		
		$result = $stationService->searchStation("fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojioko");
		$this->AssertEquals(1, count($result));
		$stationService->delete($station);
		$result = $stationService->searchStation("fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojioko");
		$this->AssertEquals(0, count($result));
	}


}
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

		$stationService->deleteForTest($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertEquals(null, $result);
	}

	public function testreadAllStations()
	{
		$stationService = new StationService($this->db);

		$resultbefore = $stationService->readAllStations();
		$station = new Station(10000, "test station name", "test address", 57.1, 9.2, "127.0.0.1"); //assuming the system does not reach a higher amount than 10000 stations

		$stationService->create($station);
		$resultafter = $stationService->readAllStations();

		$this->AssertEquals(count($resultbefore), count($resultafter) - 1);

		$stationService->deleteForTest($station);
		$resultafterdeletion = $stationService->readAllStations();
		$this->AssertEquals(count($resultbefore), count($resultafterdeletion));
	}

	public function testReadAllAvailableBicycles()
	{
		//This is going to be a rough test
		$stationService = new StationService($this->db);

		$station = new Station(10000, "test station name", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);

		//Give the station some docks
		$dockService = new DockService($this->db);
		
		$dock1 = $dockService->create(new Dock(null, 10000, null));
		$dock2 = $dockService->create(new Dock(null, 10000, null));

		$result = $stationService->readAllAvailableBicycles();
		$this->AssertEquals(0, $result[10000]);

		//We need some test bicycles in the system
		$bicycleService = new BicycleService($this->db);
		$bicycle1 = $bicycleService->create(new Bicycle(null, null, null));
		$bicycle2 = $bicycleService->create(new Bicycle(null, null, null));

		$dock1->holds_bicycle = $bicycle1->bicycle_id;
		$dockService->update($dock1);

		$result = $stationService->readAllAvailableBicycles();
		$this->AssertEquals(1, $result[10000]);

		$dock2->holds_bicycle = $bicycle2->bicycle_id;
		$dockService->update($dock2);

		$result = $stationService->readAllAvailableBicycles();
		$this->AssertEquals(2, $result[10000]);


		$stationService->deleteForTest($station);
		$bicycleService->delete($bicycle1);
		$bicycleService->delete($bicycle2);
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

		$stationService->deleteForTest($station);
	}

	
	public function testSearchStation()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojiokoate test station", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);

		$this->AssertEquals(count($stationService->readAllStations()), count($stationService->searchStation()));
		
		$result = $stationService->searchStation("fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojioko");
		$this->AssertEquals(1, count($result));
		$stationService->deleteForTest($station);
		$result = $stationService->searchStation("fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojioko");
		$this->AssertEquals(0, count($result));
	}

	public function testCreate()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojiokoate test station", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertNotEquals(null, $result);
		$stationService->deleteForTest($station);
	}

	public function testUpdate()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojiokoate test station", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);

		//Change the name
		$station->name = "proper name";
		$stationService->update($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertEquals("proper name", $result->name);

		//Change the Address
		$station->address = "new test address";
		$stationService->update($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertEquals("new test address", $result->address);

		//Change the longitude
		$station->longitude = 57.2;
		$stationService->update($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertTrue($result->longitude -  57.2 < 0.01 && $result->longitude - 57.2 > -0.01); // need to do it like this, due to floating point lacking precision

		//Change the latitude
		$station->latitude = 9.4;
		$stationService->update($station);
		$result = $stationService->readStation($station->station_id);
		$this->AssertTrue($result->latitude -  9.4 < 0.01 && $result->latitude - 9.4 > -0.01);
		$stationService->deleteForTest($station);
	}

	public function testDelete()
	{
		$stationService = new StationService($this->db);
		$station = new Station(10000, "fasjjosgdjiodsgjposerjoåipherjoiasfjaefjiojiokoate test station", "test address", 57.1, 9.2); //assuming the system does not reach a higher amount than 10000 stations
		$stationService->create($station);
		$result = $stationService->readStation($station->station_id);
		$stationService->delete($station);
		$resultafter = $stationService->readStation($station->station_id);
		$this->AssertNotEquals($result, $resultafter);
		$stationService->deleteForTest($station);
	}


}



























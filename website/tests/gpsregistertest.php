<?php 
require '../website/application/config/config.php';
class GPSRegisterTest extends PHPUnit_Framework_TestCase 
{   
    private $db = null;

 	function __construct(){
  		parent::__construct();
  		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->db, "utf8");
 	}

    private function RegisterGPS($bicycle_id, $latitude, $longitude)
    {
        global $db;
        $stmt = $this->db->prepare("UPDATE bicycle SET latitude = ?, longitude = ? WHERE bicycle_id = ?");
        $stmt->bind_param("ddi", $latitude, $longitude, $bicycle_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $this->db->prepare("INSERT INTO historylocationbicycle(bicycle_id, latitude, longitude) VALUES (?,?,?)");
        $stmt->bind_param("idd", $bicycle_id, $latitude, $longitude);
        $stmt->execute()
        $stmt->close();
        return true;
    }

    public function testRegisterGPS() 
    {
        $this->assertTrue($this->RegisterGPS(1, 57.0134052, 9.988917));
        
    }
    
    
}
?>
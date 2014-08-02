<?php
include 'funcs.php';
include 'rest.inc.php';

class API extends REST {
	function __construct(){
		parent::__construct();
    }	

	//Public method for access api.
    //This method dynmically call the method based on the query string
	public function processApi(){	
		$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
		if((int)method_exists($this,$func) > 0){
			$this->$func();
		}
		else{
			$this->response('',404);
		}				// If the method not exist with in this class, response would be "Page not found".
    }
	
	public function getImageDetails(){
		$obj = new MainFuncs();
		$sql = "SELECT * FROM ads limit 3";
		$imgs = $this->getDataResult($sql);
		$response["ads"] = array();
		$count = mysql_num_rows($imgs);
		
		if($count > 0){
			$response["tag"] = 'images';
			$response["success"] = 1;			
			$response["error"] = 0;
			
			while($row = mysql_fetch_array($imgs)){
				$ad = array();
       			$ad["ads_id"] = $row["ads_id"];
			   	$ad["ads_name"] = $row["ads_name"];
			   	$ad["image_url"] = $row["image_url"];
			   	$ad["cycles"] = $row["cycles"];
			   	$ad["ads_metadata"] = $row["ads_metadata"];
			   	$ad["phone_cycles"] = $row["phone_cycles"];
        		array_push($response["ads"], $ad);
			}
			
			$returnformat = 'json';
			
			if($returnformat =='json'){
				$this->response($this->json($response), 200, $returnformat);
			}
		}
	}
	
	public function getNewImage(){
		$obj = new MainFuncs();
		$imei = $this->_request['imei'];
		$sql = "SELECT * FROM ads WHERE ads_id NOT IN (SELECT image_id FROM status where imei = $imei) limit 1";
		$imgs = $this->getDataResult($sql);
		$response["ads"] = array();
		$count = mysql_num_rows($imgs);
		
		if($count > 0){
			$response["tag"] = 'images';
			$response["success"] = 1;			
			$response["error"] = 0;
			
			while($row = mysql_fetch_array($imgs)){
				$ad = array();
				$ad["ads_id"] = $row["ads_id"];
			    $ad["ads_name"] = $row["ads_name"];
			    $ad["image_url"] = $row["image_url"];
			    $ad["cycles"] = $row["cycles"];
			   	$ad["ads_metadata"] = $row["ads_metadata"];
			   	$ad["phone_cycles"] = $row["phone_cycles"];
				array_push($response["ads"], $ad);
			}
			
			$returnformat = 'json';
			
			if($returnformat =='json'){
				$this->response($this->json($response), 200, $returnformat);
			}
		}
		else{
			$this->response('',204,'');
		}
	}
	
	/**
	 * Get Client Ads
	 * @rerturn json
	 */
	public function getAds(){
		$sql = "SELECT * FROM client_ads";
		$ads = $this->getDataResult($sql);
		
		$clientads = array();
		$count = mysql_num_rows($ads);
		
		if($count > 0){
			$clientads["ads"] = array();
			$clientads["tag"] = 'ads';
			$clientads["success"] = 1;			
			$clientads["error"] = 0;
			
			while($row = mysql_fetch_array($ads)){
				$ad = array();
				$ad["id"] = $row["id"];
				$ad["area"] = $row["area"];
				$ad["client_id"] = $row["client_id"];
				$ad["cycles"] = $row["cycles"];
				$ad["image_name"] = $row["image_name"];
				$ad["metadata"] = $row["metadata"];
				$ad["phone_cycles"] = $row["phone_cycles"];
				$ad["ad_name"] = $row["ad_name"];
				$ad["time_of_day"] = $row["time_of_day"];
				$ad["day_of_week"] = $row["day_of_week"];
				$ad["approved"] = $row["approved"];
				$ad["time_of_day"] = $row["time_of_day"];
				$ad["day_of_week"] = $row["day_of_week"];
				$ad["approved_by"] = $row["approved_by"];
				$ad["sex"] = $row["sex"];
				
				/*$time_of_day = $row["time_of_day"];
				$time_of_day = explode(",", $time_of_day);
				
				for($i = 0; $i < sizeof($time_of_day); $i++){
					$ad[$time_of_day[$i]] = "true";
				}
				
				$day_of_week = $row["day_of_week"];
				$day_of_week = explode(",", $day_of_week);
				
				for($i = 0; $i < sizeof($day_of_week); $i++){
					$ad[$day_of_week[$i]] = "true";
				}*/
				
				array_push($clientads["ads"], $ad);
			}
			$returnformat = 'json';
			
			if($returnformat =='json'){
				$this->response($this->json($clientads), 200, $returnformat);
			}
		}
		else{
			$this->response('',204,'');
		}
		mysql_close($conn);
	}
	
	/**
	 * Get data 
	 * @return Resultset
	 */
	private function getDataResult($sql){
		$obj = new MainFuncs(); 
	    $query_result = $obj->processReturnQuery($sql);
		return $query_result;
	}
	
	/*
	 *	Encode array into JSON
	*/
	private function json($data){
		if(is_array($data)){
			return json_encode($data);
		}
	}
}
	// Initiiate Library
	
	$api = new API;
	$api->processApi();

?>

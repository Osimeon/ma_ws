<?php
	$conn = mysql_connect('localhost', 'root', '') or die(mysql_error());
	mysql_select_db('mobiads', $conn) or die(mysql_error());
	
	/*$sql = "SELECT id FROM client_ads";
	$id_result = mysql_query($sql);
	
	$local_ids = array();
	$remote_ids = array();
	$ads = array();
	*/
	/*if($id_result){
		while($row = mysql_fetch_array($id_result)){
			$local_ids[] = $row["id"];
		}
	}*/
	
	$json = file_get_contents('http://localhost/ma_ws/clientads/getAds'); 
	
	$json_a = json_decode($json, true);
	$json_o = json_decode($json);
	
	
	foreach($json_a[ads] as $p){
		/*$remote_ids [] = $p[id];*/
		$sql = "INSERT INTO client_ads (id, sex, area, time_of_day, day_of_week, client_id, cycles, image_name, metadata, phone_cycles, approved, approved_by, ad_name) VALUES ($p[id], '$p[sex]', '$p[area]', '$p[time_of_day]', '$p[day_of_week]', '$p[client_id]', $p[cycles], '$p[image_name]', '$p[metadata]', $p[phone_cycles], '$p[approved]', '$p[approved_by]', '$p[ad_name]')";
		/*$ads[$p[id]] = array('id' => $id = $p[id], 'area' => $p[area], 'client_id' => $p[client_id],
								'cycles' => $p[cycles], 'image_name' => $p[image_name], 'metadata' => $p[metadata],
								'phone_cycles' => $p[phone_cycles], 'ad_name' => $p[ad_name], 'time_of_day' => $p[time_of_day],
								'day_of_week' => $p[day_of_week], 'approved' => $p[approved], 'approved_by' => $p[approved_by]);*/
		mysql_query($sql);
	}
	
	/*print_r($local_ids);
	echo '<br/>';
	print_r($remote_ids);
	echo '<br/>';*/
	/*print_r($ads);
	echo '<br/>';
	
	$str_local_ids = implode(",", $local_ids);
	
	for($i = 0; $i < sizeof($remote_ids); $i++){
		
		//echo ($remote_ids[$i]);
		
		if(in_array($remote_ids[$i], $local_ids)){
			echo 'That ID Exists In Local';
		}
		else{
			echo 'That ID Does Not Exist';
			$sql = "INSERT INTO client_ads";
		}
	}*/
?>
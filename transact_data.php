<?php
	$conn = mysql_connect('localhost', 'root', 'makinifu2x4#@') or die(mysql_error());
	mysql_select_db('mobiads', $conn) or die(mysql_error());
	
	$json = file_get_contents('http://mobiadskenya.com/ma_ws/clientads/getAds'); 
	
	$json_a = json_decode($json, true);
	$json_o = json_decode($json);
	
	
	foreach($json_a[ads] as $p){
		$sql = "INSERT INTO client_ads (id, sex, area, time_of_day, day_of_week, client_id, cycles, image_name, metadata, phone_cycles, approved, approved_by, ad_name) VALUES ($p[id], '$p[sex]', '$p[area]', '$p[time_of_day]', '$p[day_of_week]', '$p[client_id]', $p[cycles], '$p[image_name]', '$p[metadata]', $p[phone_cycles], '$p[approved]', '$p[approved_by]', '$p[ad_name]')";
		mysql_query($sql) or die(mysql_error());
	}
?>
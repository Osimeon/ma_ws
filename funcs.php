<?php
class MainFuncs{
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "rbac";
    
    private $db = NULL;
    
    public function __construct(){
        $this->dbConnect();
    }
    
    //Database connection
    private function dbConnect(){
        $this->db = mysql_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD);
        if ($this->db) {
            mysql_select_db(self::DB, $this->db);
        }
    }
    
    function processReturnQuery($sql){
	  	$result = mysql_query($sql);
		if (!$result) {
			die("Error in SQL query: " . mysql_error());
		} 
		mysql_close($this->db);
	   	return $result;
	}
    
    function sanitize($input){
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->sanitize($val);
            }
        } 
		else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input  = $this->cleanInput($input);
            $input  = strip_tags($input);
            $output = mysql_escape_string($input);
        }
        return $output;
    }
    
    function cleanInput($input){
        
        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments
        );
        
        $output = preg_replace($search, '', $input);
        return $output;
    }
}
?>
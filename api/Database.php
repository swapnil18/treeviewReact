<?php
	ini_set('max_execution_time', 300);

	class Database
	{
		
		var $dbName = "treedb";
		var $dbUser = "root";
		var $dbPass = "";
		var $dbIP   = "localhost";		
		
		/* Live Database Connection End */
		
		function FetchRecords($query)
		{
			$queryResult = array();
			$dbCon =@mysqli_connect($this->dbIP,$this->dbUser,$this->dbPass,$this->dbName);
			if(!$dbCon)
			{
				die (
						'There is problem to connect database ... '.
						'<br> Contact your administrator.<br>'.
						'Error ::: '.mysqli_error()
					);
			}
			
			mysqli_select_db($dbCon,$this->dbName);
			$result = mysqli_query($dbCon,$query);
			$i=0;
			if($result != false)
			{
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
				{
					$queryResult[$i] = $row;
					$i++;
				}
			}
			mysqli_close($dbCon);
			return $queryResult;
		}

		function executeQuery($query)
		{
			$result = array();
			$dbCon =@mysqli_connect($this->dbIP,$this->dbUser,$this->dbPass);
			if(!$dbCon)
			{
				die (
						'There is problem to connect database ... '.
						'<br> Contact your administrator.<br>'.
						'Error ::: '.mysqli_error()
					);
			}
			mysqli_select_db($dbCon,$this->dbName);
			$result = mysqli_query($dbCon,$query);
			//mysqli_close($dbCon);
			return mysqli_insert_id($dbCon);
		}
	}
	
	$db = new Database();
?>

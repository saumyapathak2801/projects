<?php
include("constants.php");

class database {
	var $connection;
	var $tableName;
	var $fieldList;
	var $errors;
	var $res;	
	
	function database() {
		$this->tableName = 'tut_starRating';
		$this->connection = mysql_connect("127.0.0.1", "root", "") or die(mysql_error());
		mysql_select_db("radio", $this->connection) or die(mysql_error());
	}
	
	
    function dNumRows($sql = NULL )
    {
        if( $sql != NULL )
            $this->dQuery( $sql );
        return mysql_num_rows( $this->res );
    }
	
		
    function dQuery($sql) {
        $this->res = mysql_query( $sql, $this->connection );
		
    
        if( !$this->res) {
            die('<em>Error: the query you provided is a fine piece of horse cock</em>');
//			mysql_error();
		} else {
//			return $this->res;
		}
    }
	
    function dQueryAdmin($sql) {
        $this->res = mysql_query( $sql, $this->connection );
		
        if( !$this->res) {
            die('<em>Error: the query you provided is a fine piece of horse cock</em>');
		} else {
			return $this->res;
		}
    }	
	
	
/*	function dFetchArray($query) {
		return mysql_fetch_array($query, $this->connection);
	}	*/

    function dFetchArray($sql = NULL, $refetch = false ) {
        if ($sql != NULL) {
            $this->dQuery( $sql );
		}
            
        if( $refetch == true ) {
            mysql_data_seek( $this->res, 0 );    
		}
        
        while($row = mysql_fetch_array($this->res)) {
			$rows[] = $row;
		}
        
        return $rows;
    }	
	
	
	function dInsertRecord($fieldArray) {
		$fieldList = $this->fieldList;
		foreach($fieldArray as $field => $fieldValue) {
			if (!in_array($field, $fieldList)) {
				unset($fieldArray[$field]);
			}
		}
		$query = "INSERT INTO $this->tableName SET ";
		foreach($fieldArray as $item => $value) {
			$query .= "$item='$value', ";
		}
		$query = rtrim($query, ', ');
		$result = mysql_query($query, $this->connection) or die(mysql_error()); 
		if (mysql_errno() <> 0) {
			if (mysql_errno() == 1062) {
				$this->errors[] = "A record already exists with this ID.";
			} else {
				trigger_error("SQL", E_USER_ERROR);
			}
		}
	}
	
}
$db = new database;		
<?php
   class mysql{


     private $host;
     private $name;
     private $pass;
     private $table;
     private $ut;



     function __construct($host,$name,$pass,$table,$ut){
     	$this->host=$host;
     	$this->name=$name;
     	$this->pass=$pass;
     	$this->table=$table;
     	$this->ut=$ut;
     	$this->connect();

     }
     
     function __destruct()
     {
     	$this->close();
     }


     function connect(){
      $link=mysql_connect($this->host,$this->name,$this->pass) or die ($this->error());
      mysql_select_db($this->table,$link) or die("无法连接".$this->table);
      mysql_query("SET NAMES '$this->ut'");
     }

	function query($sql, $type = '') {
	    $query = mysql_query($sql);
	    return $query;
	}

    function show($message = '', $sql = '') {
		if(!$sql) echo $message;
		else echo $message.'<br>'.$sql;
	}

    function affected_rows() {
		return mysql_affected_rows();
	}

	function result($query, $row) {
		return mysql_result($query, $row);
	}

	function num_rows($query) {
		return @mysql_num_rows($query);
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return mysql_insert_id();
	}

	function fetch_row($query) {
		return mysql_fetch_row($query);
	}
	function fetch_array($query){
		return mysql_fetch_array($query);
	}

	function version() {
		return mysql_get_server_info();
	}

	function close() {
		return mysql_close();
	}


   //==============

    function insert($table,$name,$value){
    	return $this->query("insert into $table ($name) value ($value)");

    }
    function select($table, $field = "*", $where = "")
    {
    	if($where=="") {
    		return $this->query("select $field from $table");
    	}
		else {
    		return $this->query("select $field from $table where $where");
		}
	}
    function update($table,$value,$where="")
    {
    	if($where=="")
    		return $this->query("update $table set $value");
    	else
    		return $this->query("update $table set $value where $where");
    }
    
    
    function lockTable($table)
    {
    	return $this->query("LOCK TABLES $table WRITE");
    }
	
    function unlockTable()
    {
    	return $this->query("UNLOCK TABLES");
    }

   }


  $db =new mysql('localhost','root','','subscribe_lab',"utf8");



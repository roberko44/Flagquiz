<?php


class DbCrud{

    private $_database = null;
    private $_recordset = null;
    
    function __construct($db, $rs){

        $this->_database = $db;
        $this->_recordset = $rs;

    }

    //return an array with all records
     function getRecords($sql){
        $this->_recordset = $this->_database->query($sql); //SQL Anfrage
        if (!$this->_recordset) {
            printf("Query failed: %s\n", $this->_recordset->error);
            exit();
        }

        $record = array();
        
        while ($currRecord =  $this->_recordset->fetch_assoc()) {

            $record[] = $currRecord;

        }
        $this->_recordset->free();

        return $record;
    }







}
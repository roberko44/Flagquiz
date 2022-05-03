<?php

require_once 'Page.php';


class Scoreboard extends Page
{
    private $nutzer = array();

    protected function __construct()
    {
        parent::__construct();
    }


    protected function __destruct()
    {
        parent::__destruct();
    }


    protected function getViewData()
    {
        $sqlAnfrage = "select * from user;";
        $recordset = $this->_database->query($sqlAnfrage);
        if (!$recordset) {
            printf("Query failed.");
        }

        while ($record = $recordset->fetch_assoc()) {
            $tempArray = array(
                "UID" => $record["UID"],
                "NAME" => $record["NAME"],
                "PASSWORT" => $record["PASSWORT"],
                "PUNKTE" => $record["PUNKTE"]
            );
            $this->nutzer[] = $tempArray;
        }
    }


    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader('to do: change headline');

        echo <<<EOT
        <div id="headerDir">
        <span>Scoreboard </span>   
        </div>
        </div>
        <div id="content">
        <h1> Scoreboard </h1>

EOT;


        $this->generatePageFooter();
    }


    protected function processReceivedData()
    {
        parent::processReceivedData();
    }


    public static function main()
    {
        try {
            $page = new Scoreboard();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


Scoreboard::main();

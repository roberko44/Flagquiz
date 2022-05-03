<?php

require_once './Page.php';
include './controller/entity/Buch.php';


class Index extends Page
{

    private $laender = array();


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
        $this->_recordset = $this->_database->query("select * from land"); //SQL Anfrage
        if (!$this->_recordset) {
            printf("Query failed: %s\n", $this->_recordset->error);
            exit();
        }

        while ($Record = $this->_recordset->fetch_assoc()) {

            $tempArray = array(
                "LID" => $Record["LID"],
                "NAME" => htmlspecialchars($Record["NAME"]),
                "HAUPTSTADT" => htmlspecialchars($Record["HAUPTSTADT"]),
                "FLAGGE" => htmlspecialchars($Record["FLAGGE"]),
            );

            $this->laender[] = $tempArray;
        }
    }


    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader('to do: change headline');

        echo <<<EOT
        <!-- 
        <div id="headerDir">
        <span><b>Home</b></span>   
        </div>
        -->
        </div>

        <div id="content">
        <h1> Flaggenquiz </h1>
        <section class="buecher">
EOT;
        for ($i = 0; $i < 1; $i++) {
            $random = rand(0, count($this->laender) - 1);
            $flagge = $this->laender[$random]["FLAGGE"];
            $land = $this->laender[$random]["NAME"];
            $stadt = $this->laender[$random]["HAUPTSTADT"];
            echo <<<EOT
            <div>
            <img id="show_item" src="$flagge"><img>
            <p id="show_item"><b>Land: </b></br> $land </p>
            <p id="show_item"><b>Hauptstadt: </b></br> $stadt </p>
            
            <form action="?land=1" id="land" method="post">
        <input type="text"          name="land_name"         id="land"   placeholder="Land"/>
        <input type="hidden"        name="land_db"    value=$land />
        <input type ="submit"       id="senden"         value = "bestätigen" />
        </form>
            </div>

EOT;
        }

        echo <<<EOT
        </section>
        </div>
EOT;


        $this->generatePageFooter();
    }


    protected function processReceivedData()
    {
        parent::processReceivedData();


        if (isset($_GET["land"])) {
            if (isset($_POST["land_name"]) && isset($_POST["land_db"])) {
                $ayy = $_POST["land_name"];
                $ayyy = $_POST["land_db"];
                echo <<<EOT
                    <p>$ayy</p>
                    <p>$ayyy</p>
EOT;
                if ($_POST["land_name"] == $_POST["land_db"]) {
                    echo <<<EOT
                    <p>Richtig!</p>
EOT;
                }
            }
        }
    }

    public static function main()
    {
        try {
            $page = new Index();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Index::main();

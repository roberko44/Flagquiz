<?php

class Buch
{

    private $_database = null;
    private $_recordset;

    public $buchid;
    public $nutzerid;
    public $kategorieid;
    public $buchname;
    public $beschreibung;
    public $erscheinungsdatum;
    public $autor;
    public $bild;
    public $buchinhalt;
    public $unterkategorieid;

    public $kategorie;
    public $unterkategorie;

    function __construct($buch)
    {
        $this->buchid = htmlspecialchars($buch["BUCHID"]);
        $this->nutzerid = htmlspecialchars($buch["NUTZERID"]);
        $this->kategorieid = htmlspecialchars($buch["KATEGORIEID"]);
        $this->unterkategorieid  = htmlspecialchars($buch["UNTERKATEGORIEID"]);
        $this->buchname = htmlspecialchars($buch["BUCHNAME"]);
        $this->beschreibung = htmlspecialchars($buch["BESCHREIBUNG"]);
        $this->erscheinungsdatum = htmlspecialchars($buch["ERSCHEINUNGSDATUM"]);
        $this->autor = htmlspecialchars($buch["AUTOR"]);
        $this->bild = $buch["BILD"];
        $this->buchinhalt = $buch["BUCHINHALT"];

        $this->getKategory();
    }

    function getKategory()
    {
        $this->_database = new MySQLi("yoda.media.h-da.de", "pwws20_04", "KeLuGuGu%83", "pwws20db04");
        if ($this->_database == null || !$this->_database->connect_errno) {
            $this->_database->set_charset("utf8");
        }

        $sqlAnfrage = "select * from kategorie where KATEGORIEID = $this->kategorieid";
        $this->_recordset = $this->_database->query($sqlAnfrage);
        if (!$this->_recordset) {
            printf("Query failed.");
        }

        while ($record = $this->_recordset->fetch_assoc()) {
            $this->kategorie = $record["KATEGORIENAME"];
        }



        $sqlAnfrage = "select * from unterkategorie where UNTERKATEGORIEID = $this->unterkategorieid ";
        $this->_recordset = $this->_database->query($sqlAnfrage);
        if ($this->_recordset) {
            while ($record = $this->_recordset->fetch_assoc()) {
                $this->unterkategorie = $record["UNTERKATEGORIENAME"];
            }
        }
        if (!$this->unterkategorie) {
            $this->unterkategorie = "/";
        }
    }

    /*
    function showBuch2()
    {
        echo <<<EOT
            <section class="buch">

            <a href="$this->buchinhalt">
            <img class="show_itembook" src='$this->bild'/>
            </a>

            <p id="show_item"><b>Buchname: </b></br> $this->buchname</p>

            <p id="show_item"><b>Beschreibung: </b></br> $this->beschreibung</p>

            <p id="show_item"><b>Erscheinungsdatum: </b></br> $this->erscheinungsdatum</p>

            <p id="show_item"><b>Kategorie: </b></br> $this->kategorie</p>

            <p id="show_item"><b>Unterkategorie: </b></br> $this->unterkategorie</p>

            <p id="show_item"><b>Autor: </b></br> $this->autor</p>
            
            <a href="kommentar.php">
                <button  class="show_item">Kommentare zum Buch</button>
            </a>

            </section>
EOT;
    }*/


    function showBuch()
    {
        echo <<<EOT
        <form action="Kommentar.php" method="post">

        <section class="buch">
        <div class="buchImg">
        <a href="$this->buchinhalt">
        <img class="show_itembook" src='$this->bild'/>
        </a>
        </div>

        <p id="show_item"><b>Buchname: </b></br> $this->buchname</p>

        <p id="show_item"><b>Beschreibung: </b></br> $this->beschreibung</p>

        <p id="show_item"><b>Erscheinungsdatum: </b></br> $this->erscheinungsdatum</p>

        <p id="show_item"><b>Kategorie: </b></br> $this->kategorie</p>

        <p id="show_item"><b>Unterkategorie: </b></br> $this->unterkategorie</p>

        <p id="show_item"><b>Autor: </b></br> $this->autor</p>

        <input type="hidden" name = "buchid" value=$this->buchid>

        <button id="show_itemkommihome">Kommentare zum Buch</button>
           
        </form>

        </section>

EOT;
}



    function showUpload()
    {
        echo <<<EOT
            <section class="buch">
            <div class="buchImg">
            <a href="$this->buchinhalt">
            <img class="show_itembook" src='$this->bild'/>
            </a>
            </div>


            <p id="show_item"><b>Buchname: </b></br> $this->buchname</p>

            <p id="show_item"><b>Beschreibung: </b></br> $this->beschreibung</p>

            <p id="show_item"><b>Erscheinungsdatum: </b></br> $this->erscheinungsdatum</p>

            <p id="show_item"><b>Kategorie: </b></br> $this->kategorie</p>

            <p id="show_item"><b>Unterkategorie: </b></br> $this->unterkategorie</p>

            <p id="show_item"><b>Autor: </b></br> $this->autor</p>
            
            <div class="settings">
            <form action="Kommentar.php" method="post">
            <input type="hidden" name = "buchid" value=$this->buchid>
            <button id="show_itembutton" class="show_item" >Kommentare</button>
            </form>

            
            <form action="Bearbeiten.php" method="post">
            <input type="hidden" name = "buchid" value=$this->buchid>
            <button id="show_itembutton" class="show_item" >Bearbeiten</button>
            </form>

            <form action="Meine_uploads.php" method="post">
            <input type="hidden" name = "loeschenbuchid" value=$this->buchid>
            <button id="show_itembutton" class="show_item" >Löschen</button>
        <!--  <input type="submit"  class="show_item" value="Löschen" /> --!>
            </form>

            </div>
            </section>
EOT;
    }


    function showBearbeitungsBuch()
    {
        echo <<<EOT
        <form action="Kommentar.php" method="post">

       <section class="buch_edit">

        <p class="show_item_edit" ><b>Buchname: </b></br> $this->buchname</p>

        <p class ="show_item_edit"><b>Beschreibung: </b></br> $this->beschreibung</p>

        <p  class ="show_item_edit"><b>Erscheinungsdatum: </b></br> $this->erscheinungsdatum</p>

        <p class ="show_item_edit"><b>Kategorie: </b></br> $this->kategorie</p>

        <p class ="show_item_edit"><b>Unterkategorie: </b></br> $this->unterkategorie</p>

        <p class ="show_item_edit"><b>Autor: </b></br> $this->autor</p>

        <input type="hidden" name = "buchid" value=$this->buchid>
        
        </form>

        </section>

EOT;
}

    function showBearbeitungsBild()
    {
        echo <<<EOT
         <div class="buchImgBearbeitung">
         <a href="$this->buchinhalt">
         <img class="show_itembook" src='$this->bild'/>
         </a>
         </div>
EOT;
    }


}
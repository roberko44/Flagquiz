<?php

require_once 'Page.php';


class Login extends Page
{

    private $message = "";
    private $err = false;

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
    }


    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader('to do: change headline');

        echo <<<EOT
            <div id="headerDir">
            <span>Home > <b>Login</b></span>   
            </div>
            </div>
            <div id="content">
            <h1> Login </h1>
EOT;

        if (!isset($_SESSION["userid"])) {
            echo <<<EOT
        <form action="?login=1" id="login" method="post">
        <input type="text"          name="username"     id="username"   placeholder="Username"/>
        <input type="password"      name="passwort"     id="passwort"    placeholder="Passwort"/>
        <input type ="submit"       id="senden"         value = "Login" />
        </form>
EOT;
        }


        $class = $this->err ? 'errorclass' : 'rightclass';
        echo '<div class = ' . $class . '> ' . $this->message . ' </div>';

        echo <<<EOT
        
        </div>
EOT;

        $this->generatePageFooter();
    }


    protected function processReceivedData()
    {
        parent::processReceivedData();

        $error = true;

        if (isset($_GET["login"])) {
            if (isset($_POST["username"]) && isset($_POST["passwort"])) {

                if (($_POST["username"] == null) && ($_POST["passwort"] == null)) {
                    $this->message = "Username & Passwort eingeben.";
                    $this->err = true;
                    return;
                }

                if (($_POST["username"] == null)) {
                    $this->message = "Username eingeben.";
                    $this->err = true;
                }

                if (($_POST["passwort"] == null)) {
                    $this->message = "Passwort eingeben.";
                    $this->err = true;
                }

                $error = false;
            }
        }

        if (!$error) {
            $username = $_POST["username"];
            $passwort = $_POST["passwort"];

            $record = $this->sql->getRecords("select * from nutzer where nutzername='$username' and passwort='$passwort';");
            if ($record) {
                $_SESSION["userid"] = $record[0]["NUTZERID"];
                $_SESSION["username"] = $record[0]["NUTZERNAME"];
                $this->message = "Erfolgreich eingeloggt.";
                $this->err = false;
                // header("Location: Meine_uploads.php");
            } else {
                $this->message = "Username oder Passwort falsch.";
                $this->err = true;
            }
        }
    }


    public static function main()
    {
        try {
            $page = new Login();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Login::main();

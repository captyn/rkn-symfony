<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use \PDO;
$pg_schema = 'ms';
/**
 * @ORM\Entity(repositoryClass="App\Repository\OlimpRepository")
 */
class Olimp
{


    public function dbConnect() {
        //  global $dbh;

        $dbInfo['database_target'] = "10.0.1.5";
        $dbInfo['database_port'] = '5432';
        $dbInfo['database_name'] = "ew3";
        $dbInfo['username'] = "konik";
        $dbInfo['password'] = "AMartynowicz2018";

        $dbConnString = "pgsql:host=" . $dbInfo['database_target'] . "; port=" . $dbInfo['database_port']. "; dbname=" . $dbInfo['database_name'];
        $this->dbh = new PDO($dbConnString, $dbInfo['username'], $dbInfo['password']);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $error = $this->dbh->errorInfo();
        if($error[1] != "") {
            print "<p>DATABASE CONNECTION ERROR:</p>";
            //      print_r($error);
            die();
        }
    }

    private $dbh,
        $FETCH = array('a' => PDO::FETCH_ASSOC, 'n' => PDO::FETCH_NUM);

    function Q($sql,$type='a'){
        $sth = $this->dbh->prepare($sql);
        $error = $this->dbh->errorInfo();
        $sth->execute();
        $query = $sth->fetchAll($this->FETCH[$type]);
        return $query;
    }

    function Q1($sql,$type='a'){
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $query = $sth->fetch($this->FETCH[$type]);
        return $query;
    }

    function Qv($sql){
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $query = $sth->fetch(PDO::FETCH_NUM);
        return $query[0];
    }
}

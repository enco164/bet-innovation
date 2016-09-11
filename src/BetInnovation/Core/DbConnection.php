<?php
/**
 * Created by PhpStorm.
 * User: milan
 * Date: 11.9.16.
 * Time: 12.30
 */

namespace BetInnovation\Core;

use PDO;
use PDOException;

class DbConnection
{
    public function __construct()
    {
    }

    public function getConnection()
    {
        $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_SESSION['username'].";password=".$_SESSION['password'];
        try {
            $connection = new PDO($dsn);
            if ($connection) {

                $connection->prepare("SET TIME ZONE 'Europe/Skopje'")->execute();
                $connection->prepare("SET DATESTYLE TO ISO")->execute();

                return $connection;
            }
            else
                return false;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
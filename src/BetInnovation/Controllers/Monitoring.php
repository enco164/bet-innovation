<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.43
 */

namespace BetInnovation\Controllers;

use BetInnovation\Core\Controller;
use BetInnovation\Views\Monitoring\Stanja;
use BetInnovation\Views\Monitoring\StanjaPoDanima;
use BetInnovation\Views\Monitoring\StanjaPoMesecima;
use BetInnovation\Views\Monitoring\UplateIsplate;
use PDO;
use PDOException;

class Monitoring extends Controller
{
    public function index()
    {
        header('Locaton: /');
        die();
    }

    public function uniqueNamesArray($query) {
        $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_SESSION['username'].";password=".$_SESSION['password'];
        try {
            $connection = new PDO($dsn);
            if($connection) {
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $uniqueNames = [];

                $cnt_columns = $stmt->rowCount();
                for($i = 0; $i < $cnt_columns; $i++) {
                    $data = $stmt->fetch();
                    $uniqueNames[]=[$data['serial_number'], $data['display_name']];
                }
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        $uniqueNames = array_unique($uniqueNames, SORT_REGULAR);

        usort($uniqueNames, function($a, $b) {
            return strcasecmp($a[1], $b[1]);
        });
        return $uniqueNames;
    }


    public function prepareHeaders($stmt) {
        $headers = [];

        $cnt_columns = $stmt->columnCount();
        for($i = 0; $i < $cnt_columns; $i++) {
            $metadata = $stmt->getColumnMeta($i);
            $headers[]=['native_type'=>$metadata['native_type'], 'name'=>$metadata['name']];
        }

        return $headers;
    }

    public function executeForAllTerminals($query) {
        $data = [];
        for ($i=2; $i<=8; $i++) {
            $stmt = $this->executeQuery($query, 2);
            $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array_merge_recursive($data, $tmp);
        }
        return $data;
    }

    public function executeQuery($query, $allTerminals) {
        $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_SESSION['username'].";password=".$_SESSION['password'];
        try {
            $connection = new PDO($dsn);
            if($connection) {
                $stmt = $connection->prepare($query);

                if(isset($_POST['serialNum']) && strlen($_POST['serialNum']) > 0)
                    $stmt->bindValue(':serialNum', $_POST['serialNum']);
                else
                    $stmt->bindValue(':serialNum', null);

                if(isset($_POST['terminal']) && strlen($_POST['terminal']) > 0 && $allTerminals == false)
                    $stmt->bindValue(':terminal', intval($_POST['terminal']));
                else if($allTerminals == false)
                    $stmt->bindValue(':terminal', null);
                else
                    $stmt->bindValue(':terminal', $allTerminals);

                if(isset($_POST['datetimeFromDate']) && strlen($_POST['datetimeFromDate']) > 0 && isset($_POST['datetimeFromTime']) && strlen($_POST['datetimeFromTime']) > 0)
                    $stmt->bindValue(':datetimeFrom', $_POST['datetimeFromDate'] . ' ' . $_POST['datetimeFromTime']);
                else if(isset($_POST['datetimeFromDate']) && strlen($_POST['datetimeFromDate']) > 0)
                    $stmt->bindValue(':datetimeFrom', $_POST['datetimeFromDate']);
                else
                    $stmt->bindValue(':datetimeFrom', null);

                if(isset($_POST['datetimeToDate']) && strlen($_POST['datetimeToDate']) > 0 && isset($_POST['datetimeToTime']) && strlen($_POST['datetimeToTime']) > 0)
                    $stmt->bindValue(':datetimeTo', $_POST['datetimeToDate'] . ' ' . $_POST['datetimeToTime']);
                else if(isset($_POST['datetimeToDate']) && strlen($_POST['datetimeToDate']) > 0)
                    $stmt->bindValue(':datetimeTo', $_POST['datetimeToDate']);
                else
                    $stmt->bindValue(':datetimeTo', null);

                $stmt->execute();

                return $stmt;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function uplateIsplate()
    {
        $query = "select * from monitoring.get_accounting_pay_in_out(:serialNum, :terminal, :datetimeFrom, :datetimeTo)";
        $stmt = $this->executeQuery($query);
        $headers = $this->prepareHeaders($stmt);

        $queryPom = "select * from monitoring.get_accounting_pay_in_out(null, null, null, null)";
        $uniqueNames = $this->uniqueNamesArray($queryPom);

        $this->model = [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'headers' => $headers,
            'uniqueNames' => $uniqueNames
        ];
        (new UplateIsplate())->render($this->model);
    }

    public function stanja()
    {
        $query = "select * from monitoring.get_accounting_totals(:serialNum, :terminal, :datetimeFrom, :datetimeTo)";
        $stmt = $this->executeQuery($query);
        $headers = $this->prepareHeaders($stmt);

        $queryPom = "select * from monitoring.get_accounting_totals(null, null, null, null)";
        $uniqueNames = $this->uniqueNamesArray($queryPom);

        $this->model = [
            'data'=>$stmt->fetchAll(PDO::FETCH_ASSOC),
            'headers'=>$headers,
            'uniqueNames' => $uniqueNames
        ];
        (new Stanja())->render($this->model);
    }

    public function stanjaPoDanima()
    {

        $query = "select * from monitoring.get_accounting_totals_by_day(:serialNum, :terminal, :datetimeFrom, :datetimeTo)";
        $stmt = $this->executeQuery($query);
        $headers = $this->prepareHeaders($stmt);

        $queryPom = "select * from monitoring.get_accounting_totals_by_day(null, null, null, null)";
        $uniqueNames = $this->uniqueNamesArray($queryPom);

        $this->model = [
            'data'=>$stmt->fetchAll(PDO::FETCH_ASSOC),
            'headers'=>$headers,
            'uniqueNames' => $uniqueNames
        ];
        (new StanjaPoDanima())->render($this->model);
    }

    public function stanjaPoMesecima()
    {
        $query = "select * from monitoring.get_accounting_totals_by_month(:serialNum, :terminal, :datetimeFrom, :datetimeTo)";

        if((!isset($_POST['terminal'])) || (intval($_POST['terminal']) != -1)) {
            $stmt = $this->executeQuery($query, false);
            $headers = $this->prepareHeaders($stmt);

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            $stmt = $this->executeQuery($query, 1);
            $headers = $this->prepareHeaders($stmt);

            $dataForFirst = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dataForRest = $this->executeForAllTerminals($query);

            $data = array_merge_recursive($dataForFirst, $dataForRest);
        }

        $queryPom = "select * from monitoring.get_accounting_totals_by_month(null, null, null, null)";
        $uniqueNames = $this->uniqueNamesArray($queryPom);

        $this->model = [
            'data'=>$data,
            'headers'=>$headers,
            'uniqueNames' => $uniqueNames
        ];
        (new StanjaPoMesecima())->render($this->model);
    }
}
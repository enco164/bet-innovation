<?php
namespace BetInnovation\Controllers;

use BetInnovation\Core\Controller;
use BetInnovation\Views\Home\Index;
use PDO;
use PDOException;

class Home extends Controller{

    private $view;
    public $model;

    /**
     * Home constructor.
     */
    public function __construct()
    {
        $this->view = new Index();

        $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_SESSION['username'].";password=".$_SESSION['password'];
        try {
            $connection = new PDO($dsn);
            if($connection) {
                $query = "select * from monitoring.get_user_registrations()";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $headers = [];

                $data = [];
                $cnt_rows = $stmt->rowCount();
                for($i = 0; $i < $cnt_rows; $i++) {
                    $tmpData = $stmt->fetch();
                    $data[]=['serialNum' => $tmpData['serial_number'], 'display_name' => $tmpData['display_name']];
                }

                $cnt_columns = $stmt->columnCount();
                for($i = 0; $i < $cnt_columns; $i++) {
                    $metadata = $stmt->getColumnMeta($i);
                    if($metadata['name'] == 'serial_number' || $metadata['name'] == 'display_name')
                        $headers[]=['native_type'=>$metadata['native_type'], 'name'=>$metadata['name']];
                }

                $this->model = [
                    'navActiveLink'=>'HOME',
                    'data'=>$data,
                    'headers'=>$headers
                ];
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function index(){
        $this->view->render($this->model);
    }

    public function getByMonth(){
        $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_SESSION['username'].";password=".$_SESSION['password'];
        try {
            $connection = new PDO($dsn);
            if($connection) {
                $query = "select * from monitoring.get_chart_totals_by_month(:serial_num, null, :period_start, :period_end)";
                $stmt = $connection->prepare($query);

                if(isset($_POST['serialNum']) && strlen($_POST['serialNum']) > 0)
                    $stmt->bindValue(':serial_num', $_POST['serialNum']);
                else {
                    echo "[]";
                    return;
                }
                if(isset($_POST['periodStart']) && strlen($_POST['periodStart']) > 0)
                    $stmt->bindValue(':period_start', $_POST['periodStart']);
                else {
                    $tmp = strtotime(date("Y-m-d"));
                    $stmt->bindValue(':period_start', date("Y-m-d",strtotime('-1 year',$tmp)));
                }

                if(isset($_POST['periodEnd']) && strlen($_POST['periodEnd']) > 0)
                    $stmt->bindValue(':period_end', $_POST['periodEnd']);
                else
                    $stmt->bindValue(':period_end', date("Y-m-d"));

                $stmt->execute();

                echo json_encode($stmt->fetchAll());
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByDay(){

        $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_SESSION['username'].";password=".$_SESSION['password'];
        try {
            $connection = new PDO($dsn);
            if($connection) {
                $query = "select * from monitoring.get_chart_totals_by_day(:serial_num, null, :period_start, :period_end)";
                $stmt = $connection->prepare($query);

                if(isset($_POST['serialNum']) && strlen($_POST['serialNum']) > 0)
                    $stmt->bindValue(':serial_num', $_POST['serialNum']);
                else {
                    echo "[]";
                    return;
                }

                if(isset($_POST['periodStart']) && strlen($_POST['periodStart']) > 0)
                    $stmt->bindValue(':period_start', $_POST['periodStart']);
                else {
                    $tmp = strtotime(date("Y-m-d"));
                    $stmt->bindValue(':period_start', date("Y-m-d",strtotime('-14 days',$tmp)));
                }

                if(isset($_POST['periodEnd']) && strlen($_POST['periodEnd']) > 0)
                    $stmt->bindValue(':period_end', $_POST['periodEnd']);
                else
                    $stmt->bindValue(':period_end', date("Y-m-d"));

                $stmt->execute();

                echo json_encode($stmt->fetchAll());
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function test(){
        echo "Home Test controller";
    }

}
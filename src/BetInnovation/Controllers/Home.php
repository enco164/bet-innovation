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
                $query = "select * from monitoring.get_accounting_totals(null, null, null, null)";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $headers = [];

                $cnt_columns = $stmt->columnCount();
                for($i = 0; $i < $cnt_columns; $i++) {
                    $metadata = $stmt->getColumnMeta($i);
                    $headers[]=['native_type'=>$metadata['native_type'], 'name'=>$metadata['name']];
                }
//        var_dump($headers);
                $this->model = [
                    'navActiveLink'=>'HOME',
                    'data'=>$stmt->fetchAll(PDO::FETCH_ASSOC),
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

    public function test(){
        echo "Home Test controller";
    }

}
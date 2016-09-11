<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 20.12
 */

namespace BetInnovation\Controllers;

use BetInnovation\Core\Controller;
use BetInnovation\Views\Login\Index;
use PDOException;

class Login extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new Index();
    }


    public function index()
    {

        $this->view->render(['notAuth' => true, 'body-background' => true]);
    }

    public function login()
    {

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $dsn = "pgsql:host=localhost;dbname=bet-innovation;user=".$_POST['username'].";password=".$_POST['password'];
            try {
                $connection = new \PDO($dsn);
                if($connection) {
                    session_start();
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['password'] = $_POST['password'];
                    header('Location: /');
                    die();
                }
            }
            catch (PDOException $e) {
                header('Location: /Login');
                die();
            }


        } else {
//            header('Location: /Login');
//            die();
        }
    }

    public function logout()
    {
        $this->forceDestroySession();
        header('Location: /');
        die();
    }

    private function forceDestroySession()
    {

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }
}
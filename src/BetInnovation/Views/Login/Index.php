<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 24.7.16.
 * Time: 22.31
 */

namespace BetInnovation\Views\Login;


use BetInnovation\Views\View;

class Index extends View
{

    public function render($viewBag)
    {
        $this->viewBag = $viewBag;
        $this->head();
        $this->header($viewBag);

        echo "<div class='container'>
    <div class='row'>
        <form action='/Login/login' method='post' class='col-md-4 col-md-push-4 login-form'>
            <div class='form-group'>
                <label for='username'>Username</label>
                <input type='text' name='username' class='form-control' id='username'>
            </div>
            <div class='form-group'>
                <label for='password'>Password</label>
                <input type='password' name=\"password\" class='form-control' id='password'>
            </div>
            <div class='form-group' style='text-align: right'>
                <input type='submit' class='btn btn-primary' value='Uloguj se'>
            </div>
        </form>

    </div>
</div>
";

        $this->footer();
    }
}
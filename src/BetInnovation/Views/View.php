<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 24.7.16.
 * Time: 22.25
 */

namespace BetInnovation\Views;


abstract class View
{
    abstract public function render($viewBag);

    public function head()
    {
        ?>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>BetInnovation</title>

            <link rel='stylesheet' href="/content/styles/style.css">
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="content/js/jquery-3.1.0.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="/content/js/bootstrap.min.js"></script>
            <script src="/content/js/Chart.js"></script>
        </head>
        <body>
    <?php
    }

    public function header($viewBag)
    {
        ?>
        <header></header>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Happy Bet</a>
                </div>

                <?php if (!isset($viewBag['notAuth'])) { ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li
                            <?php if ($viewBag['navActiveLink'] == 'HOME') { ?>
                                class='active'
                            <?php } ?>
                        ><a href="/">Home</a></li>


                        <li
                            <?php if ($viewBag['navActiveLink'] == 'UPLATE_ISPLATE') { ?>
                                class='active'
                            <?php } ?>
                        ><a href="/Monitoring/uplateIsplate">Uplate i isplate</a></li>


                        <li
                            <?php if ($viewBag['navActiveLink'] == 'STANJA') { ?>
                                class='active'
                            <?php } ?>
                        ><a href="/Monitoring/stanja">Stanja</a></li>


                        <li
                            <?php if ($viewBag['navActiveLink'] == 'STANJA_PO_DANIMA') { ?>
                                class='active'
                            <?php } ?>
                        ><a href="/Monitoring/stanjaPoDanima">Stanja po danima</a></li>


                        <li
                            <?php if ($viewBag['navActiveLink'] == 'STANJA_PO_MESECIMA') { ?>
                                class='active'
                            <?php } ?>
                        ><a href="/Monitoring/stanjaPoMesecima">Stanja po mesecima</a></li>

                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/Login/logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                <?php
                }
                ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?php
    }

    public function footer()
    {
        ?>
        </body>
        </html>
    <?php
    }
}
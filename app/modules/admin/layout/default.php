<?php

    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Microframework com Bootstrap</title>
        <link href="<?php echo APP_URL; ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo APP_URL; ?>css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="#" class="brand">Admin Area</a>
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">Logged
                            <a href="" class="navbar-link">click here</a>
                        </p>
                        <ul class="nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">Localização</a></li>
                            <li><a href="#">Contato</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row-fluid">
                
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <li class="nav-header">Teste 1</li>
                            <li>Teste 2</li>
                            <li>Teste 3</li>
                        </ul>
                    </div>
                </div>
                
                <div class="span9">
                    <div class="hero-unit">
                        <h1>Primeiro framework ibrido</h1>
                        <p>Umas das coisas mais bacanas que existem(bootstrap + mvc + doctrine)</p>
                        <a href="" class="btn btn-large btn-primary">Click here</a>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h2>Titulo 1</h2>
                            <p>Teste descritivo do titulo 1</p>
                            <a href="" class="btn">Click here</a>
                        </div>
                    </div>
                </div>
                
            </div>
            
            
        </div>
        <script src="<?php echo APP_URL; ?>js/bootstrap.min.js"></script>
    </body>
</html>
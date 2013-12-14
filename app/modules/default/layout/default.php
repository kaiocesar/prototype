<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo APP_TITLE ." - ". $objController->title_page;  ?></title>

    </head>
    <body>

        <header>    </header>

        <div id="wrapper-center">
            
            <aside>
                <?php include($content_layout); ?>
            </aside>

            <section>
                <?php include($content_layout); ?>            
            </section>
            
        </div>


        <footer>
            <?php include($content_layout); ?>
        </footer>






    

        
    </body>
</html>
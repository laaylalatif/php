<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'Banco.php';
        
        $p1 = new banco(); 
        $p2 = new banco(); 
        $p1->abrirConta("CC");
        $p1->setDono("Jubileu");
        ?>
    </body>
</html>

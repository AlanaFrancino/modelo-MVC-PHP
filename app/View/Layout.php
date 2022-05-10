<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Webdesign em Foco">
    <meta name="description" content="<?php echo $this->getDescription(); ?>">
    <meta name="keywords" content="<?php echo $this->getKeywords(); ?>">
    <title><?php echo $this->getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo DIRCSS.'Style.css' ?>">
    <?php echo $this->addHead(); ?>
</head>

<body>
    <div class="Nav">
        <a href="<?php echo DIRPAGE; ?>">Home</a>
        <a href="<?php echo DIRPAGE.'contato'; ?>">Contato</a>
        <a href="<?php echo DIRPAGE.'cadastro'; ?>">Cadastro</a>
        <a href="<?php echo DIRPAGE.'login'; ?>">Login</a>
    </div>
    
    <div class="Header">
       
        <img src="<?php echo DIRIMG.'banner.jpg'; ?>" alt="Banner"><br>
        <?php
            $BreadCrumb = new Src\Classes\ClassBreadcrumb();
            $BreadCrumb->addBreadcrumb();
        ?>
        <br><br><hr>
        TEL.: (XX) XXXXXXXX <br>
        <?php echo $this->addHeader(); ?>
    </div>
    
    <div class="Main">
        <?php echo $this->addMain(); ?>
    </div>
    
    <div class="Footer">
        2022 - TODOS OS DIREITOS RESERVADOS Alana Francino <br>
        <?php echo $this->addFooter(); ?>
    </div>
</body>

</html>
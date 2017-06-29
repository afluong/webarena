<!-- Charte graphique -->
<!DOCTYPE html>
<html lang="fr">

    <!-- Header -->
    <head>
        <!-- Déclaration de l'encodage -->
        <?php echo $this->Html->charset(); ?>

        <!-- Appel de CSS et JS -->
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('js'); ?>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <?php echo $this->Html->meta('icon', 'favicon.ico'); ?>

        
        <title>TP2 Web | Web Arena</title>

        <!-- Bootstrap Core CSS & Custom CSS -->
        <?php echo $this->Html->css(array('bootstrap', 'grayscale', 'font-awesome', 'custom')); ?>

        <!-- Custom Fonts -->
        <?php echo $this->Html->css('http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic'); ?>
        <?php echo $this->Html->css('http://fonts.googleapis.com/css?family=Montserrat:400,700'); ?>
    </head>

    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <!-- Affichage contenu .ctp -->
        <?php echo $this->fetch('content'); ?>

       

        <!-- jQuery -->
        <?php echo $this->Html->script('jquery'); ?>

        <!-- Bootstrap Core JavaScript -->
        <?php echo $this->Html->script('bootstrap.min'); ?>

        <!-- Plugin JavaScript -->
        <?php echo $this->Html->script('jquery.easing.min'); ?>

        <!-- Grayscale Custom Javascript -->
        <?php echo $this->Html->script('grayscale'); ?>

    </body>
</html>
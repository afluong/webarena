<!DOCTYPE html>
<html lang="fr">
<!-- Vue index.ctp -->
<!-- Controller Arenas, action index() -->

	<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	    <!-- Navigation -->
	    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
	        <div class="container">
	            <div class="navbar-header">
	            <a class="navbar-brand page-scroll" href="#page-top">
	            <?php echo $this->Html->image('warrior.png', array(
	            	'style' => 'height: 25px',
	                'alt' => '')); ?>
	            </a>
	            </div>

	            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
	                <ul class="nav navbar-nav">
	                    <li class="hidden">
	                        <a href="#page-top"></a>
	                    </li>
	                    <li>
	                        <a class="page-scroll" href="#aventure">L'aventure</a>
	                    </li>
	                    <li>
	                        <a class="page-scroll" href="#rules">Règles du jeu</a>
	                    </li>
	                    <li>
	                        <a class="page-scroll" href="#connexion">Connexion</a>
	                    </li>
	                    <li>
	                        <a class="page-scroll" href="#contact">Contact</a>
	                    </li>
	                </ul>
	            </div>
	            <!-- /.navbar-collapse -->
	        </div>
	        <!-- /.container -->
	    </nav>

	    <!-- Intro Header -->
	    <header class="intro">
	        <div class="intro-body">
	            <div class="container">
	                <div class="row">
	                    <div class="col-md-8 col-md-offset-2">
	                        <h1 class="brand-heading">Web Arena</h1>
	                        <a href="#aventure" class="btn btn-circle page-scroll">
	                            <i class="fa fa-angle-double-down animated"></i>
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </header>

	    <!-- Section L'Aventure -->
	    <section id="aventure" class="container content-section text-center">
	        <div class="row">
	            <div class="col-lg-12">
	                <h2>L'aventure</h2>
	                    <div class="col-lg-6 text-justify">
	                	   <p>Après l’une des plus grandes catastrophes de notre terre plongeant l’humanité dans le désespoir complet, il ne restait plus rien sinon une parcelle d’espoir. Incarnant cet espoir, l’Arena permet aux survivants d’assurer leur protection et d'évoluer dans cette nouvelle société. </p>
	                    </div>
	                    <div class="col-lg-6 text-justify">
	                	   <p>L’indépendance au prix du sang c’est ce que les partisans de cette arène revendiquent.
	                            Venez obtenir par force, adresse, courage et ingéniosité une renommée espérée par tout combattant. </p>
	                    </div>
	            </div>
	        </div>
	    </section>

	    <!-- Section Règles du jeu -->
	    <section id="rules" class="content-section text-center">
	        <div class="connection-section">
	            <div class="container">
	                <div class="col-lg-12">
	                    <h2>Règles du jeu</h2>
	                    <div class="col-lg-6 text-justify">
	                        <p>Votre combattant démarrera avec des caractéristiques de vue, de force et de vie ainsi qu’un placement dans l’arène aléatoire.<br/>
	                        Pour commencer à attaquer les autres joueurs, il faut choisir une direction puis un nombre aléatoire entre 1 et 20 vous sera attribué.</p>
	                    </div>

	                    <div class="col-lg-6 text-justify">
	                        <p>Une attaque est considérée comme réussie si ce nombre est supérieur à (10 + le niveau de l'adversaire - votre niveau).
	                        Tous les 4 points d’expériences, le combattant augmente de niveau et peut choisir d'améliorer une de ses caractéristiques.</p>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </section>

	    <!-- Section Connexion -->
	    <section id="connexion" class="content-section text-center">
	    	<div class="connection-section">
			    <div class="container">
			        <div class="col-lg-12">
			            <h2>Connexion</h2>
			            <p>Êtes-vous prêt à combattre ?</p>
			            <?php echo $this->Html->link("Rejoindre l'arène", array(
			            	'controller' => 'players',
			            	'action' => 'login'),
			            	array(
			            	'class' => 'btn-default btn btn-lg')); ?>
			        </div>
			    </div>
		    </div>
	    </section>

	    <!-- Section Contact -->
	    <section id="contact" class="container content-section text-center">
		    <div class="download-section">
		        <div class="container">
		            <div class="col-lg-12">
		                <h2>Contact</h2>
		                <p>Site réalisé en CakePHP dans le cadre d'un projet WEB de 2ème année du cycle ingénieur à l'<span class="light"><?php echo $this->Html->link("ECE PARIS", 'http://www.ece.fr',
		                array('target' => '_blank')); ?></span> par </p>
		                </p>
		                <ul class="img-list">
		                	<li>
		                		<a href="https://fr.linkedin.com/in/afluong" target="_blank">
		                			<?php echo $this->Html->image('luong.jpg', array(
		                			'style' => 'width:170px;')); ?>
		                			<span class='text-content'><span>Anne Florence LUONG</span></span>
		                		</a>
		                	</li>
		                    <li>
			                    <a href="https://fr.linkedin.com/in/sgalliani" target="_blank">
			                    	<?php echo $this->Html->image('galliani.jpg', array(
			                    	'style' => 'width:170px;')); ?>
			                    	<span class='text-content'><span>Stefano GALLIANI</span></span>
			                    </a>
		                    </li>
		                    <li>
			                    <a href="https://fr.linkedin.com/in/julien-ferry-938b788a" target="_blank">
			                    	<?php echo $this->Html->image('ferry.jpg', array(
			                    	'style' => 'width:170px;')); ?>
			                    	<span class='text-content'><span>Julien FERRY</span></span>
			                    </a>
		                    </li>
		                    <li>
			                    <a href="https://fr.linkedin.com/in/sebastiengladieux" target="_blank">
			                    	<?php echo $this->Html->image('gladieux.jpg', array(
			                    	'style' => 'width:170px;')); ?>
			                    	<span class='text-content'><span>Sébastien GLADIEUX</span></span>
			                    </a>
		                    </li>
		                </ul>
		            </div>
		        </div>
	        </div>
	    </section>

	    <?php echo $this->element('footer'); ?>
	    </body>

</html>
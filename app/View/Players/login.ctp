<html>
<!-- Vue login.ctp -->
<!-- Controller Players, action login() -->

	<body class="background">
		<head>
			<title>Page login</title>
		</head>

		<?php echo $this->element('navbarBeforeLogin'); ?>

		<section class="content-section">
			<div class="row">
				<div class="col-lg-offset-3 col-lg-6 border">
					<h2>Connexion</h2>
					<!-- Création du formulaire de connexion -->
					<?php echo $this->Form->create('Player'); ?>
					<div class="form-group">
						<!-- Champs input -->
						<?php if(!empty($msg))
						{
							echo $msg;
						}
						?>
						<?php echo $this->Form->input('email', array(
							'label' => false,
							'placeholder' => "Email",
							'class' => 'form-control input-lg'
							)); ?>
					</div>
					<div class="form-group">
						<!-- Champs input -->
						<?php echo $this->Form->input('password', array(
							'label' => false,
							'placeholder' => "Mot de passe",
							'class' => 'form-control input-lg'
							)); ?>
						<?php $options = array(
							'label' => "Se connecter",
							'class' => 'btn-default btn btn-lg'); ?>
					</div>

					<!-- Fermeture du formulaire par un bouton Connexion -->
					<?php echo $this->Form->end($options); ?>
					<div class="col-lg-offset-2 col-lg-10 text-right">
						<!-- Lien vers l'action recover() du controller Players -->
						<?php echo $this->Html->link("Mot de passe oublié", array(
							'controller' => 'players',
							'action' => 'recover'
							)
							); ?> <br/>

						<!-- Lien vers l'action register() du controller Players -->
						<?php echo $this->Html->link("S'enregistrer", array(
							'controller' => 'players',
							'action' => 'register'
							)
							); ?>
					</div>
				</div>
			</div>
		</section>

		<?php echo $this->element('footer'); ?>
	</body>

</html>



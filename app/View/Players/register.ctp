<html>
<!-- Vue register.ctp -->
<!-- Controller Players, action register() -->

	<body class="background">
		<head>
			<title></title>
		</head>

		<?php echo $this->element('navbarBeforeLogin'); ?>

		<section class="content-section">
			<div class="row">
				<div class="col-lg-offset-3 col-lg-6 border">
					<h2>Inscription</h2>
					<!-- Création du formulaire de connexion -->
					<?php echo $this->Form->create('Player'); ?>
					<div class="form-group">
						<!-- Champs input -->
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
					</div>
					<div class="form-group">
						<?php echo $this->Form->input('password_r', array(
							'label' => false,
							'type' => 'password',
							'placeholder' => "Répétez mot de passe",
							'class' => 'form-control input-lg'
							)); ?>

						<?php if(!empty($message))
						{
							echo $message;
						}
						?>
						<?php $options = array(
							'label' => "S'inscrire",
							'class' => 'btn-default btn btn-lg'); ?>
					</div>

					<!-- Fermeture du formulaire par un bouton Connexion -->
					<?php echo $this->Form->end($options); ?>
				</div>
			</div>
		</section>

		<?php echo $this->element('footer'); ?>
	</body>

</html>
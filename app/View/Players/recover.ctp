<!DOCTYPE html>
<html lang="fr">
<!-- Vue recover.ctp -->
<!-- Controller Players, action recover() -->
	<body class="background">


		<?php echo $this->element('navbarBeforeLogin'); ?>

		<section class="content-section">
			<div class="row">
				<div class="col-lg-offset-3 col-lg-6 border">
					<h2>Mot de passe oublié</h2>
					<!-- Création du formulaire de récupération de mot de passe -->
					<?php echo $this->Form->create('Player'); ?>
					<div class="form-group">
					<?php if(!empty($msg))
					{
						echo $msg;
					}
					?>
						<!-- Champs input -->
						<?php echo $this->Form->input('email', array(
							'label' => false,
							'placeholder' => "Votre adresse email",
							'class' => 'form-control input-lg'
							)); ?>
					</div>

						<?php $options = array(
							'label' => "Envoyer",
							'class' => 'btn-default btn btn-lg'); ?>

					<!-- Fermeture du formulaire par un bouton Connexion -->
					<?php echo $this->Form->end($options); ?>

				</div>
			</div>
		</section>

		<?php echo $this->element('footer'); ?>
	</body>
</html>
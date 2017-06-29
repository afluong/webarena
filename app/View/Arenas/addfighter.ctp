<!DOCTYPE html>
<html lang="fr">
<!-- Vue addfighter.ctp -->
<!-- Controller Arenas, action addfighter() -->
	<body class="background">


		<?php echo $this->element('navbarAfterLogin'); ?>

		<section class="content-section">
			<div class="row">
				<div class="col-lg-offset-3 col-lg-6 border">
					<h2>Création d'un combattant</h2>
					<!-- Création du formulaire de connexion -->
					<?php echo $this->Form->create('Fighter'); ?>
					<div class="form-group">
						<!-- Champs input -->
						<?php echo $this->Form->input('name', array(
							'label' => false,
							'placeholder' => "Nom du combattant",
							'class' => 'form-control input-lg'
							)); ?>
					</div>

						<?php $options = array(
							'label' => "Créer",
							'class' => 'btn-default btn btn-lg'); ?>

					<!-- Fermeture du formulaire par un bouton Connexion -->
					<?php echo $this->Form->end($options); ?>

				</div>
			</div>
		</section>

		<?php echo $this->element('footer'); ?>
	</body>
</html>
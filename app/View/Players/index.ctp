<html>

	<body>

		<!-- Appel d'un élément -->
		<?php echo $this->element('navbarBeforeLogin'); ?>

		<div class="content content-form content-sight">
			<h2>Informations du compte</h2>
			<h5 id="infos">Votre email : <?php echo $email; ?></h5>

			Modifier votre mot de passe
			<!-- Création du formulaire de modification du mot de passe -->
			<?php echo $this->Form->create('Player'); ?>
			<div class="form-group">
				<?php if(!empty($error_3))
				{
					echo $error_3;
				}
				?>
				<!-- Champs input -->
				<?php echo $this->Form->input('current_password', array(
					'type' => 'password',
					'label' => false,
					'placeholder' => "Mot de passe actuel",
					'class' => 'form-control',
					'style' => 'width:300px;'
					)
				); ?>
			</div>
			<div class="form-group">
				<?php if(!empty($error_2))
				{
					echo $error_2;
				}
				?>
				<!-- Champs input -->
				<?php echo $this->Form->input('new_password', array(
					'type' => 'password',
					'label' => false,
					'placeholder' => "Nouveau mot de passe",
					'class' => 'form-control',
					'style' => 'width:300px;'
					)
				); ?>
			</div>
			<div class="form-group">
				<!-- Champs input -->
				<?php echo $this->Form->input('new_passwordr', array(
					'type' => 'password',
					'label' => false,
					'placeholder' => "Répétez nouveau mot de passe",
					'class' => 'form-control',
					'style' => 'width:300px;'
					)
				); ?>
			<?php if(!empty($error_1))
			{
				echo $error_1;
			}
			?>
			</div>

			<?php $options = array(
				'label' => "Modifier",
				'class' => 'btn-default btn'); ?>

			<!-- Fermeture du formulaire par un bouton Modifier -->
			<?php echo $this->Form->end($options); ?>

			<?php if(!empty($success))
			{
				echo $success . '<br/>';
			}
			?>

			<?php echo $this->Html->link("Votre combattant", array(
				'controller' => 'arenas',
				'action' => 'fighter'
				)
				); ?>

			<br/>	

			<?php echo $this->Html->link("Retourner dans l'arène", array(
				'controller' => 'arenas',
				'action' => 'sight'
				)
			); ?>

		</div>


		<!-- Appel d'un élément -->
		<?php echo $this->element('footer'); ?>

	</body>
</html>
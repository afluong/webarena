<!DOCTYPE html>
<html lang="fr">
<!-- Vue sight.ctp -->
<!-- Controller Arenas, action sight() -->

	<body>

		<!-- Appel d'un élément -->
		<?php echo $this->element('navbarAfterLogin'); ?>

		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4">
					<div class="content text-center">
						<h4 class="h4-custom">
							<span class="light">Vous jouez actuellement avec</span><br/>
							<?php echo $this->Html->link($name, array(
							'controller' => 'arenas',
							'action' => 'fighter'
							)); ?> <br/>
							<span class="light small">niveau <?php echo $level; ?> </span>
						</h4>
						<ul class="list-inline">
							<li>
								<i class="fa fa-heart" id="health"></i>
							</li>
							<li class="li-custom">
								<i class="fa fa-gavel" id="strength"></i>
							</li>
							<li class="li-custom">
								<i class="fa fa-eye" id="sight"></i>
							</li>
						</ul>

						<ul class="list-inline">
							<li>
								<?php echo $health; ?>/<?php echo $skill_health; ?>
							</li>
							<li class="li-custom">
								<?php echo $strength; ?>
							</li>
							<li class="li-custom">
								<?php echo $sight; ?>
							</li>
						</ul>
					</div>

					<div class="row">
						<div class="content custom-content content-sight text-center">
							<!-- Formulaire de déplacement -->
							<h5><span class="light">Aller vers</span></h5>
							<?php echo $this->Form->create('Fightermove'); ?>
							<?php echo $this->Form->input('direction', array(
								'label' => false,
								'options' => array(
									'north' => "Nord",
									'south' => "Sud",
									'east' => "Est",
									'west' => "Ouest"),
									'class' => 'form-control input-form'));?>
							<?php $options = array(
								'label' => "Se déplacer",
								'class' => 'btn-default btn btn-custom'); ?>
							<?php echo $this->Form->end($options); ?>

							<!-- Formulaire d'attaque -->
							<h5><span class="light">Attaquer vers</span></h5>
							<?php echo $this->Form->create('Fighterattack'); ?>
							<?php echo $this->Form->input('direction', array(
								'label' => false,
								'options' => array(
									'north' => "Nord",
									'south' => "Sud",
									'east' => "Est",
									'west' => "Ouest"),
									'class' => 'form-control input-form'));?>
							<?php $options = array(
								'label' => "Attaquer",
								'class' => 'btn-default btn btn-custom'); ?>
							<?php echo $this->Form->end($options); ?>

							<!-- Formulaire d'augmentation de niveau -->
							<?php echo $this->Form->create('Fighterlevelup'); ?>
							<?php echo $this->Form->input('choice', array(
								'label' => false,
								'options' => array(
									'strength' => "Force",
									'sight' => "Vision",
									'health' => "Santé"),
									'class' => 'form-control input-form'));?>
							<?php $options = array(
								'label' => "Augmenter",
								'class' => 'btn-default btn btn-custom'); ?>
							<?php echo $this->Form->end($options); ?>

						</div>
					</div>

				</div>

			<div class="col-lg-8">
				<div class="custom-content side-content text-center">
					<?php echo $board; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="msgBoard">
		<?php if(!empty($msg1)) {
			echo $msg1;
		}

		if(!empty($msg2)) {
			echo $msg2;
		}
		
		if(!empty($msg3)) {
			echo $msg3;
		}

		else
		{
			echo "&nbsp;";
		}
		?>

	</div>

	</body>

</html>
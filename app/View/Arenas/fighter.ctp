<!DOCTYPE html>
<html lang="fr">
<!-- Vue fighter.ctp -->
<!-- Controller Arenas, action fighter() -->

	<body>

		<!-- Appel d'un élément -->
		<?php echo $this->element('navbarAfterLogin'); ?>

		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4">
					<div class="content text-center">
					<h2><?php echo $name; ?></h2>
						<?php $filename = '../webroot/img/avatars/' . $id . '.png' ?>
						<?php if (file_exists($filename))
						{
							echo $this->Html->image('avatars/' . $id . '.png', array(
									'alt' => '',
									'style' => 'height: 150px; width:150px;'
									));
						}
						else
						{
							echo $this->Html->image('avatars/default.png', array(
									'alt' => '',
									'style' => 'height: 150px; width:150px;'
									));
						}
						?>
						<?php echo $this->Form->create('FighterAvatar', array('type' => 'file')); ?>
						<?php if(!empty($msg))
						{
							echo $msg;
						} 
						else
						{
							echo "&nbsp;";
						}
						?>
						<?php echo $this->Form->input('avatar_file', array(
							'label' => false,
							'type' => 'file',
							'class' => 'file-form'
							)); ?>
						<?php $options = array(
							'label' => 'Envoyer',
							'class' => 'btn btn-default',
							'div' => false
							); ?>
						<?php echo $this->Form->end($options); ?>						
					</div>
				</div>

				<div class="col-lg-8">
					<div class="content infos-content text-center" id="informations">
						<div class="col-lg-4">
							<h4 class="fighter"><span class="light">Niveau</span></h4>
							<h3><?php echo $level; ?></h3>
						</div>
						<div class="col-lg-4">
							<h4 class="fighter"><span class="light">Informations</span></h4>
							<p class="skill small"><i class="fa fa-heart" id="health"></i> : <?php echo $health; ?>/<?php echo $skill_health; ?></p>
							<div class="progress center-block">
							    <div class="progress-bar bar health" data-percentage="<?php echo ($health*100)/$skill_health ?>"></div>
							</div>
							<p class="skill small">xp : <?php echo $xp; ?>/4</p>
							<div class="progress center-block">
							    <div class="progress-bar bar" data-percentage="<?php echo ($xp*100)/4 ?>"></div>
							</div>
							<p class="skill small"><i class="fa fa-gavel" id="strength"></i> : <?php echo $strength; ?><i class="fa fa-eye" id="sight"></i> : <?php echo $sight; ?></p>
						</div>
						<div class="col-lg-4">
						<p>&nbsp;</p><br/><br/>
						<h1><span id="play"><?php echo $this->Html->link("JOUER", array(
								'controller' => 'arenas',
								'action' => 'sight'),
								array(
								'class' => 'play'
								)
								); ?></span></h1>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4">
					<div class="content custom-content content-fighter text-center">
						<h3>Vos combattants</h3>
						<div class="col-lg-12">
						<?php foreach ($fighters as $k => $fighter):?>
							<span class="overlay">
								<?php echo $fighter['Fighter']['name'] ?>
								<p class="small-custom" style="margin-bottom:0;">niveau <?php echo $fighter['Fighter']['level'] ?></p>
							</span>
						        <?php $filename = '../webroot/img/avatars/' . $fighter['Fighter']['id'] . '.png' ?>
						        <?php if(file_exists($filename))
							        {
							        	echo $this->Html->image('avatars/' . $fighter['Fighter']['id'] . '.png', array(
							        			'alt' => '',
							        			'class' => 'roundedFighter'
							        			));
							        }
							        else
							        {
							        	echo $this->Html->image('avatars/default.png', array(
							        			'alt' => '',
							        			'class' => 'roundedFighter'
							        			));
							        }
							        ?>
						<?php endforeach ?>
						<?php echo $this->Html->link(
							$this->Html->image('plus.png', array(
								'alt' => "",
								'class' => 'roundedFighter'
								)), array(
								'controller' => 'arenas',
								'action' => 'addfighter'
								),
								array('escape' => false));
						?>

						</div>
					</div>
				</div>

				<div class="col-lg-8">
					<div class="content custom-content content-diary text-center">
					<h3 style="margin-bottom:5px;">Evènements</h3>
					<h6 style="margin-bottom:8px;"><span class="light">dernières 24h</span></h6>
					<div id="diary">
						<?php if(empty($diary))
						{
							echo "Aucun évènement dans les parages depuis 24h";
						}
						?>
					</div>
					<table class="text-left">
						<!-- Titres du tableau -->
						<th>Date</th>
						<th>Evènement</th>
						<th>Coordonnée x</th>
						<th id="end">Coordonnée y</th>

						<?php foreach ($diary as $event): ?>
							<tr>
								<td>
									<?php echo $event['Event']['date']; ?>
								</td>

								<td>
									<?php echo $event['Event']['name']; ?>
								</td>

								<td>
									<?php echo $event['Event']['coordinate_x']; ?>
								</td>

								<td>
									<?php echo $event['Event']['coordinate_y']; ?>
								</td>
							</tr>
						<?php endforeach; ?>

					</table>

					<?php if(empty($diary))
					{
						echo '<div id="emptyTable">&nbsp;</div>';
					}
					?>

				</div>
			</div>
		</div>


		<?php echo $this->element('footer'); ?>

		<?php echo $this->Html->script('progressbar'); ?>

	</body>

</html>
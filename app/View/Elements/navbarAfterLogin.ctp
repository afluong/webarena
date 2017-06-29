<!-- Barre de navigation après connexion -->
<html lang="fr">

	<nav class="navbar navbar-custom navbar-fixed-top"  class="navbar-block" role="navigation">
	    <div class="container">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
	                <i class="fa fa-bars"></i>
	            </button>
	            <a class="navbar-brand page-scroll">
	                <i><?php echo $this->Html->image('warrior.png', array(
	                'style' => 'width: 20px;')); ?></i> &nbsp; <span class="light">Web</span> Arena
	            </a>
	        </div>

	        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
	            <ul class="nav navbar-nav">
	                <li>
	                	<?php echo $this->Html->link($email, array(
	                		'controller' => 'players',
	                		'action' => 'index'
	                		)); ?>
	                    <!--<a><?php //echo $email; ?></a>-->
	                </li>
	                <li>
	                    <?php echo $this->Html->link(" ",
	                            array('controller' => 'players',
	                                            'action' => 'logout',
	                                            'full_base' => true                  
	                                    ),
	                            array('class' => 'fa fa-power-off fa-lg', 'id' => 'power')); ?>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>

</html>
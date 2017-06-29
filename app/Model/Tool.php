<?php
//Model Tool
//Réfère à la table tools de la bdd ece_webarena

App::uses('AppModel', 'Model');

class Tool extends AppModel
{
	function add()
	{
		//Génération de la position aléatoire de l'objet à créer
		$y = rand(1, 10);
		$x = rand(1, 15);

		//Génération d'un type d'objet
		$bonus = rand(1, 3);

		switch ($bonus) {
			case 1:
				$type = "Potion";
				break;
			case 2:
				$type = "Epée";
				break;
			case 3:
				$type = "Lunettes";
				break;
		}

		$this->save(
			'type' => $type,
			'bonus' => $bonus,
			'coordinate_x' => $x,
			'coordinate_y' => $y,
			);

	}


}
?>
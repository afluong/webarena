<?php
//Model Event
//Réfère à la table events de la bdd ece_webarena

class Event extends AppModel
{
	//Méthode add() permettant de créer un évènement
	public function add($datas)
	{
		//Si on envoit des données
		if(!empty($datas))
		{
			$this->save(array(
				'name' => $datas['name'],
				'date' => date('Y-m-d H:i:s'),
				'coordinate_x' => $datas['coordinate_x'],
	    		'coordinate_y' => $datas['coordinate_y']
				)
			);
		}
	}	

	
}


?>
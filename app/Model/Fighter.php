<?php
//Model Fighter
//Réfère à la table fighters de la bdd ece_webarena

App::uses('AppModel', 'Model');

//Appel du model Event 
App::uses('Event', 'Model');

class Fighter extends AppModel
{
	//Validation des données envoyées depuis le controller
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'message' => "Champ obligatoire"
				),
			'taken' => array(
				'rule' => 'isUnique',
				'message' => "Ce nom de combattant est déjà pris"
				)
			)
		);
	
	//Méthode création d'un combattant 
	function add($name, $player_id)
	{
            //Génération de la position aléatoire du combattant à créer
            $y = rand(1, 10);
            $x = rand(1, 15);

            //Vérification qu'un autre combattant ne se trouve pas à cette position
            $fighter = $this->find('first', array(
                'conditions' => array(
                    'Fighter.coordinate_x' => $x,
                    'Fighter.coordinate_y' => $y
                    )
                )
            );

            //S'il n'y a personne à cette position, création du nouveau combattant
            if(empty($fighter)) 
            {
                $this->save(array(
                        'name' => $name,
                        'player_id' => $player_id,
                        'coordinate_y' => $y,
                        'coordinate_x' => $x,
                        'level' => 1,
                        'xp' => 1,
                        'skill_sight' => 2,
                        'skill_strength' => 1,
                        'skill_health' => 3,                    
                        'current_health' => 3                    
                        )
                    );

                //Création d'une entrée pour le model Event
                $loadEvent = new Event();

                //Ajout du message pour l'évènement
                $newEvent = array(
                    'name' => $name . " est entré dans l'arène",
                    'coordinate_y' => $y,
                    'coordinate_x' => $x
                    );

                //Appel de la méthode add() du model Event avec pour paramètre le message ci-dessus
                $loadEvent->add($newEvent);
            }

	}


	//[DoMove] Méthode isBusy() permettant de vérifier si la case est occupée
	// protected function isBusy($fighterId)
	// {
	// 	//Stockage des informations du combattant
	// 	$datas = $this->read(null, $fighterId);

	// 	//Initialisation d'un tableau tabMessage permettant de renvoyer un message dans le controller
	// 	$tabMessage[] = '';

	// 	if(!empty($this->read(null, $fighterId)))
	// 	{
	// 		//Inertie des coordonnées du combattants
	// 		$this->set('coordinate_y', $datas[$this->alias]['coordinate_y']);
 //            $this->set('coordinate_x', $datas[$this->alias]['coordinate_x']);
 //            return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}

	// }

	// //[DoMove] Méthode isOut() permettant de vérifier si le combattant sort de l'arène
	// protected function isOut($fighterId)
	// {
	// 	//Stockage des informations du combattant
	// 	$datas = $this->read(null, $fighterId);

	// 	//Initialisation d'un tableau tabMessage permettant de renvoyer un message dans le controller
	// 	$tabMessage[] = '';

	// 	if($datas[$this->alias]['coordinate_y'] > 10 || $datas[$this->alias]['coordinate_y'] < 1 || $datas[$this->alias]['coordinate_x'] > 15 || $datas[$this->alias]['coordinate_x'] < 1)
	// 	{
	// 		//Stockage dans le tableau d'un message
	// 		$tabMessage['message2'] = "Vous allez en dehors de l'arène !";

	// 		//Inertie des coordonnées du combattants
	// 		$this->set('coordinate_y', $datas[$this->alias]['coordinate_y']);
 //            $this->set('coordinate_x', $datas[$this->alias]['coordinate_x']);

	// 	}

	// 	//Renvoi du tableau vers le controller
	// 	return $tabMessage;
	// }

	//[DoAttack] Méthode isHurt() permettant d'enlever les points de vie de l'adversaire
    protected function isHurt($fighterId, $strength)
    {
    	//Stockage des informations du combattant
        $datas = $this->read(null, $fighterId);

        //Enlèvement des points de vie de l'adversaire en fonction des points de force du combattant
        $this->set('current_health', $datas[$this->alias]['current_health'] - $strength);

    	//Sauvegarde de la modification
        $this->save();
    }

	//[DoAttack] Méthode xpUp() permettant d'augmenter les xp
    protected function xpUp($fighterId, $level)
    {
    	//Stockage des informations du combattant
        $attacker = $this->read(null, $fighterId);

        //Ajout des xp en fonction de la valeur dans $level
        $this->set('xp', $attacker[$this->alias]['xp'] + $level);

        //Sauvegarde de la modification
        $this->save();
    } 

    //[DoAttack] Méthode isDead() permettant de vérifier si l'adversaire est mort, le supprimer et ajouter des xp à l'attaquant
    protected function isDead($fighterId, $attackerId)
    {
    	//Stockage des informations de l'adversaire
        $oponent = $this->read(null, $fighterId);

        //Si les points de vie de l'adversaire est inférieur à 1
        if($oponent[$this->alias]['current_health'] < 1)
        {
        	//Appel de la méthode xpUp()
     		$this->xpUp($attackerId, $oponent[$this->alias]['level']);

     		//Suppression de l'adversaire
            $this->delete($fighterId);
            return true;
        }

        //Sinon augmentation d'1 xp
        else	
        {
        	//Appel de la méthode xpUp()
            $this->xpUp($attackerId, 1);
            return false;
       	}
    }

    //[DoAttack] Méthode checkXp() permettant de vérifier si le combattant peut augmenter de niveau
    protected function checkXp($attackerId)
    {
    	//Stockage des informations du combattant
        $attacker = $this->read(null, $attackerId);

        //Si les xp du combattant sont supérieurs à 3
        if ($attacker[$this->alias]['xp'] > 3)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //[DoAttack] Méthode isFriend() permettant de vérifier si l'adversaire est l'un de nos combattants
    protected function isFriend($attackerId, $oponentId)
    {
        if($attackerId[$this->alias]['player_id'] == $oponentId[$this->alias]['player_id'])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //[DoAttack] Méthode attack() permettant d'attaquer l'adversaire
    protected function attack($attacker, $oponent)
    {
    	//Génération d'un nombre aléatoire
        $attack = rand(1, 20);

        //Défense de l'adversaire composée du level de l'adversaire et du combattant
        $defense = (10 + $oponent[$this->alias]['level'] - $attacker[$this->alias]['level']);

        //Initialisation d'un tableau tabMessage permettant de renvoyer un message dans le controller
        $tabMessage[]= '';

        //Si l'attaque réussie
        if(($attack - $defense) > 0)
        {
            //Appel de la méthode isHurt()
            $this->isHurt($oponent[$this->alias]['id'], $attacker[$this->alias]['skill_strength']);

            ////Stockage dans le tableau d'un message
            $tabMessage['message1'] = "Votre attaque a réussi !";
            
            //Création d'une entrée pour le model Event
            $loadEvent = new Event();

            //Ajout du message pour l'évènement
            $newEvent = array(
                   'name' => $attacker[$this->alias]['name'].' a réussi son attaque sur '. $oponent[$this->alias]['name']. ' !',
                    'coordinate_x' => $attacker[$this->alias]['coordinate_x'],
                    'coordinate_y' => $attacker[$this->alias]['coordinate_y']
                    );

            //Appel de la méthode add() du model Event avec comme paramètre le message défini au dessus
            $loadEvent->add($newEvent); 

            //Si l'appel de la méthode isDead() renvoie true
            if($this->isDead($oponent[$this->alias]['id'], $attacker[$this->alias]['id']))
            {
                //Création d'une entrée pour le model Event
                $loadEvent = new Event();

                //Ajout du message pour l'évènement
                $newEvent = array(
                       'name' => $attacker[$this->alias]['name'].' a tué '. $oponent[$this->alias]['name']. ' !',
                        'coordinate_x' => $attacker[$this->alias]['coordinate_x'],
                        'coordinate_y' => $attacker[$this->alias]['coordinate_y']
                        );

                //Appel de la méthode add() du model Event avec comme paramètre le message défini au dessus
                $loadEvent->add($newEvent); 

                //Stockage dans le tableau d'un message
                $tabMessage['message2'] = "Votre adversaire est mort.";
            }
        }
        else
        {
            //Création d'une entrée pour le model Event
            $loadEvent = new Event();

            //Ajout du message pour l'évènement
            $newEvent = array(
                   'name' => $attacker[$this->alias]['name'].' a échoué son attaque sur '. $oponent[$this->alias]['name']. ' !',
                    'coordinate_x' => $attacker[$this->alias]['coordinate_x'],
                    'coordinate_y' => $attacker[$this->alias]['coordinate_y']
                    );

            //Appel de la méthode add() du model Event avec comme paramètre le message défini au dessus
            $loadEvent->add($newEvent); 

			//Stockage dans le tableau d'un message
            $tabMessage['message1'] = "Votre attaque a échoué !";
        }
   
   		//Sauvegarde des modifications
        $this->save();

        //Si l'appel de la méthode checkXp() renvoie true
        if($this->checkXp($attacker[$this->alias]['id']))
        {
        	//Stockage dans le tableau d'un message
            $tabMessage['message3'] = "Vous pouvez augmenter de niveau !";
        }

        //Renvoi du tableau vers le controller
        return $tabMessage;
    }

    //[CheckerBoard] Méthode sight() permettant de voir sur le damier en fonction du skill_sight
    protected function sight($x, $y, $attacker_x, $attacker_y, $sight)
    {
        if(abs($x - $attacker_x) + abs($y - $attacker_y) <= $sight)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

//--------------------------------------------------------------------------------------------------------------------

    //Méthode doMove() permettant de faire déplacer son combattant dans l'arène
    function doMove($fighterId, $direction)
    {
    	//récupérer la position et fixer l'id de travail
    	$datas = $this->read(null, $fighterId);         
    	switch ($direction) {
    	    
    	    case 'north':
    	        $this->set('coordinate_y', $datas[$this->alias]['coordinate_y'] - 1);
    	        break;
    	    case 'south':
    	        $this->set('coordinate_y', $datas[$this->alias]['coordinate_y'] + 1);
    	        break;
    	    case 'east':
    	        $this->set('coordinate_x', $datas[$this->alias]['coordinate_x'] + 1);
    	        break;
    	    case 'west':
    	        $this->set('coordinate_x', $datas[$this->alias]['coordinate_x'] - 1);
    	        break;
    	    default:
    	        echo "Direction inconnue";
    	}

    	    //Vérification de la case
    	    $fighter = $this->find('first', array(
    	        'conditions' => array(
    	            'Fighter.coordinate_x' => $this->data[$this->alias]['coordinate_x'], 
    	            'Fighter.coordinate_y' => $this->data[$this->alias]['coordinate_y']
    	            )
    	        )
    	    );

    	    //Initialisation d'un tableau tabMessage permettant de renvoyer un message dans le controller
    	    $tabMessage[]= '';

    	    //*****************[A AMELIORER]*****************
    	    //Si la case est occupée
    	    if (!empty($fighter))
    	    {
    	    	//Stockage dans le tableau d'un message
    	        $tabMessage['message1']="Cette case est occupée.";

    	        //Inertie des coordonnées du combattants
    	        $this->set('coordinate_y', $datas[$this->alias]['coordinate_y']);
    	        $this->set('coordinate_x', $datas[$this->alias]['coordinate_x']);              
    	    }

    	    //Vérification que le combattant ne sorte pas de l'arène
    	    if ($this->data[$this->alias]['coordinate_y'] > 10 || $this->data[$this->alias]['coordinate_y'] < 1 || $this->data[$this->alias]['coordinate_x'] > 15 || $this->data[$this->alias]['coordinate_x'] < 1 )
    	    {
    	    	//Stockage dans le tableau d'un message
    	        $tabMessage['message2']="Vous allez en dehors de l'arène !";

    	        //Inertie des coordonnées du combattants
    	        $this->set('coordinate_y', $datas[$this->alias]['coordinate_y']);
    	        $this->set('coordinate_x', $datas[$this->alias]['coordinate_x']);
    	    }

    	    //Sauvegarde des modifications
    	    $this->save();

    	    //Renvoi du tableau vers le controller
    	    return $tabMessage;

    }


    //Méthode doAttack() permettant d'attaquer un adversaire
    function doAttack($fighterId, $direction)
    {
		//Stockage des informations du combattant
    	$attacker = $this->read(null, $fighterId);

    	switch ($direction) 
    	{
    		case 'north':
    			$this->set('coordinate_y', $attacker[$this->alias]['coordinate_y'] - 1);
    			break;
    		case 'south':
    			$this->set('coordinate_y', $attacker[$this->alias]['coordinate_y'] + 1);
    			break;
    		case 'east':
    			$this->set('coordinate_x', $attacker[$this->alias]['coordinate_x'] + 1);
    			break;
    		case 'west':
    			$this->set('coordinate_x', $attacker[$this->alias]['coordinate_x'] - 1);
    			break;
    		
    		default:
    			echo "Direction inconnue";
    			break;
    	}

    	//Stockage des informations de l'adversaire
	   	$oponent = $this->find('first', array(
	       'conditions' => array(
	           'Fighter.coordinate_x' => $this->data[$this->alias]['coordinate_x'], 
	           'Fighter.coordinate_y' => $this->data[$this->alias]['coordinate_y']
	           )
	       )
	   	);

	   	//S'il y a un adversaire
	   	if (!empty($oponent))
	   	{
	       $this->set('coordinate_y', $attacker[$this->alias]['coordinate_y']);
	       $this->set('coordinate_x', $attacker[$this->alias]['coordinate_x']);

	       if($this->isFriend($attacker, $oponent))
           {
                $tabMessage['message1']= 'Vous ne pouvez pas attaquer vos combattants.';
                return $tabMessage;
           }
           else
           {
               //Création d'une entrée pour le model Event
    	       $loadEvent = new Event();

    	       //Ajout du message pour l'évènement
    	       $newEvent = array(
    	           'name' => $attacker[$this->alias]['name'].' attaque '. $oponent[$this->alias]['name']. ' !',
    	           'coordinate_x' => $attacker[$this->alias]['coordinate_x'],
    	           'coordinate_y' => $attacker[$this->alias]['coordinate_y']
    	           );

    	       //Appel de la méthode add() du model Event avec comme paramètre le message défini au dessus
    	       $loadEvent->add($newEvent); 

    	       //Appel de la méthode attack()
    	       $attack = $this->attack($attacker, $oponent);
    	       return $attack;
            }
	   	}
	   	else
	   	{
	   		//Initialisation d'un tableau tabMessage permettant de renvoyer un message dans le controller
	       	$tabMessage[]= ''; 

	       	//Stockage dans le tableau d'un message
	       	$tabMessage['message1'] = "Il n'y a personne à attaquer";

	       	//Renvoi du tableau vers le controller
	       	return $tabMessage;
	   	}

    }

    //Méthode islevelUp() permettant d'augmenter le level du combattant et d'augmenter une de ses caractéristiques
    function levelUp($attackerId, $choice) 
    {
    	//Stockage des informations du combattant
        $attacker = $this->read(null, $attackerId);

        //Si les xp du combattant sont supérieurs à 3
        if (($attacker[$this->alias]['xp'] > 3))
        {
        	//Ajout de 1 sur le level du combattant
            $this->set('level', $attacker[$this->alias]['level'] + 1);

            //Enlèvement de 4 sur les xp du combattant
            $this->set('xp', $attacker[$this->alias]['xp'] - 4);

            //Augmentation d'une des caractéristiques du combattant
            switch ($choice)
            {
                case 'strength':
                	//Ajout de 1 sur la caractéristique force du combattant
                    $this->set('skill_strength', $attacker[$this->alias]['skill_strength'] + 1);
                    break;
                case 'sight':
                	//Ajout de 1 sur la caractéristique vue du combattant
                    $this->set('skill_sight', $attacker[$this->alias]['skill_sight'] + 1);
                    break;
                case 'health':
                	//Ajout de 3 sur la caractéristique vie du combattant
                    $this->set('skill_health', $attacker[$this->alias]['skill_health'] + 3);
                    break;
                
                default:
                    echo 'Choix inconnu.';
                    break;
            }

        //Sauvegarde des modifications
        $this->save();
            
        //Stockage des nouvelles informations du combattant
        $attacker = $this->read(null, $attackerId);

        //Création d'une entrée pour le model Event
        $loadEvent = new Event();

        //Ajout du message pour l'évènement
        $newEvent = array(
               'name' => $attacker[$this->alias]['name']. " est maintenant au niveau " . $attacker[$this->alias]['level']. " !",
                'coordinate_x' => $attacker[$this->alias]['coordinate_x'],
                'coordinate_y' => $attacker[$this->alias]['coordinate_y']
                );

        //Appel de la méthode add() du model Event avec comme paramètre le message défini au dessus
        $loadEvent->add($newEvent); 
           
    	}
	    else
	    {
	    	$xp = (4 - $attacker[$this->alias]['xp']);

	    	//Initialisation d'un tableau tabMessage permettant de renvoyer un message dans le controller
	        $tabMessage[] = '';

	        //Stockage dans le tableau d'un message
	        $tabMessage['message1'] = "Il vous manque ". $xp . " xp pour augmenter de niveau.";
	        //Renvoi du tableau vers le controller
	        return $tabMessage;
	    }
	}

    function checkerBoard($fighterId)
    {
        //Définition de la longueur et largeur du damier
        $length = 15;
        $width = 10;

        //Récupération des informations du combattant
        $attacker = $this->findById($fighterId);

        //Initialisation du damier
        $board = "<table cellspacing='1' border='1' align='center'>";

        //Parcours des coordonnées y
        for ($i = 1; $i <= $width; $i++)
        {
            $board = $board . '<tr class="board">';

            //Parcours des coordonnées x
            for ($j = 1; $j <= $length; $j++)
            {
                //Appel de la méthode sight()
                if($this->sight($j, $i, $attacker[$this->alias]['coordinate_x'], $attacker[$this->alias]['coordinate_y'], $attacker[$this->alias]['skill_sight']))
                {
                    //Vérification de la présence d'un adversaire à portée du combattant
                    $oponent = $this->find('all', array(
                        'conditions' => array(
                            'Fighter.coordinate_x' => $j,
                            'Fighter.coordinate_y' => $i
                            )
                        )
                    );

                    //S'il y a un combattant
                    if(!empty($oponent))
                    {
                        if($attacker[$this->alias]['coordinate_x'] == $j && $attacker[$this->alias]['coordinate_y'] == $i)
                        {
                            //Position du combattant dans le damier
                            $board = $board . '<td class="board" bgcolor="#fff">';
                        }
                        else
                        {
                            //Position à vue des adversaires dans le damier
                            $board = $board . '<td class="board" bgcolor="#660000">';
                        }
                    }
                    else
                    {
                        //Pas d'adversaire à vue
                        $board = $board . '<td class="board" bgcolor="#000">';
                    }
                }
                else
                {  
                    //Cases non visibles par le combattant
                    $board = $board . '<td class="board" bgcolor="#111">';
                }

            $board = $board . '</td>';

            }

        $board = $board . '</tr>';

        }

        return $board;
    }

    function fighterChoice($player_id)
    {
        $fighters = $this->find('all', array(
            'conditions' => array(
                'Fighter.player_id' => $player_id
                )
            )
        );
        
        return $fighters;
    }

}


?>
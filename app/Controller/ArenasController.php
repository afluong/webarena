<?php
// Controller Arenas
// Actions index, fighter, addfighter, sight, diary

App::uses('AppController', 'Controller');

class ArenasController extends AppController
{
	//Utilisation des models Player, Fighter et Event
	public $uses = array('Player', 'Fighter', 'Event');

	public function beforeFilter()
	{
		parent::beforeFilter();

		//Autorisation d'accès à l'action index() sans se loguer
		$this->Auth->allow('index');
	}

	//Action index() permettant d'afficher la page d'accueil du site
	public function index()
	{


	}

	//Action fighter() permettant d'afficher les informations du (ou des) combattant(s)
	function fighter()
	{
		//Stockage de l'id du combattant récupéré de la session
		$fighterId = $this->Session->read('fighterId');

		if($this->request->data('FighterAvatar'))
		{
			$data = $this->request->data;
			$extension = strtolower(pathinfo($data['FighterAvatar']['avatar_file']['name'], PATHINFO_EXTENSION));

			//Méthode upload d'avatar
			if(
			    !empty($data['FighterAvatar']['avatar_file']['tmp_name']) &&
			    in_array($extension, array('png'))
			    )
			{
			    move_uploaded_file($data['FighterAvatar']['avatar_file']['tmp_name'], IMAGES . 'avatars' . DS . $fighterId . '.' . $extension);
			}
			else
			{
				$this->set('msg', "Erreur lors du téléchargement, format .png requis");
			}


		}

		//Affichage des évènements
		$diary = $this->Event->find('all', array(
		    'conditions' => array(
		        'Event.date BETWEEN NOW() -INTERVAL 1 DAY AND NOW()'),
		    'order' => array('Event.id DESC'),
		    'limit' => 5
		    ));

		$this->set('diary', $diary);

		//Stockage dans datas des informations du combattant
		$this->set('id', $fighterId);
		$datas = $this->Fighter->findById($fighterId);

		$playerId = $datas['Fighter']['player_id'];

		$fighters = $this->Fighter->fighterChoice($playerId);
		$this->set('fighters', $fighters);

		//Stockage des informations du combattant pour la vue
		$this->set('name', $datas['Fighter']['name']);
		$this->set('level', $datas['Fighter']['level']);
		$this->set('strength', $datas['Fighter']['skill_strength']);
		$this->set('sight', $datas['Fighter']['skill_sight']);
		$this->set('health', $datas['Fighter']['current_health']);
		$this->set('skill_health', $datas['Fighter']['skill_health']);
		$this->set('xp', $datas['Fighter']['xp']);
		$this->set('x', $datas['Fighter']['coordinate_x']);
		$this->set('y', $datas['Fighter']['coordinate_y']);

		//Stockage de l'email du joueur pour la vue
		$this->set('email', $this->Session->read('Auth.User.email'));
	}

	//Action addfighter() permettant de créer un combattant
	function addfighter()
	{
		//Si on envoit des données
		if(!empty($this->request->data))
		{
			//Appel de la méthode add() du model Fighter 
			$this->Fighter->add($this->request->data['Fighter']['name'], $this->Session->read('Auth.User.id'));

			$fighter = $this->Fighter->find('first', array(
			    'conditions' => array(
			        'Fighter.name' => $this->request->data['Fighter']['name']
			        )
			    )
			);

			$this->Session->write('fighterId', $fighter['Fighter']['id']);

			return $this->redirect(array(
				'controller' => 'arenas',
				'action' => 'fighter'
				)
			);
		}

		$this->set('email', $this->Session->read('Auth.User.email'));

	}

	//Action sight() permettant au combattant de réaliser des actions d'attaques, de déplacement et d'augmentation de niveau
	function sight()
	{
		//Stockage de l'id du combattant récupéré de la session
		$fighterId = $this->Session->read('fighterId');

		//Si on envoit des données
		if(!empty($this->request->data))
		{
			//Si l'action du formulaire envoyée est Fightermove
			if($this->request->data('Fightermove'))
			{
				//Appel de la méthode doMove() du model Fighter
				$doMove = $this->Fighter->doMove($fighterId, $this->request->data['Fightermove']['direction']);

				//Stockage des messages d'informations pour la vue
				if(!empty($doMove['message1']))
				{
				    $this->set('msg1', $doMove['message1']);
				}

				if(!empty($doMove['message2']))
				{    
				    $this->set('msg2', $doMove['message2']);
				}
			}
			//Si l'action du formulaire envoyée est Fighterattack
			elseif ($this->request->data('Fighterattack')) 
			{
				//Appel de la méthode doAttack() du model Fighter
				$doAttack = $this->Fighter->doAttack($fighterId, $this->request->data['Fighterattack']['direction']);

				//Stockage des messages d'informations pour la vue
				if(!empty($doAttack['message1']))
				{
				    $this->set('msg1', $doAttack['message1']);
				}

				if(!empty($doAttack['message2']))
				{    
				    $this->set('msg2', $doAttack['message2']);
				}

				if(!empty($doAttack['message3']))
				{    
				    $this->set('msg3', $doAttack['message3']);
				}

			}
			//Si l'action du formulaire envoyée est Fighterlevelup
			elseif ($this->request->data('Fighterlevelup')) 
			{
				//Appel de la méthode levelUp() du model Fighter
				$levelUp = $this->Fighter->levelUp($fighterId, $this->request->data['Fighterlevelup']['choice']);

				//Stockage des messages d'informations pour la vue
				if(!empty($levelUp['message1']))
				{
				    $this->set('msg1', $levelUp['message1']);
				}
			}
			//Si l'action du formulaire envoyée est Toolpickup
			elseif ($this->request->data('Toolpickup')) 
			{
				//Appel de la méthode levelUp() du model Fighter
				$pickUp = $this->Fighter->pickupTools($fighterId, $this->request->data['Toolpickup']['direction']);

				//Stockage des messages d'informations pour la vue
				if(!empty($pickUp['message1']))
				{
				    $this->set('msg1', $levelUp['message1']);
				}
			}
		}



		$board = $this->Fighter->checkerBoard($fighterId);
		
		$this->set('board', $board);

		//Récupération des informations du combattant
		$datas = $this->Fighter->find('first', array(
			'conditions' => array(
				'Fighter.id' => $fighterId)));

		//Stockage des informations du combattant pour la vue
		$this->set('name', $datas['Fighter']['name']);
		$this->set('level', $datas['Fighter']['level']);
		$this->set('strength', $datas['Fighter']['skill_strength']);
		$this->set('sight', $datas['Fighter']['skill_sight']);
		$this->set('health', $datas['Fighter']['current_health']);
		$this->set('skill_health', $datas['Fighter']['skill_health']);
		$this->set('xp', $datas['Fighter']['xp']);
		$this->set('x', $datas['Fighter']['coordinate_x']);
		$this->set('y', $datas['Fighter']['coordinate_y']);

		//Stockage de l'email du joueur pour la vue
		$this->set('email', $this->Session->read('Auth.User.email'));

	}

}

?>
<?php

App::uses('AppController', 'Controller');

class PlayersController extends AppController
{
	//Utilisation des model Player et Fighter
	public $uses = array('Player', 'Fighter');

	public function beforeFilter()
	{
		parent::beforeFilter();

		//Autorisation d'accès aux actions login, register et recover sans se loguer
		$this->Auth->allow('login', 'register', 'recover');

	}

	function index()
	{
		//Vérification que la requête envoyée est de type post
		if($this->request->is('post'))
		{
			//Stockage et chiffrage des mots de passe
			$pwd_c = $this->Auth->password($this->request->data['Player']['current_password']);
			$new_pwd = $this->Auth->password($this->request->data['Player']['new_password']);
			$new_pwd_r = $this->Auth->password($this->request->data['Player']['new_passwordr']);

			//Stockage des informations du joueur actuel 
			$player = $this->Player->find('first', array(
				'conditions' => array(
					'Player.id' => $this->Session->read('Auth.User.id')
					)
				)
			);

			//Vérification du mot de passe actuel
			if($pwd_c == $player['Player']['password'])
			{
				if($pwd_c != $new_pwd)
				{
					//Vérification du nouveau mot de passe
					if($new_pwd == $new_pwd_r)
					{
						//Appel de la méthode changePassword() du model Player
						$this->Player->changePassword($this->Session->read('Auth.User.id'), $new_pwd);
						$this->set('success', "Votre mot de passe a bien été changé");
					}
					else
					{
						$this->set('error_1', "Les deux mots de passe doivent être identiques");
					}
				}
				else
				{
					$this->set('error_2', "Le nouveau mot de passe doit être différent de l'ancien");
				}
			}
			else
			{
				$this->set('error_3', "Le mot de passe actuel est incorrect");
			}

		}
		else
		{
			$this->set('error', "Votre mot de passe n'a pas pu être changé, veuillez réeesayer");
		}

		//Stockage de l'email du joueur pour la vue
		$this->set('email', $this->Session->read('Auth.User.email'));
	}
	
	public function login()
	{
		if($this->request->is('post'))
		{
			if($this->Auth->login())
			{
				$fighter = $this->Fighter->find('first', array(
					'conditions' => array(
						'Fighter.player_id' => $this->Session->read('Auth.User.id')
						)
					)
				);

				if(empty($fighter))
				{
					return $this->redirect(array(
						'controller' => 'arenas',
						'action' => 'addfighter'
						)
					);
				}
				else
				{
					$this->Session->write('fighterId', $fighter['Fighter']['id']);

					return $this->redirect(array(
						'controller' => 'arenas',
						'action' => 'fighter'
						)
					);
				}
			}
			else
			{
				$this->set('msg', "Email ou mot de passe incorrect");
			}
		}

	}

	public function register()
	{
		//Si on envoit des données
		if(!empty($this->request->data))
		{
			//Hashage des mots de passe avec la méthode password() du component Auth
			$pwd = $this->Auth->password($this->request->data['Player']['password']);
			$pwd_r = $this->Auth->password($this->request->data['Player']['password_r']);

			//Vérification du mot de passe
			if($pwd == $pwd_r)
			{
				//Appel de la méthode add() du model Player
				$this->Player->add($this->request->data['Player']['email'], $pwd);
				return $this->redirect(array(
					'controller' => 'players',
					'action' => 'login'
					)
				);

			}
			else
			{	
				$this->set('message', "Les deux mots de passe doivent être identiques");
			}
		}

	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());

	}

	public function recover()
	{
		if($this->request->is('post'))
		{
			$player = $this->Player->find('first', array(
				'conditions' => array(
					'Player.email' => $this->request->data['Player']['email']
					)
				)
			);

			if(!empty($player))
			{
				//Appel de la méthode generatePassword() du model Player
				$pwd = $this->Player->generatePassword($this->request->data['Player']['email']);

				//Chiffrage du nouveau mot de passe
				$new_pwd = $this->Auth->password($pwd);

				//Appel de la méthode changePassword() du model Player
				$this->Player->changePassword($player['Player']['id'], $new_pwd);

				return $this->redirect(array(
					'controller' => 'players',
					'action' => 'login'
					)
				);				
			}
			else
			{
				$this->set('msg', "Adresse email non valide");
			}

		}
	}




}

?>
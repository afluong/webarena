<?php
//Model Player
//Réfère à la table players de la bdd ece_webarena

App::uses('AppModel', 'Model');

class Player extends AppModel
{
	//Validation des données envoyées depuis le Controller
	public $validate = array(
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'message' => "Champ obligatoire"
				),
			'validEmail' => array(
				'rule' => array('email'),
				'message' => "Adresse email invalide"
				),
			'taken' => array(
				'rule' => 'isUnique',
				'message' => "Cette adresse email existe déjà"
				)
			),
		'password' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'message' => "Champ obligatoire"
				)
			),
		'password_r' => array(
			'rule' => 'notBlank',
			'message' => "Champ obligatoire"
			)
		);

	//[generatePassword] Méthode sendPassword() permettant d'envoyer le mot de passe généré par mail
	protected function sendPassword($email, $password)
	{
		App::uses('CakeEmail', 'Network/Email');

		// $mail = new CakeEmail();
		// $mail ->to($email)
		//       ->subject('Récupération de votre mot de passe')
		//       ->template('recoverPass')
		//       ->viewVars(array('email' => $email, 'pwd' => $password))
		//       ->emailFormat('html');
		//       ->send();
	}

//--------------------------------------------------------------------------------------------------------------------

	//Méthode add() permettant de créer un joueur
	function add($email, $password)
	{
		$this->save(array(
			'email' => $email,
			'password' => $password
			)
		);
	}

	//Méthode changePassword() permettant de modifier son mot de passe
	function changePassword($id, $pwd)
	{
		//Identification de l'id du joueur
		$this->id = $id;

		//Sauvegarde du nouveau mot de passe
		$this->save(array(
			'password' => $pwd
			)
		);
	}

	//Méthode generatePassword() permettant de générer un mot de passe aléatoire et l'envoyer par mail
	function generatePassword($email)
	{
		//Stockage des chaines de caractères possibles
		$alphanumeric = "abcdefghijklmnopqrstuvwxyz0123456789";

		//Initialisation du mot de passe
		$password = "";

		//Boucle permettant de générer des chaines de 8 caractères aléatoirement
		for($i = 1; $i <= 8; $i++)
		{
			$rand = strlen($alphanumeric);
			$rand = mt_rand(0, ($rand - 1));
			$password .= $alphanumeric[$rand];
		}

		//Appel de la méthode sendPassword() pour envoyer le mot de passe par mail
		//$this->sendPassword($email, $password);

		return $password;

	}

}

?>
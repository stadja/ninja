<?php
class Mail extends CI_Model {

	function __construct() {
		parent::__construct();

		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);

		$this->email->from('ninja@stadja.net', 'Le facteur');
	}

	function send_invitation($user, $invitation_id) {
		$lien = "http://ninja.stadja.net/invitation/".$invitation_id;

		$this->email->to($user->email);
		$this->email->subject('Invitation au projet Ninja');

		$message = "<html><head></head><body>Bienvenue ".$user->firstname." ".$user->name.", ceci est votre invitation au projet Ninja !<br/><br/>Vous pouvez désormais vous inscrire en cliquant <a href='".$lien."'>sur ce lien</a> ou en copiant cette adresse dans la barre d'adresse de votre navigateur : <strong>".$lien."</strong><br/><br/><strong>Important : </strong>Utilisez bien le courriel suivant pour votre inscription : <strong>".$user->email."</strong><br/><br/>L'équipe du projet Ninja vous remercie et vous attend avec impatience.</body></html>";

		$this->email->message($message);
		$this->email->send();

	}
	
}
?>

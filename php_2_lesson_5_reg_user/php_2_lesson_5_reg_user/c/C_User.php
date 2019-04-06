<?php
//
// Конттроллер страницы пользователя.
//
include_once('m/model.php');

class C_User extends C_Base
{
	//
	// Конструктор.
	//
	
	public function action_index(){
		$this->title .= ': Главная страница сайта';
		$text = 'Это главная страница. <br/>Вы можете войти в систему, выйти из нее, а также посетить Личный кабинет.';
		$this->content = $this->Template('v/v_index.php', array('text' => $text));	
	}
	
	public function action_edit(){
		$this->title .= '::Редактирование';
		
		if($this->isPost())
		{
			text_set($_POST['text']);
			header('location: index.php');
			exit();
		}
		
		$text = text_get();
		$this->content = $this->Template('v/v_edit.php', array('text' => $text));		
	}

	public function action_login(){
		$this->title .= ': Авторизация';

		$text = "Вход в систему";
		$this->content = $this->Template('v/v_login.php', array('text' => $text));		
		if (isset($_POST['login_submit'])) 
		{
			login();
		}
	}

	public function action_logout(){
		$this->title .= ': Выход';
		
		$text = "Выход из системы";
		$this->content = $this->Template('v/v_logout.php', array('text' => $text));	
		if (isset($_POST['logout_submit'])) 
		{
			logout();	
		}
	}

	public function action_account(){
		$this->title .= ': Личый кабинет';
		
		$text = "Личный кабинет";
		$this->content = $this->Template('v/v_account.php', array('text' => $text,'alert' => account()));		
	}
}

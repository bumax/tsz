<?php
class Controller {

	private $data;
	private $warning;

	public function index(){
		include('./model/model.php');
		$model = new Model;
		if(isset($_POST['submit']))
			if($model->login($_POST))
				$this->redirect('?route=main');
			else
				$this->warning = 'Неверный пароль!';
		$this->render('login.tpl');
	}
	
	public function main(){
		include('./model/model.php');
		$model = new Model;
		session_start();
			if(isset($_POST['submit'])){
				$this->warning  = $model->changeEP($_POST);
			}
		$this->data = $model->getRoom($_SESSION['user_data']['room']);
		$this->render('main.tpl');	
	}
	
	public function logout(){
		session_unset();
		$this->redirect('');
	}

	public function meters(){
		include('./model/model.php');
		$model = new Model;
		session_start();
		$this->data = $model->getRoom($_SESSION['user_data']['room']);
			if(isset($_POST['submit'])){
				$this->warning = $model->sendMetersData($_POST);
				$this->data = $_SESSION['user_data'];
			}
		$this->render('meters.tpl');	
	}

	public function receipts(){
		include('./model/model.php');
		$model = new Model;
		session_start();
		$this->data = $model->getRoom($_SESSION['user_data']['room']);
		$this->data['receipts'] = $model->getreceipts($this->data);
		$this->render('receipts.tpl');	
	}

	public function admin(){
		include('./model/model.php');
		$model = new Model;
		session_start();
			if($_SESSION['user_data']['room'] != 0)
				$this->redirect('?route=main');
			else{
				if(isset($_GET['remove'])){
					$model->removeM($_GET['remove']);		
					$this->redirect('?route=admin&room='.$_GET['room']);		
				}
			if(isset($_GET['room'])){
				if(isset($_POST['submit'])){
					if(!isset($_GET['edit'])){
						$model->sendRoomData($_POST);
					}
					else{
						$model->sendMData($_POST);		
						$this->redirect('?route=admin&room='.$_GET['room']);
					}
				}
				$this->data = $model->getRoom($_GET['room']);
					if(isset($_GET['edit'])){
						$this->render('metinfo.tpl');
					}
					else{
						$this->render('appinfo.tpl');
					}
			}
			else{
				if(isset($_POST['submit'])){
					if($_POST['submit']=='Очистить'){
						$model->clearM($_POST['year'].'-'.$_POST['month']);
					}
					else
						$this->redirect('get.php?v='.$_POST['year'].'-'.$_POST['month']);
				}
				$this->data = $model->getRoom($_SESSION['user_data']['room']);
				$this->data['rooms'] = $model->getRooms();
				$this->render('admin-1.tpl');	
			}
			}
	}

	
	public function feedback(){
		include('./model/model.php');
		$model = new Model;
		session_start();
			if(isset($_POST['submit'])){
				$this->warning = $model->feedback($_POST['text']);
			}
		$this->render('feedback.tpl');
	}
	

	public function redirect($url){
		header("Location: http://".$_SERVER['HTTP_HOST']."/tsz/".$url);		
	}
	
	
	private function render($template){
		include_once('./model/model.php');
		$model = new Model;
		extract($this->data);
		include('./view/header.tpl');
		include('./view/'.$template);
		include('./view/footer.tpl');
	}
}
?>
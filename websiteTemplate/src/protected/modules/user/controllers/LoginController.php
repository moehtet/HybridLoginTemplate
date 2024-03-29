<?php

class LoginController extends Controller {

	public $defaultAction = 'login';

	public function actions() {
		return array(
			'oauth' => array(
				'class' => 'ext.hoauth.HOAuthAction',
			),
//			'oauthadmin' => array(
//				'class' => 'ext.hoauth.HOAuthAdminAction',
//			),
		);
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		if (Yii::app()->user->isGuest) {
			$model = new UserLogin;
			// collect user input data
			if (isset($_POST['UserLogin'])) {
				$model->attributes = $_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if ($model->validate()) {
					$this->lastViset();
					if (Yii::app()->getBaseUrl() . "/index.php" === Yii::app()->user->returnUrl)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login', array('model' => $model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}

	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}

}

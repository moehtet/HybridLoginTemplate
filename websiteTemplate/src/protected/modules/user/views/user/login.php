<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login");
$this->breadcrumbs = array(
	UserModule::t("Login"),
);
?>

<h1><?php echo UserModule::t("Login"); ?></h1>

<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

	<div class="success">
		<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
	</div>

<?php endif; ?>

<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
	<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model, 'email'); ?>
		<?php echo CHtml::activeTextField($model, 'email') ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model, 'password'); ?>
		<?php echo CHtml::activePasswordField($model, 'password') ?>
	</div>

	<div class="row">
		<p class="hint">
			<?php echo CHtml::link(UserModule::t("Register"), Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
		<?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>
	</div>

	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Login")); ?>
	</div>

	<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
	'elements' => array(
		'email' => array(
			'type' => 'text',
			'maxlength' => 32,
		),
		'password' => array(
			'type' => 'password',
			'maxlength' => 32,
		),
		'rememberMe' => array(
			'type' => 'checkbox',
		)
	),
	'buttons' => array(
		'login' => array(
			'type' => 'submit',
			'label' => 'Login',
		),
	),
		), $model);
?>

<?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>


<script>
	$(document).ready(function() {
		$('#fb-btn').on('click', function(e) {
			e.preventDefault();
			FB.login(function(response) {
				if (response.authResponse) {
					alert('Login ');
				} else {
					alert("Please login with Facebook");
				}
			}, {scope: 'email, user_about_me, user_birthday, user_hometown,user_photos, friends_photos,user_address,user_mobile_phone,publish_actions'});
		});
	});

</script>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId: '1466308250271202',
			xfbml: true,
			version: 'v2.0'
		});
	};

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<a id="fb-btn" href="#">Login with Facebook(New Facebook Login)</a>
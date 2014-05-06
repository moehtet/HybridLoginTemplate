<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<script src="<?php echo $baseUrl; ?>/js/all/formatter.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/all/jquery.formatter.min.js"></script>
<!--<script src="<?php echo $baseUrl; ?>/js/all/jquery-2.1.1.min.js"></script>-->
<script>
	$(document).ready(function() {
		$("#RegistrationForm_nric").formatter({
			'pattern': '{{999}}-{{999}}',
			'persistent': true
		});
	});
</script>

<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
$this->breadcrumbs = array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if (Yii::app()->user->hasFlash('registration')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('registration'); ?>
	</div>
<?php else: ?>

	<div class="form">
		<?php
		$form = $this->beginWidget('UActiveForm', array(
			'id' => 'registration-form',
			'enableAjaxValidation' => true,
			'disableAjaxValidationAttributes' => array('RegistrationForm_verifyCode'),
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
		?>

		<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

		<?php echo $form->errorSummary(array($model, $profile)); ?>

		<div class="row">
			<?php echo $form->labelEx($model, 'fullname'); ?>
			<?php echo $form->textField($model, 'fullname'); ?>
			<?php echo $form->error($model, 'fullname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'password'); ?>
			<?php echo $form->passwordField($model, 'password'); ?>
			<?php echo $form->error($model, 'password'); ?>
			<p class="hint">
				<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
			</p>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'verifyPassword'); ?>
			<?php echo $form->passwordField($model, 'verifyPassword'); ?>
			<?php echo $form->error($model, 'verifyPassword'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'email'); ?>
			<?php echo $form->textField($model, 'email'); ?>
			<?php echo $form->error($model, 'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'nric'); ?>
			<?php echo $form->textField($model, 'nric', array('maxlength' => 12)); ?>
			<?php echo $form->error($model, 'nric'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'contact_number'); ?>
			<?php echo $form->textField($model, 'contact_number', array('maxlength' => 20)); ?>
			<?php echo $form->error($model, 'contact_number'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'address'); ?>
			<?php echo $form->textArea($model, 'address'); ?>
			<?php echo $form->error($model, 'address'); ?>
		</div>

		<?php
		$profileFields = Profile::getFields();
		if ($profileFields) {
			foreach ($profileFields as $field) {
				?>
				<div class="row">
					<?php echo $form->labelEx($profile, $field->varname); ?>
					<?php
					if ($widgetEdit = $field->widgetEdit($profile)) {
						echo $widgetEdit;
					} elseif ($field->range) {
						echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
					} elseif ($field->field_type == "TEXT") {
						echo$form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
					} else {
						echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
					}
					?>
					<?php echo $form->error($profile, $field->varname); ?>
				</div>
				<?php
			}
		}
		?>
		<?php if (UserModule::doCaptcha('registration')): ?>
			<div class="row">
				<?php echo $form->labelEx($model, 'verifyCode'); ?>

				<?php $this->widget('CCaptcha'); ?>
				<?php echo $form->textField($model, 'verifyCode'); ?>
				<?php echo $form->error($model, 'verifyCode'); ?>

				<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
					<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
			</div>
		<?php endif; ?>

		<div class="row submit">
			<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
		</div>

		<?php $this->endWidget(); ?>
	</div><!-- form -->
<?php endif; ?>
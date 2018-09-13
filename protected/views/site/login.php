<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
             <table>
                <tr>
                    <td>
                        <div class="row">
                        <?php echo $form->labelEx($model,'username'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                        <?php echo $form->textField($model,'username'); ?>
                        <?php echo $form->error($model,'username'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="row">
                        <?php echo $form->labelEx($model,'password'); ?>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                        <?php echo $form->passwordField($model,'password'); ?>
                        <?php echo $form->error($model,'password'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <div class="row">
                        <?php echo $form->checkBox($model,'rememberMe'); ?>
                        <?php echo $form->label($model,'rememberMe'); ?>
                        <?php echo $form->error($model,'rememberMe'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <div class="row buttons">
                                <?php echo CHtml::submitButton('Login'); ?>
                        </div>
                    </td>
                </tr>
            <table>	
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

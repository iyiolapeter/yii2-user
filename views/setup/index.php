<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use pso\yii2\user\models\UserType;
use yii\helpers\Html;
use yii\helpers\Url;
use pso\yii2\widgets\ActiveForm;

$this->title = 'Setup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="auth-login">
    <h3 class="mg-b-5">User</h3>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'type_id')->dropDownList(UserType::fetchOptions(), ['prompt' => 'Select User Type']) ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    <h3 class="mg-b-5">Profile</h3>
    <?= $form->field($model->profile, 'email') ?>
    <?= $form->field($model->profile, 'first_name') ?>
    <?= $form->field($model->profile, 'last_name') ?>
    <div class="form-group">
        <?= Html::submitButton('Setup', ['class' => 'btn btn-brand-02 btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
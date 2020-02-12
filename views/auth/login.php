<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use pso\yii2\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@pso/yii2/user/views/layouts/auth.php')?>
<div class="auth-login">
    <h3 class="mg-b-5">Login</h3>
    <p class="mg-b-40">Welcome back! Please login to continue.<?=$model->identityClass?></p>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password',[
            'template' => "<div class='d-flex justify-content-between mg-b-5'>{label}<a href='".Url::to(['auth/forgot-password'])."' class='tx-13'>Forgot password?</a></div>\n{input}\n{hint}\n{error}"
        ])->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-brand-02 btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->endContent()?>
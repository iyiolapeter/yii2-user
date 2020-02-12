<?php

namespace pso\yii2\user\controllers;

use Yii;
use pso\yii2\user\models\form\RegistrationForm;
use pso\yii2\user\UserModule;
use pso\yii2\user\models\Profile;
use yii\web\NotFoundHttpException;


class SetupController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $module = UserModule::getInstance();
        if(!$module || !$module->allowSetup){
            throw new NotFoundHttpException('Requested page does not exist');
        }
        $form = new RegistrationForm();
        $form->setProfile(new Profile());
        if($form->load(Yii::$app->request->post()) && $form->profile->load(Yii::$app->request->post()) && $form->save()){
            return $this->goHome();
        }
        return $this->render('index', [
            'model' => $form
        ]);
    }

}

<?php

namespace pso\yii2\user\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use pso\yii2\user\models\form\LoginForm;

class AuthController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'actions' => ['login', 'register','forgot-password', 'reset-password'],
            //             'allow' => true,
            //             'roles' => ['?']
            //         ],
            //         [
            //             'actions' => ['logout'],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionForgotPassword()
    {
        return $this->render('forgot-password');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->authenticate()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionRegister()
    {
        return $this->render('register');
    }

    public function actionResetPassword()
    {
        return $this->render('reset-password');
    }

}

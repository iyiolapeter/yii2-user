<?php

namespace pso\yii2\user;

/**
 * user module definition class
 */
class UserModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'pso\yii2\user\controllers';

    public $allowSetup = YII_ENV_DEV;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

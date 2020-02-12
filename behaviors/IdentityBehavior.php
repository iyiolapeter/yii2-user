<?php

namespace pso\yii2\user\behaviors;

use yii\base\Behavior;

class IdentityBehavior extends Behavior
{
    public $identityClass = 'pso\yii2\user\models\User';
}
<?php

namespace pso\yii2\user\interfaces;

interface PasswordInterface
{
    public function validatePassword($password);
    public function setPassword($password);
}
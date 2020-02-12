<?php

namespace pso\yii2\user\models\query;

/**
 * This is the ActiveQuery class for [[\pso\yii2\user\models\User]].
 *
 * @see \pso\yii2\user\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function username($username)
    {
        return $this->andWhere(['username' => $username]);
    }

    public function profile(){
        return $this->innerJoinWith(['profile'])->with(['profile']);
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

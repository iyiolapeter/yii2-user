<?php

namespace pso\yii2\user\models\query;

/**
 * This is the ActiveQuery class for [[\pso\yii2\user\models\UserType]].
 *
 * @see \pso\yii2\user\models\UserType
 */
class UserTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\UserType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\UserType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

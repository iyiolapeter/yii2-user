<?php

namespace pso\yii2\user\models\query;

/**
 * This is the ActiveQuery class for [[\pso\yii2\user\models\Profile]].
 *
 * @see \pso\yii2\user\models\Profile
 */
class ProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\Profile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \pso\yii2\user\models\Profile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

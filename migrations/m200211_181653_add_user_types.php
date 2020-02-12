<?php

namespace pso\yii2\user\migrations;

use yii\db\Migration;

/**
 * Class m200211_181653_add_user_types
 */
class m200211_181653_add_user_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user_type}}', [
            'id' => 'user',
            'name' => 'User'
        ]);
        $this->insert('{{%user_type}}', [
            'id' => 'admin',
            'name' => 'Admin'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200211_181653_add_user_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200211_181653_add_user_types cannot be reverted.\n";

        return false;
    }
    */
}

<?php

namespace pso\yii2\user\migrations;

use yii\db\Migration;

/**
 * Class m200211_170551_init
 */
class m200211_170551_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_type}}', [
            'id' => $this->string(40)->unique(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);
        $this->addPrimaryKey('pk_user_type', '{{%user_type}}','id');
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->string(40)->notNull(),
            'username' => $this->string(40)->unique(),
            'password' => $this->string()->null(),
            'auth_key' => $this->string()->null(),
            'verified' => $this->boolean()->notNull()->defaultValue(0),
            'status' => "ENUM('active', 'inactive', 'blocked','deleted') NOT NULL DEFAULT 'inactive'",
            'last_login' => $this->timestamp()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);
        $this->addForeignKey('fk_user_user_type','{{%user}}', 'type_id', '{{%user_type}}','id','RESTRICT', 'CASCADE');
        $this->addColumn('{{%user}}', 'auto', $this->boolean()
                                                ->notNull()
                                                ->defaultValue(0)
                                                ->after('verified'));
        $this->addColumn('{{%user}}', 'is_system', "ENUM('1') NULL AFTER `id`");
        $this->createIndex('idx_is_system_user_unique', '{{%user}}', ['is_system'], true);
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'phone_number' => $this->string(13)->null()->unique(),
            'email' => $this->string()->null()->unique(),
            'first_name' => $this->string()->null(),
            'last_name' => $this->string()->null(),
            'gender' => "ENUM('male','female','others') NULL",
            'dob' => $this->date()->null(),
            'address' => $this->string()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_profile_user','{{%profile}}', 'user_id', '{{%user}}','id','RESTRICT', 'CASCADE');
        $this->createTable('{{%auth_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->smallInteger()->notNull(),
            'token' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);
        $this->createIndex('idx_auth_token_token', '{{%auth_token}}', 'token');
        $this->addForeignKey('fk_auth_token_user','{{%auth_token}}', 'user_id', '{{%user}}','id','RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200211_170551_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200211_170551_init cannot be reverted.\n";

        return false;
    }
    */
}

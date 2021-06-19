<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232251_user extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%user}}',
            [
                'id'=> $this->primaryKey(11),
                'username'=> $this->string(255)->notNull(),
                'email'=> $this->string(255)->notNull(),
                'password_hash'=> $this->string(60)->notNull(),
                'auth_key'=> $this->string(32)->notNull(),
                'unconfirmed_email'=> $this->string(255)->notNull(),
                'registration_ip'=> $this->string(45)->null()->defaultValue(null),
                'flags'=> $this->integer(11)->notNull()->defaultValue(0),
                'confirmed_at'=> $this->integer(11)->notNull(),
                'blocked_at'=> $this->integer(11)->notNull(),
                'updated_at'=> $this->integer(11)->notNull(),
                'created_at'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('username','{{%user}}',['username'],true);
        $this->createIndex('email','{{%user}}',['email'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('username', '{{%user}}');
        $this->dropIndex('email', '{{%user}}');
        $this->dropTable('{{%user}}');
    }
}

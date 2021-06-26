<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232245_user extends Migration
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
                'unconfirmed_email'=> $this->string(255)->null()->defaultValue(null),
                'registration_ip'=> $this->string(45)->null()->defaultValue(null),
                'flags'=> $this->integer(11)->notNull()->defaultValue(0),
                'confirmed_at'=> $this->integer(11)->null()->defaultValue(null),
                'blocked_at'=> $this->integer(11)->null()->defaultValue(null),
                'updated_at'=> $this->integer(11)->notNull(),
                'created_at'=> $this->integer(11)->notNull(),
                'last_login_at'=> $this->integer(11)->null()->defaultValue(null),
                'last_login_ip'=> $this->string(45)->null()->defaultValue(null),
                'auth_tf_key'=> $this->string(16)->null()->defaultValue(null),
                'auth_tf_enabled'=> $this->tinyInteger(1)->null()->defaultValue(0),
                'password_changed_at'=> $this->integer(11)->null()->defaultValue(null),
                'gdpr_consent'=> $this->tinyInteger(1)->null()->defaultValue(0),
                'gdpr_consent_date'=> $this->integer(11)->null()->defaultValue(null),
                'gdpr_deleted'=> $this->tinyInteger(1)->null()->defaultValue(0),
            ],$tableOptions
        );
        $this->createIndex('idx_user_username','{{%user}}',['username'],true);
        $this->createIndex('idx_user_email','{{%user}}',['email'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('idx_user_username', '{{%user}}');
        $this->dropIndex('idx_user_email', '{{%user}}');
        $this->dropTable('{{%user}}');
    }
}

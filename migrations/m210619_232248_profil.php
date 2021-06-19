<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232248_profil extends Migration
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
            '{{%profil}}',
            [
                'user_id'=> $this->integer(11)->notNull(),
                'name'=> $this->string(255)->notNull(),
                'public_email'=> $this->string(255)->notNull(),
                'gravatar_email'=> $this->string(255)->notNull(),
                'gravatar_id'=> $this->string(32)->notNull(),
                'location'=> $this->string(255)->notNull(),
                'website'=> $this->string(255)->notNull(),
                'timezone'=> $this->string(40)->notNull(),
                'bio'=> $this->text()->notNull(),
            ],$tableOptions
        );
        $this->createIndex('profil_fk0','{{%profil}}',['user_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('profil_fk0', '{{%profil}}');
        $this->dropTable('{{%profil}}');
    }
}

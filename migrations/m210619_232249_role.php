<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232249_role extends Migration
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
            '{{%role}}',
            [
                'id'=> $this->primaryKey(11),
                'role_name'=> $this->string(255)->notNull(),
                'user_id'=> $this->integer(11)->notNull(),
                
            ],$tableOptions
        );
        $this->createIndex('role_fk0','{{%role}}',['user_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('role_fk0', '{{%role}}');
        $this->dropTable('{{%role}}');
    }
}

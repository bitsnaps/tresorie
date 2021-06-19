<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232247_grade extends Migration
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
            '{{%grade}}',
            [
                'user_id'=> $this->integer(11)->notNull(),
                'role_id'=> $this->integer(11)->notNull(),
                'niveau'=> $this->string(255)->notNull(),
                'montant'=> $this->decimal(10)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('grade_fk0','{{%grade}}',['user_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('grade_fk0', '{{%grade}}');
        $this->dropTable('{{%grade}}');
    }
}

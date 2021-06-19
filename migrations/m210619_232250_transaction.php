<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232250_transaction extends Migration
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
            '{{%transaction}}',
            [
                'id'=> $this->primaryKey(11),
                'date_transaction'=> $this->datetime()->notNull(),
                'montant'=> $this->decimal(10)->notNull(),
                'decaissment_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('transaction_fk0','{{%transaction}}',['decaissment_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('transaction_fk0', '{{%transaction}}');
        $this->dropTable('{{%transaction}}');
    }
}

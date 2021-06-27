<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232246_decaissement extends Migration
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
            '{{%decaissement}}',
            [
                'id'=> $this->primaryKey(11),
                'date_demande'=> $this->datetime()->notNull(),
                'montant'=> $this->decimal(10)->notNull(),
                'motif'=> $this->string(255)->notNull(),
                'piece_jointe'=> $this->string(255)->notNull(),
                'status_user'=> $this->integer(11)->notNull()->defaultValue(0),
                'status_admin'=> $this->integer(11)->notNull()->defaultValue(0),
                'user_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->addForeignKey('fk_decaissement_user_id',
        '{{%decaissement}}','user_id',
        '{{%user}}','id',
        'CASCADE','CASCADE'
     );
        $this->createIndex('date_demande','{{%decaissement}}',['date_demande'],true);
        $this->createIndex('decaissement_fk0','{{%decaissement}}',['user_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('date_demande', '{{%decaissement}}');
        $this->dropIndex('decaissement_fk0', '{{%decaissement}}');
        $this->dropTable('{{%decaissement}}');
    }
}

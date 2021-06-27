<?php

use yii\db\Schema;
use yii\db\Migration;

class m210619_232252_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk1_decaissement_user_id',
            '{{%decaissement}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk1_grade_user_id',
            '{{%grade}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk1_profil_user_id',
            '{{%profil}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk1_role_user_id',
            '{{%role}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_transaction_decaissment_id',
            '{{%transaction}}','decaissment_id',
            '{{%decaissement}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk1_decaissement_user_id', '{{%decaissement}}');
        $this->dropForeignKey('fk1_grade_user_id', '{{%grade}}');
        $this->dropForeignKey('fk1_profil_user_id', '{{%profil}}');
        $this->dropForeignKey('fk1_role_user_id', '{{%role}}');
        $this->dropForeignKey('fk1_transaction_decaissment_id', '{{%transaction}}');
    }
}

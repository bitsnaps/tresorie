<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%decaissementhistorique}}`.
 */
class m210625_041029_create_decaissementhistorique_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';
        $this->createTable('{{%decaissementhistorique}}', [
            'id' => $this->primaryKey(),
            'date_demande'=> $this->datetime()->notNull(),
            'montant'=> $this->decimal(10)->notNull(),
            'motif'=> $this->string(255)->notNull(),
            'piece_jointe'=> $this->string(255)->notNull(),
            'status_user'=> $this->integer(11)->notNull()->defaultValue(0),
            'status_admin'=> $this->integer(11)->notNull()->defaultValue(0),
            'user_id'=> $this->integer(11)->notNull(),
             'user_id'=> $this->integer(11)->notNull(),
        ],$tableOptions
    );
            $this->addForeignKey('fk_decaissementhistorique_user_id',
            '{{%decaissementhistorique}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
            $this->createIndex('date_demande','{{%decaissementhistorique}}',['date_demande'],true);
    
        }
    
        public function safeDown()
        {
            $this->dropIndex('date_demande', '{{%decaissementhistorique}}');
            $this->dropIndex('decaissementhistorique_fk0', '{{%decaissementhistorique}}');
            $this->dropTable('{{%decaissementhistorique}}');
        }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notification}}`.
 */

class m210625_041029_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // notifications
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string(64)->notNull(),
            'key' => $this->string(32)->notNull(),
            'message' => $this->string(255)->notNull(),
            'route' => $this->string(255)->notNull(),
            'seen' => $this->boolean()->notNull()->defaultValue(false),
            'read' => $this->boolean()->notNull()->defaultValue(false),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'decaissementhistorique_id'=> $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('fk_notifications_decaissementhistorique_id',
        '{{%notifications}}','decaissementhistorique_id',
        '{{%decaissementhistorique}}','id',
        'CASCADE','CASCADE'
     );
        $this->createIndex('index_2', '{{%notifications}}', ['user_id']);
        $this->createIndex('index_3', '{{%notifications}}', ['created_at']);
        $this->createIndex('index_4', '{{%notifications}}', ['seen']);

    }

    /**
     * Drop table `notifications`
     */
    public function down()
    {
        $this->dropTable('{{%notifications}}');
    }
}

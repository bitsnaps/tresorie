<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction}}`.
 */
class m210704_144737_add_approved_by_column_to_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction}}', 'approved_by', $this->integer());
        $this->addForeignKey('fk_approved_by_id_user_id',
        '{{%transaction}}','approved_by',
        '{{%user}}','id',
        'RESTRICT','RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction}}', 'approved_by');
        $this->dropForeignKey( 'fk_approved_by_id_user_id', '{{%transaction}}' );
    }
}

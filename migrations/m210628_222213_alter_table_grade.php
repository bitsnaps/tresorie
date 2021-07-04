<?php

use yii\db\Migration;

/**
 * Class m210628_222213_alter_table_grade
 */
class m210628_222213_alter_table_grade extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        $this->addForeignKey('fk5_role_id_assignement_id',
        '{{%grade}}','role_id',
        '{{%role}}','id',
        'CASCADE','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210628_222213_alter_table_grade cannot be reverted.\n";
        // TODO: check if this works
        //$this->dropForeignKey( 'fk5_role_id_assignement_id', '{{%grade}}' );
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210628_222213_alter_table_grade cannot be reverted.\n";

        return false;
    }
    */
}

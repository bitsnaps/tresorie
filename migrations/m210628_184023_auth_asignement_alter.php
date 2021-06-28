<?php

use yii\db\Migration;

/**
 * Class m210628_184023_auth_asignement_alter
 */
class m210628_184023_auth_asignement_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('auth_assignment', 'user_id', $this->integer());
        $this->addForeignKey('fk_user_id_auth_assignement_id',
        '{{%auth_assignment}}','user_id',
        '{{%user}}','id',
        'CASCADE','CASCADE'
     );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210628_184023_auth_asignement_alter cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210628_184023_auth_asignement_alter cannot be reverted.\n";

        return false;
    }
    */
}

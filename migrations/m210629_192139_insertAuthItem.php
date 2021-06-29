<?php

use yii\db\Migration;

/**
 * Class m210629_192139_insertAuthItem
 */
class m210629_192139_insertAuthItem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('auth_item', [
            'name' => 'admin',
            'type' => '1',
        ]);
        $this->insert('auth_item', [
            'name' => 'Aprobateur',
            'type' => '1',
        ]);
        $this->insert('auth_item', [
            'name' => 'responsableDeStation',
            'type' => '1',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210629_192139_insertAuthItem cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210629_192139_insertAuthItem cannot be reverted.\n";

        return false;
    }
    */
}

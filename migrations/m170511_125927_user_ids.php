<?php

use yii\db\Migration;

class m170511_125927_user_ids extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'brombat_id', $this->string()->defaultValue(''));
        $this->addColumn('user', 'exaloc_id', $this->string()->defaultValue(''));

    }

    public function down()
    {
        echo "m170511_125927_user_ids cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

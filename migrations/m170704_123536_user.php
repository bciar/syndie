<?php

use yii\db\Migration;

class m170704_123536_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'dob', $this->date());
        $this->addColumn('user', 'address', $this->string()->defaultValue(''));
    }

    public function down()
    {
        echo "m170704_123536_user cannot be reverted.\n";

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

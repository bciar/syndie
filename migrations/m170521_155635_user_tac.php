<?php

use yii\db\Migration;

class m170521_155635_user_tac extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'tac', $this->boolean()->defaultValue(0));
    }

    public function down()
    {
        echo "m170521_155635_user_tac cannot be reverted.\n";

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

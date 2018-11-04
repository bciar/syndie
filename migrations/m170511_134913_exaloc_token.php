<?php

use yii\db\Migration;

class m170511_134913_exaloc_token extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'exaloc_token', $this->string());
    }

    public function down()
    {
        echo "m170511_134913_exaloc_token cannot be reverted.\n";

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

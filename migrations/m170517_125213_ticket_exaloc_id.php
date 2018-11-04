<?php

use yii\db\Migration;

class m170517_125213_ticket_exaloc_id extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'exaloc_id', $this->string());
    }

    public function down()
    {
        $this->dropColumn('ticket', 'exaloc_id');
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

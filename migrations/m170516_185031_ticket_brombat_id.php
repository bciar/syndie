<?php

use yii\db\Migration;

class m170516_185031_ticket_brombat_id extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'brombat_id', $this->string());
    }

    public function down()
    {
        $this->dropColumn('ticket', 'brombat_id');
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

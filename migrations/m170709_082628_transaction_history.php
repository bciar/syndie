<?php

use yii\db\Migration;

class m170709_082628_transaction_history extends Migration
{
    public function up()
    {
        $this->addColumn('transaction_history', 'status', $this->integer());
        $this->addColumn('transaction_history' , 'reference', $this->string());
        $this->addColumn('transaction_history' , 'type', $this->string());
    }

    public function down()
    {
        $this->dropColumn('transaction_history', 'status');
        $this->dropColumn('transaction_history', 'reference');
        $this->dropColumn('transaction_history', 'type');
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

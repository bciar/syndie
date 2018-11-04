<?php

use yii\db\Migration;

class m170515_134454_draw2 extends Migration
{
    public function up()
    {
        $this->addColumn('draw', 'rollover', $this->integer());
    }

    public function down()
    {
        echo "m170515_134454_draw2 cannot be reverted.\n";

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

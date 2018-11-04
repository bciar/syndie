<?php

use yii\db\Migration;

class m170518_145229_syndicate extends Migration
{
    public function up()
    {
        $this->addColumn('syndicate', 'privacy_code', $this->string());
    }

    public function down()
    {
        $this->dropColumn('syndicate', 'privacy_code');
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

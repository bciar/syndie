<?php

use yii\db\Migration;

class m170513_192123_user extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'is_affiliate');
        $this->dropColumn('user', 'is_sponsor');
        $this->addColumn('user', 'type', $this->string()->defaultValue('user'));
    }

    public function down()
    {
        $this->addColumn('user', 'is_affiliate', $this->string());
        $this->addColumn('user', 'is_sponsor', $this->string());
        $this->dropColumn('user', 'type');
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

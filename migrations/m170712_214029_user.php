<?php

use yii\db\Migration;

class m170712_214029_user extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'address');
        $this->addColumn('user', 'address1', $this->string());
        $this->addColumn('user', 'address2', $this->string());
        $this->addColumn('user', 'address3', $this->string());
        $this->addColumn('user', 'city', $this->string());
        $this->addColumn('user', 'postcode', $this->string());
    }

    public function down()
    {
        echo "m170712_214029_user cannot be reverted.\n";

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

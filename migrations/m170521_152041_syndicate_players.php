<?php

use yii\db\Migration;

class m170521_152041_syndicate_players extends Migration
{
    public function up()
    {
        $this->addColumn('syndicate', 'players', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('syndicate', 'players');
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

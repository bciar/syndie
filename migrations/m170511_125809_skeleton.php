<?php

use yii\db\Migration;

class m170511_125809_skeleton extends Migration
{
    public function up()
    {
        $sql = file_get_contents(Yii::getAlias('@app/skeleton.sql'));
        $this->execute($sql);
    }

    public function down()
    {
        echo "m170511_125809_skeleton cannot be reverted.\n";

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

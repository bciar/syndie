<?php

use yii\db\Migration;

class m170511_145729_draw extends Migration
{
    public function up()
    {
        //$this->addColumn('draw', 'period', $this->string());
        $this->addColumn('game', 'lottery_id', $this->string());
        $this->addColumn('draw', 'prize_date', $this->string());
        $this->dropColumn('draw', 'draw_date');
        $this->addColumn('draw', 'draw_date', $this->dateTime());
    }

    public function down()
    {
        //$this->addColumn('draw', 'draw_date', $this->date());
        //$this->dropColumn('draw', 'draw_time');
        //$this->dropColumn('draw', 'period');
        $this->dropColumn('game', 'lottery_id');
        $this->dropColumn('draw', 'prize_date');
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

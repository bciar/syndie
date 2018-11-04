<?php

use yii\db\Migration;

class m170518_125059_brand extends Migration
{
    public function up()
    {
        $this->execute(<<<SQL
CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head_back_colour` varchar(10) DEFAULT NULL,
  `head_fore_colour` varchar(10) DEFAULT NULL,
  `head_logo_path` varchar(100) DEFAULT NULL,
  `head_back_img_path` varchar(100) DEFAULT NULL,
  `main_back_colour` varchar(10) DEFAULT NULL,
  `main_fore_colour` varchar(10) DEFAULT NULL,
  `main_back_img_path` varchar(100) DEFAULT NULL,
  `share_logo_path` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `slogan` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_user_idx` (`user_id`),
  CONSTRAINT `fk_brand_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
SQL
        );
    }

    public function down()
    {
        $this->dropTable('brand');
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

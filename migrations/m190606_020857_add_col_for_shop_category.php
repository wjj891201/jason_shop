<?php

use yii\db\Migration;

class m190606_020857_add_col_for_shop_category extends Migration
{

    public function up()
    {
        $this->addColumn('{{%category}}', 'adminid', $this->integer(10)->notNull());
    }

    public function down()
    {
        echo "m190606_020857_add_col_for_shop_category cannot be reverted.\n";

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

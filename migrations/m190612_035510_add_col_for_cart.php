<?php

use yii\db\Migration;

/**
 * Class m190612_035510_add_col_for_cart
 */
class m190612_035510_add_col_for_cart extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cart}}', 'updatetime', $this->integer(10)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190612_035510_add_col_for_cart cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190612_035510_add_col_for_cart cannot be reverted.\n";

      return false;
      }
     */
}

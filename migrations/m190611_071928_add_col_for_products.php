<?php

use yii\db\Migration;

/**
 * Class m190611_071928_add_col_for_products
 */
class m190611_071928_add_col_for_products extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'updatetime', $this->integer(10)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_071928_add_col_for_products cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190611_071928_add_col_for_products cannot be reverted.\n";

      return false;
      }
     */
}

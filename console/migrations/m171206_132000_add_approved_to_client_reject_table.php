<?php

use yii\db\Migration;

class m171206_132000_add_approved_to_client_reject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('client_reject', 'approved', $this->boolean()->notNull()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('client_reject', 'approved');
    }
}

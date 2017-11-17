<?php

use yii\db\Migration;

class m171116_172500_rename_update_column_to_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->renameColumn('client_copy', 'update', 'updated_at');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameColumn('client_copy', 'updated_at', 'update');
    }
}

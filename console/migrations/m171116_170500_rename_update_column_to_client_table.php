<?php

use yii\db\Migration;

class m171116_170500_rename_update_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->renameColumn('{{%client}}', 'update', 'updated_at');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameColumn('{{%client}}', 'updated_at', 'update');
    }
}

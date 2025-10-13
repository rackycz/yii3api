<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

/**
 * Class M251013160000CreateUserTokenTable
 */
final class M251013160000CreateUserTokenTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('user_token', [
            'id' => $b->primaryKey(),
            'id_user' => $b->integer()->notNull(),
            'token' => $b->string()->notNull()->unique(),
            'expires_at' => $b->dateTime()->notNull(),
            'created_by' => $b->integer(),
            'updated_by' => $b->integer(),
            'deleted_by' => $b->integer(),
            'created_at' => $b->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $b->dateTime(),
            'deleted_at' => $b->dateTime(),
        ]);

        $b->addForeignKey('user_token', 'fk_usertoken_created_by', 'created_by', 'user', 'id');
        $b->addForeignKey('user_token', 'fk_usertoken_updated_by', 'updated_by', 'user', 'id');
        $b->addForeignKey('user_token', 'fk_usertoken_deleted_by', 'deleted_by', 'user', 'id');
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('user_token');
    }
}

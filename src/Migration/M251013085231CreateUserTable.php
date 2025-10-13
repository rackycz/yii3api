<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Migration\TransactionalMigrationInterface;

/**
 * Handles the creation of table `user`.
 */
final class M251013085231CreateUserTable implements RevertibleMigrationInterface, TransactionalMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('user', [
            'id' => $b->primaryKey(),
            'name' => $b->string()->notNull(),
            'surname' => $b->string()->notNull(),
            'username' => $b->string(),
            'phone' => $b->string(),
            'email' => $b->string()->notNull()->unique(),
            'email_verified_at' => $b->dateTime(),
            'pwd_default' => $b->string(),
            'pwd_hash' => $b->string(),
            'status' => $b->integer()->notNull()->defaultValue(100),
            'created_by' => $b->integer(),
            'updated_by' => $b->integer(),
            'deleted_by' => $b->integer(),
            'created_at' => $b->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $b->dateTime(),
            'deleted_at' => $b->dateTime(),
        ]);

        $b->addForeignKey('user', 'fk_user_created_by', 'created_by', 'user', 'id');
        $b->addForeignKey('user', 'fk_user_updated_by', 'updated_by', 'user', 'id');
        $b->addForeignKey('user', 'fk_user_deleted_by', 'deleted_by', 'user', 'id');
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('user');
    }
}

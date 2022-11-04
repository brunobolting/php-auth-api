<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableUsers extends AbstractMigration
{
    public function up(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id TEXT PRIMARY KEY NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            nickname TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME
        );";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `users`";

        $this->execute($sql);
    }
}

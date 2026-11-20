
<?php
declare(strict_types=1);

/**
 * RACO Management Portal
 * Database migration runner.
 *
 * Run from the command line only.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Forbidden.\n");
}

require_once dirname(__DIR__) . '/app/bootstrap.php';
require_once dirname(__DIR__) . '/app/Database/Connection.php';

use Raco\Portal\Database\Connection;

try {
    $pdo = Connection::get();

    // Create the migration tracking table.
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS schema_migrations (
            id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            batch INTEGER NOT NULL,
            executed_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $migrationDirectory = __DIR__ . '/migrations';

    $files = glob($migrationDirectory . '/[0-9]*.sql');

    if ($files === false) {
        throw new RuntimeException(
            'Could not read migration directory.'
        );
    }

    sort($files, SORT_STRING);

    $completed = $pdo->query(
        "SELECT migration FROM schema_migrations"
    )->fetchAll(PDO::FETCH_COLUMN);

    $completed = array_flip($completed);

    $batch = (int) $pdo->query(
        "SELECT COALESCE(MAX(batch), 0) + 1 FROM schema_migrations"
    )->fetchColumn();

    $executed = 0;

    foreach ($files as $file) {
        $name = basename($file);

        if (isset($completed[$name])) {
            echo "SKIPPED: {$name}\n";
            continue;
        }

        $sql = file_get_contents($file);

        if ($sql === false || trim($sql) === '') {
            throw new RuntimeException(
                "Migration is empty or unreadable: {$name}"
            );
        }

        echo "RUNNING: {$name}\n";

        $pdo->beginTransaction();

        try {
            $pdo->exec($sql);

            $statement = $pdo->prepare("
                INSERT INTO schema_migrations (migration, batch)
                VALUES (:migration, :batch)
            ");

            $statement->execute([
                'migration' => $name,
                'batch' => $batch
            ]);

            $pdo->commit();

            echo "SUCCESS: {$name}\n";

            $executed++;

        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw $exception;
        }
    }

    echo "\nMigration process completed.\n";
    echo "New migrations executed: {$executed}\n";

} catch (Throwable $exception) {
    fwrite(
        STDERR,
        "Migration failed: " . $exception->getMessage() . "\n"
    );

    exit(1);
}

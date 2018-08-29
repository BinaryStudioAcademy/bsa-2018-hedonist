<?php

namespace Hedonist\Services;

use Illuminate\Database\DatabaseManager;

class TransactionService implements TransactionServiceInterface
{
    protected $dbManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->dbManager = $databaseManager;
    }

    protected function start()
    {
        $this->dbManager->connection()->beginTransaction();
    }

    protected function commit()
    {
        $this->dbManager->connection()->commit();
    }

    protected function rollback()
    {
        $this->dbManager->connection()->rollBack();
    }

    public function run(\Closure $closure)
    {
        $this->start();

        try {
            $data = $closure();
        } catch (\Exception $e) {
            $this->rollback();
            throw $e;
        }

        $this->commit();

        return $data;
    }
}
<?php

namespace App\Repositories;

use PDO;

abstract class BaseRepository
{
    protected PDO $db;

    protected string $table;

    protected string $primaryKey = 'id';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Execute INSERT / UPDATE / DELETE
     */
    protected function execute(
        string $sql,
        array $params = []
    ): bool {

        $stmt = $this->db->prepare($sql);

        $this->bindValues($stmt, $params);

        return $stmt->execute();
    }

    /**
     * Fetch all rows
     */
    protected function fetchAll(
        string $sql,
        array $params = []
    ): array {

        $stmt = $this->db->prepare($sql);

        $this->bindValues($stmt, $params);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch single row
     */
    protected function fetchOne(
        string $sql,
        array $params = []
    ): ?array {

        $stmt = $this->db->prepare($sql);

        $this->bindValues($stmt, $params);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * Fetch count
     */
    protected function fetchCount(
        string $sql,
        array $params = []
    ): int {

        $stmt = $this->db->prepare($sql);

        $this->bindValues($stmt, $params);

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * DRY parameter binding (IMPROVED)
     */
    protected function bindValues($stmt, array $params): void
    {
        foreach ($params as $key => $value) {

            if (is_int($key)) {
                $paramKey = $key + 1; // positional SQL
            } else {
                $paramKey = ':' . $key; // named SQL
            }

            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                $value === null => PDO::PARAM_NULL,
                default => PDO::PARAM_STR
            };

            $stmt->bindValue($paramKey, $value, $type);
        }
    }

    /**
     * Pagination helper
     */
    protected function buildLimitOffset(
        ?int $limit,
        int $offset
    ): string {

        if ($limit === null) {
            return '';
        }

        return " LIMIT {$limit} OFFSET {$offset} ";
    }

    /**
     * Transaction helper (VERY USEFUL)
     */
    protected function transaction(callable $callback)
    {
        try {
            $this->db->beginTransaction();

            $result = $callback($this);

            $this->db->commit();

            return $result;

        } catch (\Throwable $e) {

            $this->db->rollBack();

            throw $e;
        }
    }
}
<?php

/**
 * Base Model — lightweight PDO query builder
 * Coffee Export B2B
 */

namespace App\Models;

use Core\Database;
use PDO;
use PDOStatement;

abstract class Model
{
    protected static string $table  = '';
    protected static string $pk     = 'id';
    protected PDO           $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // ─── Finder Methods ───────────────────────────────────────────────

    /**
     * Find a single record by primary key.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM ' . static::$table . ' WHERE ' . static::$pk . ' = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Return all rows from the table.
     */
    public function all(string $orderBy = 'id ASC'): array
    {
        $stmt = $this->db->query('SELECT * FROM ' . static::$table . ' ORDER BY ' . $orderBy);
        return $stmt->fetchAll();
    }

    /**
     * Find records matching a WHERE clause.
     *
     * @param array  $conditions ['column' => value, ...]
     */
    public function where(array $conditions, string $orderBy = 'id ASC', int $limit = 0): array
    {
        $clauses    = [];
        $bindings   = [];

        foreach ($conditions as $col => $val) {
            $clauses[]  = "`{$col}` = ?";
            $bindings[] = $val;
        }

        $sql = 'SELECT * FROM ' . static::$table
             . ' WHERE ' . implode(' AND ', $clauses)
             . ' ORDER BY ' . $orderBy;

        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }

    /**
     * Get a single record matching conditions.
     */
    public function first(array $conditions): ?array
    {
        $rows = $this->where($conditions, 'id ASC', 1);
        return $rows[0] ?? null;
    }

    // ─── Write Methods ────────────────────────────────────────────────

    /**
     * Insert a new record. Returns the new record's ID.
     */
    public function create(array $data): int
    {
        $cols = implode(', ', array_map(fn($c) => "`{$c}`", array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->db->prepare(
            "INSERT INTO " . static::$table . " ({$cols}) VALUES ({$placeholders})"
        );
        $stmt->execute(array_values($data));
        return (int) $this->db->lastInsertId();
    }

    /**
     * Update a record by PK.
     */
    public function update(int $id, array $data): bool
    {
        $sets = implode(', ', array_map(fn($c) => "`{$c}` = ?", array_keys($data)));
        $stmt = $this->db->prepare(
            "UPDATE " . static::$table . " SET {$sets} WHERE " . static::$pk . " = ?"
        );
        return $stmt->execute([...array_values($data), $id]);
    }

    /**
     * Delete a record by PK.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM " . static::$table . " WHERE " . static::$pk . " = ?"
        );
        return $stmt->execute([$id]);
    }

    /**
     * Count records with optional conditions.
     */
    public function count(array $conditions = []): int
    {
        if (empty($conditions)) {
            $stmt = $this->db->query("SELECT COUNT(*) FROM " . static::$table);
            return (int) $stmt->fetchColumn();
        }

        $clauses  = [];
        $bindings = [];
        foreach ($conditions as $col => $val) {
            $clauses[]  = "`{$col}` = ?";
            $bindings[] = $val;
        }

        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM " . static::$table
            . " WHERE " . implode(' AND ', $clauses)
        );
        $stmt->execute($bindings);
        return (int) $stmt->fetchColumn();
    }
}

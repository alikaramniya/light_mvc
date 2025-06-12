<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    private string $table = 'users';

    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id");

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {
            return $user;
        }

        return null;
    }

    public function exists(array $field): bool
    {
        $key = array_key_first($field);

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $key=:$key");

        $stmt->bindParam(":$key", $field[$key]);

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {
            return true;
        }

        return false;
    }

    public function insert(array $data)
    {
        $stmt = $this->db->prepare(
            <<<SQL
                INSERT INTO {$this->table}(name, email, password) VALUES (:name, :email, :password)
                SQL
        );

        $result = $stmt->execute([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
        ]);

        if ($result) {
            $stmt = $this->db->query('SELECT LAST_INSERT_ID() as id FROM ' . $this->table);

            return $stmt->fetch()->id;
        }
    }

    public function findColumn(string $column, mixed $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $column=:$column");

        $stmt->bindParam(":$column", $value);

        $stmt->execute();

        return $stmt->fetch();
    }
}

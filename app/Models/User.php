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
}

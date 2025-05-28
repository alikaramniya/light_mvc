<?php

declare(strict_types=1);

namespace App\Core;

abstract class Model
{
    protected DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
}

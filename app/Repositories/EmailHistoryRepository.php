<?php

namespace App\Repositories;

use App\Models\EmailHistory;

class EmailHistoryRepository
{
    public function create(array $data)
    {
        return EmailHistory::create($data);
    }
}

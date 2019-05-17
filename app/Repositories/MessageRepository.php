<?php
namespace App\Repositories;
use App\Models\Message;
class MessageRepository
{
    public function create($data)
    {
        return Message::create($data);
    }

    public function count()
    {
        return Message::count();
    }
}
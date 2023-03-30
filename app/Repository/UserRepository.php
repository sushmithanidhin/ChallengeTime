<?php

namespace App\Repository;

use App\Models\User;

class UserRepository implements BaseInterface
{
    public function fetchAll()
    {
        return User::all();
    }

    public function fetchById($identifier)
    {
        return User::find($identifier);
    }

    public function delete($identifier)
    {
        //TODO
    }

    public function firstOrCreate(array $data)
    {
        return User::firstOrCreate($data);
    }

    public function update($identifier, array $data)
    {
        //TODO
    }
}

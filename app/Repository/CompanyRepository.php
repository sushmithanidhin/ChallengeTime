<?php

namespace App\Repository;

use App\Models\Company;

class CompanyRepository implements BaseInterface
{
    public function fetchAll()
    {
        return Company::all();
    }

    public function fetchById($identifier)
    {
        return Company::find($identifier);
    }

    public function delete($identifier)
    {
        //TODO
    }

    public function firstOrCreate(array $data)
    {
        return Company::firstOrCreate($data);
    }

    public function update($identifier, array $data)
    {
        //TODO
    }
}

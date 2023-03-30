<?php

namespace App\Repository;

interface BaseInterface
{
    public function fetchAll();
    public function fetchById($identifier);
    public function delete($identifier);
    public function firstOrCreate(array $data);
    public function update($identifier, array $data);
}

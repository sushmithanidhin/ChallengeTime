<?php

<?php

namespace App\Repository;

interface BaseRepoInterface
{
    public function getAllUsers();
    public function getUserById($taskId);
    public function deleteUser($taskId);
    public function findOrCreate(array $taskDetails);
    public function updateUser($taskId, array $newDetails);
}
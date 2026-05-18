<?php

namespace App\Repositories\Contracts;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator;
    public function find(int $id): ?Task;
    public function create(array $data): Task;
    public function update(int $id, array $data): Task;
    public function delete(int $id): bool;
    public function updateAi(int $id, array $data): Task;
    public function analytics(array $filters = []): array;
    public function monthlyCompletion(array $filters = []): array;
}

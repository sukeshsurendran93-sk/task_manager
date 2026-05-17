<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(array $filters = [])
    {
        return Task::query()->with('user')->filter($filters)->paginate(10);
    }

    public function find(int $id)
    {
        return Task::with(['user', 'createdBy'])->find($id);
    }

    public function create(array $data) 
    {
        return Task::create($data);
    }

    public function update(array $data, int $id)
    {
        return Task::find($id)->update($data);
    }

    public function delete(int $id)
    {
        return Task::destroy($id);
    }

    public function updateAi(int $id, array $data)
    {
        return Task::find($id)->update($data);
    }
}

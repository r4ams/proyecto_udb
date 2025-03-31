<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
  public function view(User $user, Task $task)
  {
    return $user->id === $task->project->user_id;
  }

  public function update(User $user, Task $task)
  {
    return $user->id === $task->project->user_id;
  }

  public function delete(User $user, Task $task)
  {
    return $user->id === $task->project->user_id;
  }
}

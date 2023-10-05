<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{
    protected $table = 'projects';

    public function tasks(){
        return $this->hasMany(Task::class, 'project_id');
    }
}

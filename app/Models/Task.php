<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{
    protected $table = 'task';

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id')->withDefault();
    }
}

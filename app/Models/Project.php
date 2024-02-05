<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $guarded = [];

    public static function createProject(array $data) // TODO: этот метод бесмысленный
    {

        return self::query()
            ->create($data);
    }


    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class, 'project_id');
    }
}

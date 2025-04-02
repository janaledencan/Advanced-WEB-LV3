<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'completed_jobs',
        'start_date',
        'end_date',
        'team_members'
    ];

    public function leader(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(){
        return $this->belongsToMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'project_id',
        'phase_id',
        'title',
        'description',
        'completed',
    ];

    /**
     * Relationship: Task belongs to a Project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship: Task belongs to a Phase (optional).
     */
    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
}

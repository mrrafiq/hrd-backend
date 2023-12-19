<?php

namespace App\Models\Position;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTitle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "job_titles";

    protected $fillable = [
        'name',
        'description',
        'department_id',
        'parents',
        'children',
        'is_active'
    ];

    public static function getPositions($id)
    {
        $job_title = JobTitle::find($id);
        $positions = (object)[];

        $parents = json_decode($job_title->parents);
        $get_parents = JobTitle::whereIn('id', $parents)->get();
        $positions->parents = $get_parents;

        $children = json_decode($job_title->children);
        $get_children = JobTitle::whereIn('id', $children)->get();
        $positions->children = $get_children;
        return $positions;
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

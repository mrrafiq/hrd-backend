<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Position\JobTitle;
use App\Models\User;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "employees";

    protected $fillable = [
        'user_id',
        'phone_number',
        'date_of_birth',
        'place_of_birth',
        'address',
        'job_title_id',
        'employee_number',
        'grade'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public static function GenerateEmployeeNumber()
    {
        $get_year = date('Y');
        $get_month = date('m');
        $count_employee = Employee::whereYear('created_at', $get_year)->whereMonth('created_at', $get_month)->withTrashed()->count();
        $count_employee++;
        $employee_number = $get_year . $get_month . sprintf("%03d", $count_employee);
        return $employee_number;
    }

    // get to know the parents and child employee
    public static function getParentsChildren($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return null;
        }

        $job_title = JobTitle::where('id', $employee->job_title_id)->first();
        if (!$job_title) {
            return null;
        }
        $get_parents = json_decode($job_title->parents ?? '[]');
        $get_children = json_decode($job_title->children ?? '[]');

        if ($get_children == null && $get_parents == null) {
            return null;
        }

        $parents = Employee::whereIn('job_title_id', $get_parents)->get();
        $children = Employee::whereIn('job_title_id', $get_children)->get();

        return (object) ['parents' => $parents, 'children' => $children];
        
    }

    public function job_title()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function givePermission()
    {
        $permissions = [
            'personal_data',
            'request_laave',
            'request_permission',
        ];

        try {
            $basic_employee = Employee::find('basic_employee');
            $basic_employee->givePermissionTo($permissions);
        } catch (\Throwable $th) {
            return false;
        }
        
        return true;
    }
}

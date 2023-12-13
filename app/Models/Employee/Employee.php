<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Position\JobTitle;

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
    public static function getPositions($id)
    {
        // $employee = Employee::find($id);
        
        // return $positions;
    }
}

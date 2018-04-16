<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public static function EmployeeList() {
        $employees = Employees::where('Employees.status', 1)
                    ->leftjoin('Roles', function ($join) {
                        $join->on('roles.id', '=', 'Employees.role_id')
                        ->where('roles.status', '1');
                    })
                    ->select('employees.*', 'roles.job_role')
                    ->orderBy('Employees.id', 'asc')->get();
        return($employees);
    }

    public static function EmployeeCount() {
        $employeeCount = Employees::where('status', 1)->count();
        return ($employeeCount);
    }

    public static function EmployeeRecord($id) {
        $employee = Employees::where('Employees.status', 1)
                    ->leftjoin('Roles', function ($join) {
                        $join->on('roles.id', '=', 'Employees.role_id')
                        ->where('roles.status', '1');
                    })
                    ->select('employees.*', 'roles.job_role')
                    ->where('employees.id', $id)
                    ->get();
        return($employee);
    }

    public static function EmployeeSave($request) {
        $employee = new Employees;
        $employee->firstname = $request->get('firstname');
        $employee->lastname = $request->get('lastname');
        $employee->email = $request->get('email');
        $employee->role_id = $request->get('role_id');
        $employee->status = 1;
        $employee->save();
    }

    public static function EmployeeUpdate($id, $request) {
        $employee = Employees::find($id);
        $employee->firstname = $request->get('firstname');
        $employee->lastname = $request->get('lastname');
        $employee->email = $request->get('email');
        $employee->role_id = $request->get('role_id');
        $employee->save();
    }

    public static function EmployeeDelete($id) {
        // don't delete just mark status 0
        $employee = Employees::find($id);
        $employee->status = 0;
        $employee->save();        
    }

    public static function EmployeeRemoveRole($role_id) {
        Employees::where('role_id', $role_id)
                    ->update(['role_id' => null]);
    }
}

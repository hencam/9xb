<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Roles extends Model
{
    public static function RoleRecord($id) {
        $role = Roles::where('Roles.status', 1)
                ->where('Roles.id', $id)
                ->get();
        return($role);
    }

    public static function RoleListWithCount() {
        // get all the available roles, and the number of employees assigned to them
        $roles = Roles::where('Roles.status', 1)
                ->leftjoin('Employees', function ($join) {
                    $join->on('Employees.role_id', '=', 'roles.id')
                    ->where('Employees.status', '=', '1');
                })
                ->select(DB::raw('Roles.*, COUNT(Employees.id) AS cnt'))
                ->groupBy('Roles.id')
                ->orderBy('job_role', 'asc')
                ->get();
        return($roles);
    }

    public static function RoleListWithCountExcept($id) {
        $roles = Roles::where('Roles.status', 1)
                ->leftjoin('Employees', function ($join) use ($id) {
                    $join->on('Employees.role_id', '=', 'roles.id')
                    ->where('Employees.status', '=', '1')
                    ->where('Employees.id', '<>', $id);
                })
                ->select(DB::raw('Roles.*, COUNT(Employees.id) AS cnt'))
                ->groupBy('Roles.id')
                ->orderBy('job_role', 'asc')
                ->get();
        return($roles);
    }

    public static function RoleSave($request) {
        // save changes
        $role = new Roles;
        $role->job_role = $request->get('job_role');
        $role->status = 1;
        $role->save();
    }

    public static function RoleUpdate($id, $request) {
        $role = Roles::find($id);
        $role->job_role = $request->get('job_role');
        $role->save();
    }

    public static function RoleDelete($id) {
        // don't delete just mark status 0
        $role = Roles::find($id);
        $role->status = 0;
        $role->save();        
    }
}

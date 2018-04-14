<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\Employees;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show the list (default view)
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
        return view('roleList')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // add a new role form
        return view('roleAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // save a new role
        $validatedData = $request->validate([
            'job_role' => 'required|max:255'
        ]);

        // save changes
        $role = new Roles;
        $role->job_role = $request->get('job_role');
        $role->status = 1;
        $role->save();
        return redirect('roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // show the edit form
        $roles = Roles::where('Roles.status', 1)
                ->where('Roles.id', $id)
                ->get();
        return view('roleEdit')->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // update a role
        $validatedData = $request->validate([
            'job_role' => 'required|max:255'
        ]);

        // save changes
        $role = Roles::find($id);
        $role->job_role = $request->get('job_role');
        $role->save();
        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // don't delete just mark status 0
        $role = Roles::find($id);
        $role->status = 0;
        $role->save();

        // now mark any employees with the deleted role back to 0 (no role)
        $employee = Employees::where('role_id', $id)
                    ->update(['role_id' => 0]);
        
        return redirect('roles');
    }
}

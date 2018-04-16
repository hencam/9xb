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
        $roles = Roles::RoleListWithCount();
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

        Roles::RoleSave($request);
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
        // there is nothing using this
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
        $roles = Roles::RoleRecord($id);
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
        Roles::RoleUpdate($id, $request);
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
        Roles::RoleDelete($id);

        // now mark any employees with the deleted role back to 0 (no role)
        Employees::EmployeeRemoveRole($id);
        
        return redirect('roles');
    }
}

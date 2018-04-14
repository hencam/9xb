<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employees;
use App\Roles;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list of all employees
        $employees = Employees::where('Employees.status', 1)
                    ->leftjoin('Roles', function ($join) {
                        $join->on('roles.id', '=', 'Employees.role_id')
                        ->where('roles.status', '1');
                    })
                    ->select('employees.*', 'roles.job_role')
                    ->orderBy('Employees.id', 'asc')->get();
        return view('employeeList')->with(array('employees' => $employees));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // I need the available roles for the select drop-down
        // I'm joining the Employees table so I can also count how many employees are assigned to each role
        // (as this is adding a NEW employee, I need to count ALL employees with each role)
        // - so I can disable options that already have 4 employees assigned
        $roles = Roles::where('Roles.status', 1)
                ->leftjoin('Employees', function ($join) {
                    $join->on('Employees.role_id', '=', 'roles.id')
                    ->where('Employees.status', '=', '1');
                })
                ->select(DB::raw('Roles.*, COUNT(Employees.id) AS cnt'))
                ->groupBy('Roles.id')
                ->orderBy('job_role', 'asc')
                ->get();
        return view('employeeAdd')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // save a new employee
        $validatedData = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|max:255'
        ]);

        // save changes
        $employee = new Employees;
        $employee->firstname = $request->get('firstname');
        $employee->lastname = $request->get('lastname');
        $employee->email = $request->get('email');
        $employee->role_id = $request->get('role_id');
        $employee->status = 1;
        $employee->save();
        return redirect('employees');
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
        // edit an employee
        // no join to the role table or ordering needed here as we're only ever going to edit 1 record at a time
        // so we'll save some processor time :)
        $employees = Employees::where('status', 1)
                    ->where('id', $id)
                    ->get();
        // I need the available roles for the select drop-down
        // I'm joining the Employees table so I can also count how many employees are assigned to each role
        // (not counting the current employee id) - so I can disable options that already have 4 employees assigned
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
        return view('employeeEdit')->with(array('employees' => $employees, 'roles' => $roles));
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
        $validatedData = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|max:255'
        ]);

        // save changes
        $employee = Employees::find($id);
        $employee->firstname = $request->get('firstname');
        $employee->lastname = $request->get('lastname');
        $employee->email = $request->get('email');
        $employee->role_id = $request->get('role_id');
        $employee->save();
        return redirect('employees');
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
        $employee = Employees::find($id);
        $employee->status = 0;
        $employee->save();
        return redirect('employees');
    }
}

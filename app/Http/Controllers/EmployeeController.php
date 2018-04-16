<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Elequent\Model;
use App\Employees;
use App\Roles;

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
        $employees = Employees::EmployeeList();
        return view('employeeList')->with(array('employees' => $employees));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // I need the available roles for the select drop-down
        // I'm joining the Employees table so I can also count how many employees are assigned to each role
        // (as this is adding a NEW employee, I need to count ALL employees with each role)
        // - so I can disable options that already have 4 employees assigned
        $roles = Roles::RoleListWithCount();
        return view('employeeAdd')->with(array('roles' => $roles, 'request' => $request));
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
            'email' => 'required|email|max:255'
        ]);

        // make sure nothing sneaky is been attempted - ie: user goes to create url manually
        $employee_count = Employees::EmployeeCount();
        if ($employee_count >= \Config::get('constants.max_employees')) {
            return redirect('employees/create')
                    ->withErrors('Sorry, you cannot add any further employees.  Delete an existing one first.')
                    ->withInput();
        }

        // save changes
        Employees::EmployeeSave($request);
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
        // show an employee's record
        $employee = Employees::EmployeeRecord($id);
        return view('employeeRead')->with(array('employee' => $employee));
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
        $employees = Employees::EmployeeRecord($id);

        // I need the available roles for the select drop-down
        // I'm joining the Employees table so I can also count how many employees are assigned to each role
        // (not counting the current employee id) - so I can disable options that already have 4 employees assigned
        $roles = Roles::RoleListWithCountExcept($id);
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
            'email' => 'required|email|max:255'
        ]);

        // save changes
        Employees::EmployeeUpdate($id, $request);
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
        Employees::EmployeeDelete($id);
        return redirect('employees');
    }
}

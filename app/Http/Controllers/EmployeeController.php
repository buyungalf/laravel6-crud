<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Exports\EmployeeExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employee')->with('karyawan', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|unique:employees',
            'alamat' => 'required',
            'telp' => 'required|numeric'
        ]);

        Employee::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
        ]);

        return redirect('/employee')->with('status', 'Data inserted successfully!');
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
    public function edit(Employee $employee)
    {
        return view('edit')->with('karyawan', $employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|unique:employees,email,'.$employee->id,
            'alamat' => 'required',
            'telp' => 'required|numeric'
        ]);

        Employee::where('id', $employee->id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
        ]);

        return redirect('/employee')->with('status', 'Data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        Employee::destroy($employee->id);

        return redirect('/employee')->with('status', 'Data deleted successfully!');
    }

    public function export(){
        return Excel::download(new EmployeeExport, 'employee.xlsx');
    }

    public function export_pdf(){
        $data = Employee::all();
        $pdf = Pdf::loadView('exports.pdf', ['karyawan' => $data]);
        return $pdf->stream('employee.pdf');
    }
}

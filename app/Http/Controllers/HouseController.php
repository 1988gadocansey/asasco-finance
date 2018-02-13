<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HouseController extends Controller {

    /**
     * Create a new controller instance.
     *

     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        if (@\Auth::user()->department != 'top') {
            redirect("/dashboard");
        }
    }

    public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        $data = Models\HouseModel::where("house", "!=", "")->orderBy("house", "ASC")->paginate(100);
        return view('house.index')->with('data', $data);
    }

    public function create(Request $request, SystemController $sys) {
        if ($request->isMethod("get")) {


            $staff = $sys->getLectureList_All();
            return view('house.create')->with('staff', $staff);
        } else {
            
        }
    }

    public function show(Request $request, $type, SystemController $sys) {
        $data = GradeSystemModel::where("type", $type)->paginate(100);
        $grades = $sys->WASSCE_Grades();
        return view('programme.show_grade')->with('data', $data)->with('grade', $grades)
                        ->with('type', $type);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, SystemController $sys) {
        //dd($request);

        $this->validate($request, [
            'name' => 'required',
            'staff' => 'required',
        ]);
        $array = $sys->getSemYear();

        $year = $array[0]->year;

        $total = count($request->input('name'));

        $name = $request->input('name');
        $staff = $request->input('staff');


        for ($i = 0; $i < $total; $i++) {
            $data = new Models\HouseModel();
            $data->house = $name[$i];
            $data->master = $staff[$i];
            $data->year = $year;


            $data->save();
        }
        if (!$data) {

            return redirect("/house/create")->with("error", "<span style='font-weight:bold;font-size:13px;'>Houses could not be created!</span>");
        } else {
            return redirect("/houses")->with("success", " <span style='font-weight:bold;font-size:13px;'>House added successfully created!</span> ");
        }
    }

    // show form for edit resource
    public function edit($edit, SystemController $sys) {
        if (@\Auth::user()->role == 'Admin' || @\Auth::user()->department == 'top') {
            $house = Models\HouseModel::where("id", $edit)->firstOrFail();
            $staff = $sys->getLectureList_All();
            return view('house.edit')
                            ->with('staff', $staff)
                            ->with('data', $house);
        } else {
            return view("unauthorized");
        }
    }

    public function update(Request $request, $edit,SystemController $sys) {

        \DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required',
                'staff' => 'required',
            ]);

$array = $sys->getSemYear();

        $year = $array[0]->year;
            $name = $request->input('name');

            $staff = $request->input('staff');



            $query = Models\HouseModel::where("id", $edit)->update(array("house" => $name, "master" => $staff,"year"=>$year));

            \DB::commit();


            if (!$query) {

                return redirect()->back()->withErrors("<span style='font-weight:bold;font-size:13px;'>House could not be updated!</span>");
            } else {
                return redirect("/house/view")->with("success", " <span style='font-weight:bold;font-size:13px;'>House successfully updated!</span> ");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task) {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

}

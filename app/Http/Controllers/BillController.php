<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankModel;

use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BillController extends Controller
{

    /**
     * Create a new controller instance.
     *

     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');


    }

    public function store(Request $request) {

        $user = \Auth::user()->fund;
        $this->validate($request, ['type' => 'required', 'amount' => 'required', 'description' => 'required', 'term' => 'required', 'year' => 'required','stuType'=>'required']);


        $fee = new Models\BillModel();
        $fee->type = $request->input('type');

        $fee->description = $request->input('description');
        $fee->amount = $request->input('amount');
        $fee->stuType = $request->input('stuType');
        $fee->forms = $request->input('form');
        $fee->classes= $request->input('class');
        $fee->term = $request->input('term');
        $fee->year= $request->input('year');
        $fee->sex= $request->input('gender');

        $fee->worker = $user;
        $name = $request->input('type');

        if ($fee->save()) {
            // \DB::commit();
            return redirect()->back()->with("success", " <span style='font-weight:bold;font-size:13px;'> $name fee  successfully added!</span> ");
        } else {
            return redirect()->back()->withErrors("Fee could not be added");
        }

    }

    public function uploadStudentsFee(Request $request, SystemController $sys) {
        set_time_limit(36000);


            $user = \Auth::user()->fund;
            $valid_exts = array('csv'); // valid extensions
            $file = $request->file('file');
            $name = time() . '-' . $file->getClientOriginalName();
            if (!empty($file)) {

                $ext = strtolower($file->getClientOriginalExtension());
                $destination = public_path() . '\uploads\fees';
                if (in_array($ext, $valid_exts)) {
                    // Moves file to folder on server
                    // $file->move($destination, $name);
                    if (@$file->move($destination, $name)) {



                        $handle = fopen($destination . "/" . $name, "r");
                        //  print_r($handle);
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                            $num = count($data);

                            for ($c = 0; $c < $num; $c++) {
                                $col[$c] = $data[$c];
                            }



                            $program = trim($col[0]);
                            $year = $col[2];
                            $bill = trim($col[3]);
                            $owing = trim($col[3]);



                            //  dd($year);
                            // first check if the students exist in the system if true then update else insert
                            $programme = $sys->programmeSearchByCode(); // check if the programmes in the file tally wat is in the db
                            if (array_search($program, $programme)) {



                                StudentModel::where('PROGRAMMECODE', $program)->where('year', $year)->update(array("SYSUPDATE" => "1", "STATUS" => 'In School', "BILLS" => $bill, "BILL_OWING" => $owing));
                                \DB::commit();
                            } else {
                                return redirect('/upload_fees')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognize programme.please try again!</span> ");
                            }
                        }


                        fclose($handle);
                        return redirect('/students')->with("success", " <span style='font-weight:bold;font-size:13px;'>Fees uploaded  successfully!</span> ");
                    }
                } else {
                    return redirect('/upload_fees')->with("error", " <span style='font-weight:bold;font-size:13px;'>Only csv (comma delimited ) file is accepted!</span> ");
                }
            } else {
                return redirect('/upload_fees')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload a csv file!</span> ");
            }

    }


    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}

<?php
namespace App\Http\Controllers;
 

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('students.gado');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at'])->get();

        return Datatables::of($users)
            ->filter(function ($instance) use ($request) {
                if ($request->has('name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return  Str::contains($row['name'], $request->get('name')) ? true : false;
                    });
                }

                if ($request->has('email')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return  Str::contains($row['email'], $request->get('email')) ? true : false;
                    });
                }
            })
            ->make(true);
    }
}
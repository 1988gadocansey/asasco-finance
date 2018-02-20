<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Response;

class SearchController extends Controller
{
    function index()
    {
        return view('autocomplete');
    }

    public function autocomplete()
    {
        $term = Input::get('term');

        $results = array();


        $queries = DB::table('student')
            ->where('indexNo', 'LIKE', '%' . $term . '%')

            ->orwhere('surname', 'LIKE', '%' . $term . '%')

            ->orWhere('othernames', 'LIKE', '%' . $term . '%')
            ->orWhere('name', 'LIKE', '%' . $term . '%')
            ->take(500)->get();
        foreach ($queries as $query) {

                $results[] = ['id' => $query->id, 'value' => $query->indexNo . ',' . $query->name];

        }
        return Response::json($results);


    }

} 
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


        $queries = DB::table('registration_card')
            ->where('Registration_No', 'LIKE', '%' . $term . '%')

            ->orwhere('Surname', 'LIKE', '%' . $term . '%')

            ->orWhere('First_Name', 'LIKE', '%' . $term . '%')
            ->orWhere('Other_Names', 'LIKE', '%' . $term . '%')
            ->take(500)->get();
        foreach ($queries as $query) {

                $results[] = ['id' => $query->id, 'value' => $query->Registration_No . ',' . $query->Surname. ' ' . $query->First_Name. ',' . $query->Academic_Programme . ' ' . $query->Currently_In_Class];

        }
        return Response::json($results);


    }
     public function autocompleteClass(){
    $term = Input::get('term');
    
    $results = array();
    
     
    $queries = DB::table('registration_card')
                ->where('Currently_In_Class','LIKE', '%'.$term.'%')
                ->orWhere('Academic_Programme','LIKE', '%'.$term.'%')
                ->groupBy('Academic_Programme')
                 ->groupBy('Currently_In_Class')
                 
                
        ->take(500)->get();
    
    foreach ($queries as $query)
    {
         
         
        $results[] = [ 'id' => $query->Academic_Programme.$query->Currently_In_Class, 'value' =>$query->Academic_Programme.'-'.$query->Currently_In_Class ];
     
    }
return Response::json($results);
}

} 
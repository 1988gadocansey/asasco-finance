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
    function index(){
        return view('autocomplete');
    }

    public function autocomplete(){
	$term = Input::get('term');
	
	$results = array();
	
	 
	$queries = DB::table('student')
                ->where('cardNo','LIKE', '%'.$term.'%')
                 ->orWhere('indexNo','LIKE', '%'.$term.'%')
		 
                ->orWhere('othernames', 'LIKE', '%'.$term.'%')
                ->orWhere('surname', 'LIKE', '%'.$term.'%')
                    ->orWhere('name', 'LIKE', '%'.$term.'%')
                
		->take(500)->get();
	
	foreach ($queries as $query)
	{
		if( $query->cardNo!=""){
			$results[] = [ 'id' => $query->id, 'value' => $query->indexNo.','.$query->name ];
		}
		else{
	    $results[] = [ 'id' => $query->id, 'value' => $query->indexNo.','.$query->name ];
	}
	}
return Response::json($results);
}
   public function autocompleteClass(){
	$term = Input::get('term');
	
	$results = array();
	
	 
	$queries = DB::table('classes')
                ->where('name','LIKE', '%'.$term.'%')
                 
                
		->take(500)->get();
	
	foreach ($queries as $query)
	{
		 
		 
	    $results[] = [ 'id' => $query->name, 'value' =>$query->name ];
	 
	}
return Response::json($results);
}
 
} 
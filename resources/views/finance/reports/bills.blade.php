@extends('layouts.app')

 
@section('style')
 
@endsection
 @section('content')
   <div class="md-card-content">
@if(Session::has('success'))
            <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
                {!! Session::get('success') !!}
            </div>
 @endif
 @if(Session::has('error'))
            <div style="text-align: center" class="uk-alert uk-alert-danger" data-uk-alert="">
                {!! Session::get('error') !!}
            </div>
 @endif
 
     @if (count($errors) > 0)

    <div class="uk-form-row">
        <div class="uk-alert uk-alert-danger" style="background-color: red;color: white">

              <ul>
                @foreach ($errors->all() as $error)
                  <li> {{  $error  }} </li>
                @endforeach
          </ul>
    </div>
  </div>
@endif
  </div>
  <div class="uk-modal" id="new_task">
        <div class="uk-modal-dialog ">
            <div class="uk-modal-header">
                <h4 class="uk-modal-title">Create Bills here</h4>
            </div>
               <form action="{{url('finance/bills/create')}}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                    
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-2">
                                        <label>Amount</label>
                                        <input type="text" class="md-input md-input-success" required="" name="amount"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Level</label>
                                        {!!  Form::select('level', array('100'=>'1st years','200' => '2nd years', '300' => '3rd years','400'=>'4th years','400/1'=>'BTECH level 1','400/2'=>'BTECH level 2'), null, ['placeholder' => '','id'=>'parent','class'=>'md-input parent'],old("level","")); !!}

                                    </div>

                                   

                                </div>
                            </div>
                            
                        </div>
                        
                       
                         <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid" data-uk-grid-margin>
                                      <div class="uk-width-medium-1-2">
                                        {!! Form::select('program', 
                                        (['' => 'All programs'] + $program ), 
                                        old("program",""),
                                        ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select program'] )  !!}
                                    </div>
                                </div>
                            </div>
                         </div>
                     
                     
                    
                        <div class="uk-modal-footer uk-text-center" style="margin-left: 15px">
                    <button type="submit" class="md-btn md-btn-flat md-btn-flat-success md-btn-wave" id="snippet_new_save">Create Bill</button>    
                    <button type="button" class="md-btn md-btn-flat uk-modal-close md-btn-wave">Close</button>
                </div>
            </form>
        </div>
        </div></div>
 <div style="">
     <div class="uk-margin-bottom" style="margin-left:750px" >
         <!-- <a  href="#new_task" data-uk-modal="{ center:true }"> <i title="click to send sms to students owing"   class="material-icons md-36 uk-text-success"   >phonelink_ring message</i></a>
 -->
         <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
        <!--  <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="">Import from Excel</a>
         -->
         <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
             <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
             <div class="uk-dropdown">
                 <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
             </div>
         </div>
         

                       
                          
                           
         <div style="margin-top: -5px" class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                <button class="md-btn md-btn-small md-btn-success uk-margin-small-top">Export <i class="uk-icon-caret-down"></i></button>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown">
                                         <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'csv',escape:'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>
                                           
                                            <li class="uk-nav-divider"></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'excel',escape:'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'doc',escape:'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'powerpoint',escape:'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                                            <li class="uk-nav-divider"></li>
                                           
                                    </ul>
                                </div>
                            </div>
                       
                           
                            
                                                   
                                  <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>
                   
                            
                           
     </div>
 </div>
   
<h4 class="heading_c uk-margin-bottom">Bills by programs</h4>

 <div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">
   <div class="uk-overflow-container" id='print'>
                <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
               <thead>
                 <tr>
                     <th class="filter-false remove sorter-false" >NO</th>
                      <th data-priority="6">PROGRAMME</th>
                     <th  style=" ">LEVEL</th>
                     <th>YEAR</th> 
                     <th style=" ">AMOUNT</th>

                       
                     <th data-priority="1" class="filter-false remove sorter-false uk-text-center"    >ACTION</th>   
                                     
                </tr>
             </thead>
      <tbody>
                                        
                                         @foreach($data as $index=> $row) 
                                         
                                         
                                        <tr align="">
                                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                            
                                            <td> {{ @$row->program->PROGRAMME	 }}</td>
                                             
                                            <td> {{ @$row->LEVEL }}</td>
                                           <td> {{ @$row->YEAR }}</td>
                                            <td> {{ @$row->AMOUNT }}</td>
                                            <td> 
                                                   <a href="#"><i class="md-icon material-icons">&#xE254;</i></a>
                                             
                                            </td>
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                                    
                             </table>
          
     </div>
     </div>
        @if(@\Auth::user()->role == 'FO')
<div class="md-fab-wrapper">
    <a class="md-fab md-fab-small md-fab-accent md-fab-wave" title="create new account" href="#new_task" data-uk-modal="{ center:true }">
            <i class="material-icons md-18">&#xE145;</i>
        </a>
    </div>
        @endif
 </div>
</div>
  
@endsection
@section('js')
 
 
@endsection
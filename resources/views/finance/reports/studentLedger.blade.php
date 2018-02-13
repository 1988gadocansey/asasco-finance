@extends('layouts.printlayout')

@section('content')
@inject('help', 'App\Http\Controllers\SystemController')
<div align="" style="margin-left: 12px">
<style>
    td{
        font-size: 13px
    }
   
        </style>
    <div class="md-card">
  
        <div   class="uk-grid" data-uk-grid-margin>

                <body>
                <div id="print">

                    <table  border="0" cellspacing="0" align="center">
                        <tr></tr>
                        <tr>
                            <th height="341" valign="top" class="bod" scope="row"><table border="0" width="100%" border="0">
                            <tr>
                                <th align="center" valign="middle" scope="row"><table border="0" width="882" height="113" border="0">
                                <tr>
                                    <th align="center" valign="middle" scope="row"><table  border="0"style="" width="882" height="113" border="0" align="left">
                                    <tr>
                                        <td><img src='{{url("public/assets/img/printout.png")}}' style="width:581px;height:153px;margin-left: -5%;" /> </td

                                    </tr>
                                </table>
                                 
                                </tr>


                            </table>
                            <p>DEPARTMENT: {{ strtoupper($help->getDepartmentName($help->getProgramDepartment($student->PROGRAMMECODE))) }}</p>
                             <p>SCHOOL: {{ strtoupper($help->getSchoolName($help->getSchoolCode($help->getProgramDepartment($student->PROGRAMMECODE)))) }}</p>
                            <h5 class="heading_c uk-margin-bottom">FEE PAYMENT TRANSACTIONS</h5>
                            <hr>
                            <div align="center">

                                <table border='0' class="uk-table" align="center"  width='900px'>
                                    <tr>
                                        <td width="" style="width:69%">
                                            <div class="table-responsive" style="margin-left:15.5%">
                                                <table border='0' class="uk-table uk-table-nowrap uk-table-no-border" width=""  style="margin-left:-1%" >
                                                    <tbody><tr>
                                                            <td style="">NAME</td> <td style="padding-right: 36px;">{{strtoupper($student->NAME)}}</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            
                                                                <td style="padding-right: px;">INDEX NO</td> <td style="padding-right: 93px;">{{$student->INDEXNO}}</td>
                                                            
                                                           
                                                            
                                                        </tr>

                                                        <tr>
                                                            <td>LEVEL</td> <td style="padding-right: 203px;">{{$student->LEVEL}}</td>
                                                        </tr>
                                                       

                                                        <tr>
                                                            <td>PROGRAMME</td> <td style="padding-right: 177px;"> {{strtoupper($student->program->PROGRAMME)}}</td>
                                                        </tr>



                                                    </tbody></table> </div>
                                        </td>
                
                                        <td width="237" align="left" valign="top"><table class="uk-table" width="237" border="0"  style="margin-left:-13%;">
                                                <tr>
                                                    <td width="202" border='0' ><div style="float:right;"><img style="width:130px;height:auto"  class=" " style=" margin-left: 26%" {!! $help->picture('{{url("public/albums/students/$student->INDEXNO")}}',210) !!} src='{{url("public/albums/students/$student->INDEXNO".'.jpg')}}' alt=" Picture of Student Here" /></div>
                                                       
                                                </tr>
                                            </table></td>
                                    </tr>
                                    </tr>
                                </table> <!-- end basic infos -->


                                <table class="uk-table uk-table-nowrap uk-table-hover" id=""> 
                                    <thead>
                                       <tr  class="uk-text-upper">
                                          <th>NO</th>
                                          <th>DATE</th>
                                        

                                          <th>DESCRIPTION</th>
                                          
                                          <th>DEBIT</th>
                                          <th>CREDIT</th>
                                          <th>BALANCE</th>

                                          <th>TYPE</th> 
              
                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="uk-table-middle">
                                            <td>#</td>
                                            <td>{{$year}}/{{$sem}}</td>
                                            <td>Balance b/d to {{$year}}/{{$sem}} academic year </td>
                                              @if($student->BILL_OWING>0)
                                                   
                                            <td>{{$student->BILL_OWING}}</td>
                                            @else
                                            <td>0</td>
                                            @endif
                                             @if($student->BILL_OWING<=0)
                                                   
                                            <td>{{$student->BILL_OWING}}</td>
                                            @else
                                            <td>0</td>
                                            @endif
                                            <td>{{$student->BILL_OWING}}</td>
                                            <td>
                                                @if($student->BILL_OWING<=0)
                                                    Credit
                                                @else
                                                    Debit
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="uk-table-middle">
                                            <td>#</td>
                                            <td>{{$year}}/{{$sem}}</td>
                                            <td> {{$year}}/{{$sem}} academic year fees </td>
                                              @if($student->BILLS>0)
                                                   
                                            <td>{{$student->BILLS}}</td>
                                            @else
                                            <td>0</td>
                                            @endif
                                             @if($student->BILLS<=0)
                                                   
                                            <td>{{$student->BILLS}}</td>
                                            @else
                                            <td>0</td>
                                            @endif
                                            <td>{{$student->BILLS}}</td>
                                            <td>
                                                @if($student->BILLS<=0)
                                                    Credit
                                                @else
                                                    Debit
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $balance=$student->BILL_OWING+$student->BILLS; ?>
                                         @foreach($data as $index=> $row) 
                                         
                                         
                                            <tr class="uk-table-middle">
                                                <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>

                                                <td> {{ @date('d/m/Y',strtotime($row->TRANSDATE))	 }}</td>

                                                <td> {{ @$row->PAYMENTTYPE  }} of {{$row->FEE_TYPE}} with Receipt No. {{@$row->RECEIPTNO}}</td>
                                                <td></td>
                                                <td> {{ $help->formatMoney(@$row->AMOUNT) }}</td>
                                                <td><?php $balance-=$row->AMOUNT ?> {{$balance}}</td>
                                                <td>Credit</td>
                                                

                                            </tr>
                                         @endforeach

                                    </tbody>

                                </table>
                                 
                                 
                                
                                 
                               
                            </div>
                              
</div>
                            </tr>
                        </table></th>
                        </tr>
                        <tr></tr>
                    </table>
                    
                    <div>
                    </div>
                </div>

        </div>

</div>
</div>
        @endsection

        @section('js')
        <script type="text/javascript">

         window.print();
 

        </script>

        @endsection
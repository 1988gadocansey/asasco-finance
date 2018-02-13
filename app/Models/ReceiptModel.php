<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ReceiptModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpoly_receipt_gen';
    
    protected $primaryKey="id";
    protected $guarded = ['id'];
    public $timestamps = false;
     
     
}

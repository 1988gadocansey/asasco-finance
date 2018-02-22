<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BankModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banks';

    protected $primaryKey="id";
    protected $guarded = ['id'];


}

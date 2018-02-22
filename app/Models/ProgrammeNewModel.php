<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProgrammeNewModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'programme_new';

    protected $primaryKey="id";
    protected $guarded = ['id'];


}

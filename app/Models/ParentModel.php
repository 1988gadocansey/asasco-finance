<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ParentModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'guardian_details';

    protected $primaryKey="Guardian_ID";
    protected $guarded = ['Guardian_ID'];


}

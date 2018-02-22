<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RegistrationCard extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registration_card';

    protected $primaryKey="id";
    protected $guarded = ['id'];

    public function parentdetails(){
        return $this->belongsTo('App\Models\ParentModel', "Guardian_ID","id");
    }

    public function programmedetails(){
        return $this->belongsTo('App\Models\ProgrammeModel', "registration_card","name");
    }


}

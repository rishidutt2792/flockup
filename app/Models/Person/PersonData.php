<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Model;

class PersonData extends Model
{
    protected $table = 'people_datas';

    protected $fillable = [
        "first_name",
        "middle_name",
        "last_name",
        "title",
        "suffix",
        "birth_date",
        "gender",
        "nick_name",
        "created_at",
        "updated_at"
    ];

    public function person()
    {
        return $this->belongsTo('App\Models\Person\Person', 'people_id');
    }
}

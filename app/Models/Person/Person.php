<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    protected $fillable = ["personable_id","personable_type","created_at","updated_at"];

    public function personable()
    {
        return $this->morphTo();
    }

    public function address()
    {
        return $this->morphOne('App\Models\Person\Address\Address', 'addressable');
    }

    public function data()
    {
        return $this->hasOne('App\Models\Person\PersonData', 'people_id');
    }

    public function emails()
    {
        return $this->belongsToMany('App\Models\Person\Email\Email', 'peoples_emails', 'person_id', 'email_id');
    }

    public function phones()
    {
        return $this->belongsToMany('App\Models\Person\Phone\Phone', 'peoples_phones', 'person_id', 'phone_id');
    }

    public function personalContactNumber()
    {
        //  return $this->hasOne('App\Models\Person\Phone\Phone', 'peoples_phones', 'person_id', 'phone_id')->where('category','personal');
        return $this->belongsToMany('App\Models\Person\Phone\Phone', 'peoples_phones', 'person_id', 'phone_id')->where('category','personal');
    }

    public function businessContactNumber()
    {
        //return $this->hasOne('App\Models\Person\Phone\Phone', 'peoples_phones', 'person_id', 'phone_id')->where('category','business');
        return $this->belongsToMany('App\Models\Person\Phone\Phone', 'peoples_phones', 'person_id', 'phone_id')->where('category','business');
    }
}

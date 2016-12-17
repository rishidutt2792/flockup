<?php

namespace App\Models\Person\Address;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = ["addressable_id","addressable_type","created_at","updated_at"];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function data()
    {
        return $this->hasOne('App\Models\Person\Address\AddressData', 'address_id');
    }
}

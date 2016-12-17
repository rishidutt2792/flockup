<?php

namespace App\Models\Person\Address;

use Illuminate\Database\Eloquent\Model;

class AddressData extends Model
{
    protected $table = 'addresses_datas';

    protected $fillable = [
        "street",
        "country",
        "state",
        "city",
        "postal_code",
        "created_at",
        "updated_at"
    ];

    public function address()
    {
        return $this->belongsTo('App\Models\Person\Address\Address', 'address_id');
    }
}

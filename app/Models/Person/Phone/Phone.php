<?php

namespace App\Models\Person\Phone;;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phones';

    protected $fillable = ["number","created_at","updated_at"];
}

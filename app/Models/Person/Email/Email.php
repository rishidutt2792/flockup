<?php

namespace App\Models\Person\Email;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';

    protected $fillable = ["email","created_at","updated_at"];
}

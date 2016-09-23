<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //

    protected $fillable = ['fname', 'lname', 'phone', 'email', 'custom1', 'custom2', 'custom3', 'custom4', 'custom5'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'category', 'rate', 'rate_type', 'photo', 'user_id'])]
class Service extends Model
{
    //
}

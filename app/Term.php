<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    const STATE_OPEN = 0;
    const STATE_PAYED = 1;
}

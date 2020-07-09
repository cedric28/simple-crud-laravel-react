<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function company()
    {
        return $this->belongsTo('App\Company','company_id');
    }
}

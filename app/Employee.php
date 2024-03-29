<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updater_id');
    }

    public function attachment()
    {
        return $this->hasOne('App\Attachment');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

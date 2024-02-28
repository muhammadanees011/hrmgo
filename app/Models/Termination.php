<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    protected $fillable = [
        'employee_id',
        'notice_date',
        'termination_date',
        'termination_type',
        'description',
        'created_by',
    ];

    public function terminationType()
    {
        return $this->hasOne('App\Models\TerminationType', 'id', 'termination_type');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }

    public function exitProcedure()
    {
        return $this->hasOne('App\Models\ExitProcedure', 'id', 'exitprocedure_id');
    }
}

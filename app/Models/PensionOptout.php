<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensionOptout extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'reasons',
    ];

    // Define relationships if needed
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
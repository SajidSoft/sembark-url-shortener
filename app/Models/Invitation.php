<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'email',
        'token',
        'status',
        'role',
        'send_attempts',
        'last_sent_at',
        'accepted_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

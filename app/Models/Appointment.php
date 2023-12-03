<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_time',
        'doctor_fee_amount',
        'admin_fee_amount',
        'client_id',
        'doctor_id',
    ];

    function client(){
        return $this->belongsTo(User::class, 'client_id', 'id');
    }
    
    function doctor(){
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    // appending client name
    public function scopeClientName($query)
    {
        $query->addSelect([
            'client_name' => User::select('name')->whereColumn('id', 'client_id')->take(1),
        ]);
    }
}

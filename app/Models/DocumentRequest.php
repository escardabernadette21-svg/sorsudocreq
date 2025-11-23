<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'studentname',
        'student_id',
        'student_type',
        'year',
        'batch_year',
        'course',
        'request_date',
        'claimed_date',
        'reference_number',
        'total_amount',
        'status',
        'remarks',
    ];

    /**
     * The user who made the document request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(DocumentRequestItem::class);
    }
    public function payment()
    {
        return $this->hasOne(DocumentPayment::class)->withDefault();
    }

}

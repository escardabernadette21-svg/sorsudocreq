<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_request_id',
        'user_id',
        'amount',
        'receipt',
        'status',
        'payment_date',
    ];
    /**
     * The document request associated with the payment.
     */
    public function documentRequest()
    {
        return $this->belongsTo(DocumentRequest::class);
    }

    /**
     * The user who made the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

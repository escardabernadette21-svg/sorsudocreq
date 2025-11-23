<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequestItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_request_id',
        'type',
        'category',
        'quantity',
        'price',
        'total_price',
        'purpose',
        'message',
    ];

    public function request()
    {
        return $this->belongsTo(DocumentRequest::class, 'document_request_id');
    }

}

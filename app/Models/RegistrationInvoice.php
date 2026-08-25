<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationInvoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'registration_fee' => 'decimal:2',
        'ppn_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }

    /**
     * Generate secure, cryptographically signed URL for public customer access (e.g. WhatsApp/SMS)
     */
    public function getPublicPdfUrl(int $daysValid = 60): string
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'invoices.registration-pdf.public',
            now()->addDays($daysValid),
            ['invoiceNumber' => $this->invoice_number]
        );
    }
}

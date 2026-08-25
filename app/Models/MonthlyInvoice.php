<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyInvoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'ppn_amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'payment_gateway_response' => 'array',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(BandwidthPackage::class, 'package_code', 'code');
    }

    /**
     * Generate secure, cryptographically signed URL for public customer access (e.g. WhatsApp/SMS)
     */
    public function getPublicPdfUrl(int $daysValid = 60): string
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'invoices.monthly-pdf.public',
            now()->addDays($daysValid),
            ['invoiceNumber' => $this->invoice_number]
        );
    }
}

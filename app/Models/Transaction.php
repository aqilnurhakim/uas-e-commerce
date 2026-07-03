<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'transaction_date',
        'customer_name',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}

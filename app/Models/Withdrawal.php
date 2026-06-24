<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'bank_account',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::updated(function (Withdrawal $withdrawal) {
            // Refund the user if withdrawal is rejected
            if ($withdrawal->isDirty('status') && $withdrawal->status === 'REJECTED' && $withdrawal->getOriginal('status') !== 'REJECTED') {
                $withdrawal->user->deposit($withdrawal->amount, [
                    'description' => 'Pengembalian dana untuk penarikan yang ditolak. Rekening: ' . $withdrawal->bank_account
                ]);
            }
            
            // Re-deduct if the withdrawal changes from REJECTED back to something else
            if ($withdrawal->isDirty('status') && $withdrawal->getOriginal('status') === 'REJECTED' && $withdrawal->status !== 'REJECTED') {
                $withdrawal->user->withdraw($withdrawal->amount, [
                    'description' => 'Pemotongan ulang penarikan dana. Rekening: ' . $withdrawal->bank_account
                ]);
            }
        });
    }
}

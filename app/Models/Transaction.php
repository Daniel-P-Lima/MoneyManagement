<?php

namespace App\Models;

use App\Helpers\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\TransactionFactory;

#[UseFactory(TransactionFactory::class)]
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'type', 'amount', 'description', 'notes', 'date'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'integer',
        ];
    }

    public function getFormattedAmountAttribute(): string
    {
        return Currency::format($this->amount);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeInMonth($query, int $month, int $year)
    {
        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }
}

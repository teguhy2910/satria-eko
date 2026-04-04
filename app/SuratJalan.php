<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    protected $table = 'sjs';

    protected $fillable = [
        'tanggal_delivery',
        'customer_name',
        'pdsnumber',
        'doaii',
        'sj_balik',
        'terima_finance',
    ];

    protected $dates = [
        'tanggal_delivery',
        'sj_balik',
        'terima_finance',
        'created_at',
        'updated_at',
    ];

    public function scopeOutstanding($query)
    {
        return $query->whereNull('sj_balik');
    }

    public function scopeNotReceivedByFinance($query)
    {
        return $query->whereNull('terima_finance');
    }

    public function scopeRecentDays($query, $days = 7)
    {
        return $query->where('tanggal_delivery', '>=', Carbon::now()->subDays($days));
    }

    public function scopeOlderThanDays($query, $days = 7)
    {
        return $query->where('tanggal_delivery', '<=', Carbon::now()->subDays($days));
    }

    public function scopeGroupedByDoaii($query)
    {
        return $query->groupBy('doaii');
    }

    public function markSjBalik()
    {
        $this->update(['sj_balik' => Carbon::now()]);
    }

    public function markTerimaFinance()
    {
        $this->update(['terima_finance' => Carbon::now()]);
    }

    public function isSjBalik()
    {
        return $this->sj_balik !== null;
    }

    public function isTerimaFinance()
    {
        return $this->terima_finance !== null;
    }

    public static function findByDoaii($doaii)
    {
        return static::where('doaii', $doaii)->whereNotNull('doaii');
    }
}

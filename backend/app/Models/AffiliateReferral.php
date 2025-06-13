<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliateReferral extends Model
{
        use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'referrer_identifier',
        'percentage',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    public function referrer()
    {
        return $this->belongsTo(Affiliate::class, 'referrer_identifier');
    }
}

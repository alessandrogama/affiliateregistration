<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Affiliate extends Model
{
        use HasFactory;

    protected $fillable = [
        'username',
        'nickname',
        'email',
        'base_percentage',
    ];

    public function referrals()
    {
        return $this->hasMany(AffiliateReferral::class, 'affiliate_id');
    }

    public function referredBy()
    {
        return $this->hasMany(AffiliateReferral::class, 'referrer_id');
    }
}

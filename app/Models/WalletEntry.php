<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletEntry extends Model
{
    use HasFactory;

    protected $table = 'wallet_enteries';

    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'description',
        'transaction_parent_id'
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }

}

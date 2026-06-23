<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'upi_id',
        'upi_qr_code',
        'bank_name',
        'account_holder',
        'account_number',
        'ifsc_code',
    ];
}

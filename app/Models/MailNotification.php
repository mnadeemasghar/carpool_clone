<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailNotification extends Model
{
    use HasFactory;

    protected $table = 'mail_notifications';

    protected $fillable = [
        'user_id',
        'subject',
        'body'
    ];
}

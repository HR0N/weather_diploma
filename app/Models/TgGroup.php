<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TgGroup extends Model
{
    protected $table = 'tg_groups'; /* <== OPTIONAL */
    use HasFactory;

    protected $fillable = [
        'group_title',
        'group_id',
        'allow_messages',
        'city',
        'message_period',
        'message_type',
    ];
}

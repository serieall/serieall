<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Contact.
 *
 * @property string $name
 * @property string $email
 * @property string $objet
 * @property string $message
 * @property int    $admin_id
 * @property string $admin_message
 */
class Contact extends Model
{
    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'objet',
        'message',
        'admin_id',
        'admin_message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
}

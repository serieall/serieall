<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact.
 *
 * @property int              $id
 * @property string           $name
 * @property string           $email
 * @property string           $objet
 * @property string           $message
 * @property int              $admin_id
 * @property string           $admin_message
 * @property \Carbon\Carbon   $created_at
 * @property \Carbon\Carbon   $updated_at
 * @property \App\Models\User $user
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereObjet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereadminMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'objet', 'message', 'admin_id', 'admin_message'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
}

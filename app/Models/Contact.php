<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 */
class Contact extends Model {

    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = array('email', 'objet', 'message', 'admin_id');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\List_log
 *
 * @property int $id
 * @property string $job
 * @property string $object
 * @property int $object_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereJob($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereObject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereObjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\List_log whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class List_log extends Model {

	protected $table = 'list_logs';
	public $timestamps = true;
	protected $fillable = array('job', 'object', 'object_id', 'user_id');

	public function logs()
	{
		return $this->hasMany('App\Models\Log');
	}

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
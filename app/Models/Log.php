<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Log
 *
 * @property int $id
 * @property string $name
 * @property string $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Log extends Model {

	protected $table = 'logs';
	public $timestamps = true;
	protected $fillable = array('name', 'message');

}
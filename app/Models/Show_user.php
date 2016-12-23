<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Show_user
 *
 * @property int $show_id
 * @property int $user_id
 * @property bool $state
 * @property string $message
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show_user whereShowId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show_user whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show_user whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show_user whereMessage($value)
 * @mixin \Eloquent
 */
class Show_user extends Model {

	protected $table = 'show_user';
	public $timestamps = false;
	protected $fillable = array('show_id', 'user_id', 'state', 'message');

}
<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Nationality
 *
 * @property int $id
 * @property string $name
 * @property string $nationality_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality whereNationalityUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Nationality extends Model {

	protected $table = 'nationalities';
	public $timestamps = true;
	protected $fillable = ['name', 'nationality_url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shows()
	{
		return $this->belongsToMany('App\Models\Show');
	}

}
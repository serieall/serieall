<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Nationality_show.
 *
 * @property int $nationality_id
 * @property int $show_id
 */
class Nationality_show extends Model
{
    protected $table = 'nationality_show';
    public $timestamps = false;
}

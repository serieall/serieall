<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Episode_user
 *
 * @property int $episode_id
 * @property int $user_id
 * @property int $rate
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode_user whereEpisodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode_user whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode_user whereRate($value)
 * @mixin \Eloquent
 * @property int|null $season_id
 * @property int|null $show_id
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Episode $episode
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereUpdatedAt($value)
 * @property \Carbon\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode_user whereCreatedAt($value)
 */
	class Episode_user extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Channel
 *
 * @property int $id
 * @property string $name
 * @property string $channel_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereChannelUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Channel extends \Eloquent {}
}

namespace App\Models{
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
	class Show_user extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Articlable
 *
 * @property int $article_id
 * @property int $articlable_id
 * @property string $articlable_type
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articlable whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articlable whereArticlableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articlable whereArticlableType($value)
 * @mixin \Eloquent
 */
	class Articlable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Artist
 *
 * @property int $id
 * @property string $name
 * @property string $artist_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereArtistUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Artist extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Genre
 *
 * @property int $id
 * @property string $name
 * @property string $genre_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereGenreUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Genre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article_user
 *
 * @property int $article_id
 * @property int $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article_user whereUserId($value)
 * @mixin \Eloquent
 */
	class Article_user extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Channel_show
 *
 * @property int $channel_id
 * @property int $show_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel_show whereChannelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel_show whereShowId($value)
 * @mixin \Eloquent
 */
	class Channel_show extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $objet
 * @property string $message
 * @property int $admin_id
 * @property string $admin_message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
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
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Answer
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property int $question_id
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer whereQuestionId($value)
 * @mixin \Eloquent
 */
	class Answer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Episode
 *
 * @property int $id
 * @property int $thetvdb_id
 * @property int $numero
 * @property string $name
 * @property string $name_fr
 * @property string $resume
 * @property string $resume_fr
 * @property string $particularite
 * @property string $diffusion_us
 * @property string $diffusion_fr
 * @property string $ba
 * @property float $moyenne
 * @property int $nbnotes
 * @property int $season_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Season $season
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $directors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $writers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $guests
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereThetvdbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereNameFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereResume($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereResumeFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereParticularite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereDiffusionUs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereDiffusionFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereBa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereMoyenne($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereNbnotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereSeasonId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Episode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $picture
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Episode wherePicture($value)
 */
	class Episode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $user_url
 * @property string $email
 * @property string $password
 * @property bool $role
 * @property bool $suspended
 * @property bool $activated
 * @property string $edito
 * @property bool $antispoiler
 * @property string $website
 * @property string $twitter
 * @property string $facebook
 * @property string $ip
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode[] $episodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Poll[] $polls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\List_log[] $logs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUserUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSuspended($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereActivated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEdito($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAntispoiler($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User_activation
 *
 * @property int $user_id
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_activation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User_activation extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \App\Models\User $user
 */
	class List_log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Nationality_show
 *
 * @property int $nationality_id
 * @property int $show_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality_show whereNationalityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Nationality_show whereShowId($value)
 * @mixin \Eloquent
 */
	class Nationality_show extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $published_at
 * @property string $name
 * @property string $article_url
 * @property string $intro
 * @property string $content
 * @property string $image
 * @property string $source
 * @property bool $state
 * @property bool $frontpage
 * @property int $category_id
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereArticleUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereFrontpage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCategoryId($value)
 * @mixin \Eloquent
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Genre_show
 *
 * @property int $genre_id
 * @property int $show_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre_show whereGenreId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre_show whereShowId($value)
 * @mixin \Eloquent
 */
	class Genre_show extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Poll
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $poll_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll wherePollUrl($value)
 * @mixin \Eloquent
 */
	class Poll extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Poll_user
 *
 * @property int $poll_id
 * @property int $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll_user wherePollId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll_user whereUserId($value)
 * @mixin \Eloquent
 */
	class Poll_user extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Temp
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Temp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Temp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slogan
 *
 * @property int $id
 * @property string $message
 * @property string $source
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Slogan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Slogan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Log
 *
 * @property int $id
 * @property int $list_log_id
 * @property string $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\List_log $list_log
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereListLogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Artistable
 *
 * @property int $artist_id
 * @property int $artistable_id
 * @property string $artistable_type
 * @property string $profession
 * @property string $role
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereArtistableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereArtistableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereProfession($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artistable whereRole($value)
 * @mixin \Eloquent
 */
	class Artistable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Question
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property int $poll_id
 * @property-read \App\Models\Poll $poll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $answers
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question wherePollId($value)
 * @mixin \Eloquent
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Season
 *
 * @property int $id
 * @property int $thetvdb_id
 * @property int $name
 * @property string $ba
 * @property float $moyenne
 * @property int $nbnotes
 * @property int $show_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Show $show
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode[] $episodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereThetvdbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereBa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereMoyenne($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereNbnotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereShowId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Season whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode_user[] $users
 */
	class Season extends \Eloquent {}
}

namespace App\Models{
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
	class Nationality extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Show
 *
 * @property int $id
 * @property int $thetvdb_id
 * @property string $show_url
 * @property string $name
 * @property string $name_fr
 * @property string $synopsis
 * @property string $synopsis_fr
 * @property int $format
 * @property int $annee
 * @property bool $encours
 * @property string $diffusion_us
 * @property string $diffusion_fr
 * @property float $moyenne
 * @property float $moyenne_redac
 * @property int $nbnotes
 * @property int $taux_erectile
 * @property string $avis_rentree
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Season[] $seasons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Episode[] $episodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nationality[] $nationalities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genre[] $genres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $creators
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $actors
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereThetvdbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereShowUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereNameFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereSynopsis($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereSynopsisFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereAnnee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereEncours($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereDiffusionUs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereDiffusionFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereMoyenne($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereMoyenneRedac($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereNbnotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereTauxErectile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereAvisRentree($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Show whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $particularite
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereParticularite($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 */
	class Show extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $left
 * @property int $right
 * @property string $message
 * @property string $thumb
 * @property bool $spoiler
 * @property int $user_id
 * @property int $parent_id
 * @property int $commentable_id
 * @property int $commentable_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereThumb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereSpoiler($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $reactions
 */
	class Comment extends \Eloquent {}
}


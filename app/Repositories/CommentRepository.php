<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


/**
 * Class CommentRepository
 * @package App\Repositories\Admin
 */
class CommentRepository
{
    protected $comment;

    /**
     * SeasonRepository constructor.
     *
     * @param Comment $comment
     * @internal param Episode $episode
     * @internal param Season $season
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get Comment by User, Type Comment, And Type ID
     *
     * @param $user_id
     * @param $type
     * @param $type_id
     * @return Comment
     * @internal param $userID
     * @internal param $typeID
     */
    public function getCommentByUserIDTypeTypeID($user_id, $type, $type_id) {
        return $this->comment::where('commentable_id', '=', $type_id)
            ->with(['children' => function($q) {
                $q->with('user');
            }])
            ->where('user_id', '=', $user_id)
            ->where('commentable_type', '=', $type)
            ->first();
    }

    /**
     * Get Last Two Comments by Type Comment and Type ID
     *
     * @param $type
     * @param $type_id
     * @param $user_comment_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLastTwoCommentsByTypeTypeID($type, $type_id, $user_comment_id) {
        return $this->comment::where('commentable_id', '=', $type_id)
            ->where('commentable_type', '=', $type)
            ->whereNotIn('id', [$user_comment_id])
            ->with('user')
            ->orderByDesc('created_at')
            ->limit(2)
            ->get()
            ->toArray();
    }

    /**
     * Get users's comment and the last two comments for the object
     *
     * @param $user_id
     * @param $object
     * @param $object_id
     * @return array
     */
    public function getCommentsForFiche($user_id, $object, $object_id) {
        # Initialize
        $user_comment_id = '';

        if(!is_null($user_id)) {
            $user_comment = $this->getCommentByUserIDTypeTypeID($user_id, $object, $object_id);

            if(!is_null($user_comment)){
                $user_comment_id = $user_comment->id;
            }
        }

        if(Route::current()->getName() == 'comment.fiche') {
            $last_comment = $this->getAllCommentsByTypeTypeID($object, $object_id);
        }
        else if(Route::current()->getName() == 'article.show') {
            $last_comment = $this->getAllCommentsByTypeTypeID($object, $object_id);
        }
        else {
            $last_comment = $this->getLastTwoCommentsByTypeTypeID($object, $object_id, $user_comment_id);
        }

        return compact('user_comment', 'last_comment');
    }

    /**
     * @param $object
     * @param $object_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllCommentsByTypeTypeID($object, $object_id) {
        return $this->comment::where('commentable_id', '=', $object_id)
            ->where('commentable_type', '=', $object)
            ->with(['user', 'children' => function($q) {
                $q->with('user');
                $q->orderBy('created_at');
            }])
            ->paginate(10);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getCommentByID($id) {
        return $this->comment->with(['children' => function($children) {
            $children->with('user');
            $children->orderBy('created_at');
        }, 'parent' => function($parent) {
            $parent->with('user');
            $parent->orderBy('created_at');
        }, 'user'])->findOrFail($id);
    }

    /**
     * @param $user_id
     * @return Comment[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getCommentByUserIDThumbNotNull($user_id){
        return $this->comment::where('user_id', '=', $user_id)
            ->where('thumb', '!=', null)
            ->select('thumb', DB::raw('count(*) as total'))
            ->groupBy('thumb')
            ->get();
    }

    /**
     * @param $user_id
     * @return int
     */
    public function countCommentByUserIDThumbNotNull($user_id){
        return $this->comment::where('user_id', '=', $user_id)
            ->where('thumb', '!=', null)
            ->count();

    }

    /**
     * Get All comments for a user with reactions
     *
     * @param $user_id
     * @return Comment[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getCommentsByUserID($user_id) {
        return $this->comment->with(['children', 'commentable', 'user' => function ($q) use ($user_id) {
            $q->where('id', '=', $user_id);
        }])
            ->whereNull('parent_id')
            ->whereNotNull('thumb')
            ->whereNotNull('commentable_id')
            ->get();
    }

    /**
     * Get All comments for a user with reactions
     *
     * @param $user_id
     * @param $name_page
     * @param $filter
     * @param $tri
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCommentsShowForProfile($user_id, $name_page, $filter, $tri) {
        return $this->comment->with('children')->whereHas('user', function ($q) use ($user_id) {
            $q->where('id', '=', $user_id);
        })
            ->whereNull('parent_id')
            ->join('shows', 'comments.commentable_id', '=', 'shows.id')
            ->whereCommentableType('App\Models\Show')
            ->whereNotNull('thumb')
            ->whereNotNull('commentable_id')
            ->whereIn('thumb', $filter )
            ->orderBy($tri)
            ->paginate(4, ["*"], $name_page);
    }

    /**
     * Get All comments for a user with reactions
     *
     * @param $user_id
     * @param $name_page
     * @param $filter
     * @param $tri
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCommentsSeasonForProfile($user_id, $name_page, $filter, $tri) {
        return $this->comment->with('children')->whereHas('user', function ($q) use ($user_id) {
            $q->where('id', '=', $user_id);
        })
            ->whereNull('parent_id')
            ->join('seasons', 'comments.commentable_id', '=', 'seasons.id')
            ->join('shows', 'seasons.show_id', '=', 'shows.id')
            ->whereCommentableType('App\Models\Season')
            ->whereNotNull('thumb')
            ->whereNotNull('commentable_id')
            ->whereIn('thumb', $filter )
            ->orderBy($tri)
            ->paginate(4, ["*"], $name_page);
    }

    /**
     * Get All comments for a user with reactions
     *
     * @param $user_id
     * @param $name_page
     * @param $filter
     * @param $tri
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCommentsEpisodeForProfile($user_id, $name_page, $filter, $tri) {
        return $this->comment->with('children')->whereHas('user', function ($q) use ($user_id) {
            $q->where('id', '=', $user_id);
        })
            ->whereNull('parent_id')
            ->join('episodes', 'comments.commentable_id', '=', 'episodes.id')
            ->join('seasons', 'episodes.season_id', '=', 'seasons.id')
            ->join('shows', 'seasons.show_id', '=', 'shows.id')
            ->whereCommentableType('App\Models\Episode')
            ->whereIn('thumb', $filter )
            ->whereNotNull('thumb')
            ->whereNotNull('commentable_id')
            ->orderBy($tri)
            ->paginate(4, ["*"], $name_page)
            ;
    }

    /**
     * @param $limit
     * @return Comment[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLastComments($limit) {
        return $this->comment->limit($limit)->orderBy('created_at', 'desc')->get();
    }

}
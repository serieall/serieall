<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Comment;
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
        return $this->comment->where('commentable_id', '=', $type_id)
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
        return $this->comment->where('commentable_id', '=', $type_id)
            ->where('commentable_type', '=', $type)
            ->whereNotIn('id', [$user_comment_id])
            ->with('user')
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
        return $this->comment->where('commentable_id', '=', $object_id)
            ->where('commentable_type', '=', $object)
            ->with('user')
            ->paginate(10);
    }
}
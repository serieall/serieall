<?php


namespace App\Repositories;

use App\Models\Comment;


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
            ->get();
    }
}
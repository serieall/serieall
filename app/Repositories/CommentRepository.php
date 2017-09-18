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
     * @param $userID
     * @param $type
     * @param $typeID
     * @return Comment
     */
    public function getCommentByUserIDTypeTypeID($userID, $type, $typeID) {
        return $this->comment->where('commentable_id', '=', $typeID)
            ->where('user_id', '=', $userID)
            ->where('commentable_type', '=', $type)
            ->first();
    }
}
<?php


use App\Repositories\CommentRepository;

/**
 * Get users's comment and the last two comments for the object
 *
 * @param $user_id
 * @param $object
 * @param $object_id
 * @return array
 */
function getComments($user_id, $object, $object_id) {
    $repository = new CommentRepository(new \App\Models\Comment());

    if(!is_null($user_id)) {
        $user_comment = $repository->getCommentByUserIDTypeTypeID($user_id, $object, $object_id);
        if(!is_null($user_comment)){
            $user_comment_id = $user_comment->id;
        }
        else {
            $user_comment_id = '';
        }
    }
    else {
        $user_comment_id = '';
    }

    $last_comment = $repository->getLastTwoCommentsByTypeTypeID($object, $object_id, $user_comment_id);

    return compact('user_comment', 'last_comment');
}

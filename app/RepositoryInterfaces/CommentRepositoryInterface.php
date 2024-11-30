<?php
namespace App\RepositoryInterfaces;

interface CommentRepositoryInterface
{
    public function getCommentsByRideId($ride_id);
    public function storeComment($ride_id, $user_id, $comment_body);
}
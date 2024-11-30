<?php
namespace App\Services;

use App\RepositoryInterfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected $commentReposity;

    public function __construct(CommentRepositoryInterface $commentReposity)
    {
        $this->commentReposity = $commentReposity;    
    }

    public function getCommentsByRideId($ride_id){
        return $this->commentReposity->getCommentsByRideId($ride_id);
    }
    public function storeComment($ride_id,$comment_body){

        $user_id = Auth::user()->id;
        
        return $this->commentReposity->storeComment($ride_id, $user_id, $comment_body);
    }
}
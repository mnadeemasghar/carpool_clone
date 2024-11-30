<?php
namespace App\Repositories;

use App\Events\CommentForRideCreated;
use App\Models\Comment;
use App\RepositoryInterfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CommentRepository  implements CommentRepositoryInterface
{
    public function getCommentsByRideId($ride_id){
        return Comment::where('ride_id',$ride_id)
                ->orderby('created_at','desc')
                ->paginate(20);
    }

    public function storeComment($ride_id, $user_id, $comment_body){
        $comment = Comment::create([
            'ride_id' => $ride_id,
            'user_id' => $user_id,
            'body' => $comment_body
        ]);

        $ride = $comment->ride;

        event(new CommentForRideCreated($comment, $ride));
        
        return $comment;
    }
    
}
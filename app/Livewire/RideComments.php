<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RideComments extends Component
{
    public $ride;
    public $body;

    protected $rules = [
        'body' => 'required|max:255',
    ];

    
    public function mount($ride){
        $this->ride = $ride;
    }

    public function submitComment(CommentService $commentService)
    {
        $this->validate();
        $commentService->storeComment($this->ride->id,$this->body);
        $this->body = '';
        $this->ride->load('comments');
    }
    
    public function render()
    {
        return view('livewire.ride-comments', ['comments' => $this->ride->comments()->latest()->get()]);
    }
}

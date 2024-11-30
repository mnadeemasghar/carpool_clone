<?php
namespace App\Traits;

trait Blogable
{
    public function blogPage($pageTitle, $pageContent)
    {
        return view('page')->with(['page' => $pageTitle, 'content' => $pageContent]);
    }
}
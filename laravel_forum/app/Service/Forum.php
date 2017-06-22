<?php

namespace App\Service;

use App\Comment;

/**
 * Class Forum
 */
class Forum{


    /**
     * @return mixed
     */
    public function getLastFiveComments(){
        return Comment::where('active', 1)
            ->orderBy('content', 'asc')
            ->take(5)
            ->get();
    }

}
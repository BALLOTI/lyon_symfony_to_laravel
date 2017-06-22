<?php


/**
 * Class Forum
 */
class Forum{


    /**
     * @return mixed
     */
    public function getLastFiveComments(){
        return App\Comments::where('active', 1)
            ->orderBy('content', 'asc')
            ->take(5)
            ->get();
    }

}
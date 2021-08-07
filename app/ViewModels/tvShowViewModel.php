<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class tvShowViewModel extends ViewModel
{
    public $tvShow;
    public function __construct($tvShow)
    {
        $this->tvShow = $tvShow;
    }

    public function tvShow(){
        return collect($this->tvShow)->merge([
            'poster_path' => 'https://image.tmdb.org/t/p/w500/'. $this->tvShow['poster_path'],
            'vote_average'=> $this->tvShow['vote_average'] * 10 . '%',
            'first_air_date' => Carbon::parse($this->tvShow['first_air_date'])->format('M d, Y'),
            'genres' => collect($this->tvShow['genres'])->pluck('name')->flatten()->implode(', '),
            'crew' => collect($this->tvShow['credits']['crew'])->take(2),
            'cast' => collect($this->tvShow['credits']['cast'])->take(5),
            'images' => collect($this->tvShow['images']['backdrops'])->take(9),
            'created_by' => collect($this->tvShow['created_by'])->take(2),
        ])
        ->only([
            'id', 'poster_path', 'name', 'vote_average', 'overview', 'first_air_date', 'genres', 
            'genre_ids', 'crew', 'cast', 'images', 'videos', 'credits', 'created_by'
        ]);
    }
}

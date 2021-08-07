<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Facades\Http;

class MovieShowModel extends ViewModel
{
    public $movie;

    public function __construct($movie)
    {
        //
        $this->movie = $movie;
    }

    public function movie(){
        
        return collect($this->movie)->merge([
            'poster_path' => 'https://image.tmdb.org/t/p/w500/'. $this->movie['poster_path'],
            'vote_average'=> $this->movie['vote_average'] * 10 . '%',
            'release_date' => Carbon::parse($this->movie['release_date'])->format('M d, Y'),
            'genres' => collect($this->movie['genres'])->pluck('name')->flatten()->implode(', '),
            'crew' => collect($this->movie['credits']['crew'])->take(2),
            'cast' => collect($this->movie['credits']['cast'])->take(5),
            'images' => collect($this->movie['images']['backdrops'])->take(9),
        ])->only([
            'id', 'poster_path', 'title', 'vote_average', 'overview', 'release_date', 'genres', 
            'genre_ids', 'crew', 'cast', 'images', 'videos', 'credits'
        
        ]);

    }
}

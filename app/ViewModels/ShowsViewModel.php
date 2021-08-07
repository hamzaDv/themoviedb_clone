<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ShowsViewModel extends ViewModel
{
    public $popularShows;
    public $ratedShows;
    public $genres;

    public function __construct($popularShows, $ratedShows, $genres)
    {
        $this->popularShows = $popularShows;
        $this->ratedShows = $ratedShows;
        $this->genres = $genres;
    }

    public function popularShows(){
        return $this->formatTvShow($this->popularShows);
    }

    public function ratedShows(){
        return $this->formatTvShow($this->ratedShows);
    }

    public function genres(){
        return collect($this->genres)->mapWithKeys(function ($genre){
            return [$genre['id']  => $genre['name']];
        });
    }
    
    public function formatTvShow($shows){

        return collect($shows)->map(function($tvShow){
            
            $genresFormatted = collect($tvShow['genre_ids'])->mapWithKeys(function ($value){
                return [$value = $this->genres()->get($value)];
            })->implode(', ');
            
            return collect($tvShow)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500/'. $tvShow['poster_path'],
                'vote_average'=> $tvShow['vote_average'] * 10 . '%',
                'first_air_date' => isset($tvShow['first_air_date'])?
                    Carbon::parse($tvShow['first_air_date'])->format('M d, Y'): 
                    Carbon::parse(now())->format('M d, Y'),
                'genres' => $genresFormatted
            ])->only([
                'id', 'poster_path', 'name', 'vote_average', 'overview', 'first_air_date', 'genres', 'genre_ids'
            ]);
        });
    }
}

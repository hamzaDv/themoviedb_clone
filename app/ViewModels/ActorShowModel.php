<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ActorShowModel extends ViewModel
{   
    public $actor;
    public $social;
    public $credits;


    public function __construct($actor, $social, $credits)
    {
        $this->actor = $actor;
        $this->social = $social;
        $this->credits = $credits;
    }

    public function actor(){

        return collect($this->actor)->merge([
            'profile_path' => ($this->actor['profile_path'])?
                'https://www.themoviedb.org/t/p/w300_and_h450_bestv2/'. $this->actor['profile_path'] : 
                'https://ui-avatars.com/api/?size=235&name='. $this->actor['name'],
            'birthday' => Carbon::parse($this->actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($this->actor['birthday'])->get('age'),
        ])->only([
            'id', 'profile_path', 'name', 'birthday', 'age', 'place_of_birth', 'homepage',
            'biography'
        ]);
    }

    public function social(){
        return collect($this->social)->merge([
            'twitter' => $this->social['twitter_id'] ? 'https://twitter.com/'. $this->social['twitter_id'] : null,
            'instagram' => $this->social['instagram_id'] ? 'https://www.instagram.com/'. $this->social['instagram_id'] : null,
            'facebook' => $this->social['facebook_id'] ? 'https://www.facebook.com/'. $this->social['facebook_id'] : null,
        ]);
    }

    public function kownForMovies(){

        $castMovies = collect($this->credits)->get('cast');
        
        return collect($castMovies)->sortByDesc('popularity')->take(5)->map(function ($movie) {
            if(isset($movie['title'])){
                $title = $movie['title'];
            }elseif(isset($movie['name'])){
                $title = $movie['name'];
            }else{
                $title = '';
            }
                return collect($movie)->merge([
                    'poster_path' => $movie['poster_path'] ?
                        'https://image.tmdb.org/t/p/w185'. $movie['poster_path'] :
                        'https://via.placeholder.com/185x278',
                    'title' => $title,
                    'linkToPage' => $movie['media_type'] == 'movie' ?
                    route('movies.show', $movie['id']) : 
                    route('tv.show', $movie['id']),
                ])->only([
                    'poster_path', 'title', 'id', 'media_type', 'linkToPage'
                ]);
            }
        );
    }

    public function credits(){

        $castMovies = collect($this->credits)->get('cast');

        return collect($castMovies)->map(function ($movie) {

            if(isset($movie['release_date'])){
                $releasedDate = $movie['release_date'];
            }elseif(isset($movie['first_air_date'])){
                $releasedDate = $movie['first_air_date'];
            }else{
                $releasedDate = '';
            }

            if(isset($movie['title'])){
                $title = $movie['title'];
            }elseif(isset($movie['name'])){
                $title = $movie['name'];
            }else{
                $title = '';
            }
                return collect($movie)->merge([
                    'release_date' => $releasedDate,
                    'release_year' => isset($releasedDate) ? Carbon::parse($releasedDate)->format('Y') : 'Future',
                    'title' => $title,
                    'character' => isset($movie['character']) ? $movie['character'] : ''
                ]);
        })
        ->sortByDesc('release_date');
        // ->dump();
        // ->only([
        //     'credit_id', 'release_date', 'title', 'character', 'first_air_date',
        //     'original_title', 'name'
        // ]);
    }
}

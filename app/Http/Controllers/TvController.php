<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\ShowsViewModel;
use App\ViewModels\tvShowViewModel;
use Illuminate\Support\Facades\Http;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $popularShows = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/tv/popular')
        ->json()['results'];

        $topRatedShows = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/tv/top_rated')
        ->json()['results'];
        
        $genres = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/genre/movie/list')
        ->json()['genres'];

        $ShowsViewModel =  new ShowsViewModel(
            $popularShows,
            $topRatedShows,
            $genres
        );
        
        return view('shows.index', $ShowsViewModel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tvShow = Http::withToken(config('services.tmdb.token'))
        ->get('https://api.themoviedb.org/3/tv/'. $id. '?append_to_response=credits,videos,images')
        ->json();


        $tvShowViewModel =  new tvShowViewModel(
            $tvShow
        );
        
        return view('shows.show', $tvShowViewModel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

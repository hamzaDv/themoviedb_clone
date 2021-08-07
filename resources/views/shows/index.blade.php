@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 pt-16">
        <div class="popular-shows">
            <h2 class="uppercase tracking-wider text-yellow-500 font-semibold">Popular TV Shows</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">      
                @foreach ($popularShows as $show)
                    <x-tv-card :show="$show" :genres="$genres" />
                @endforeach
            </div>
        </div>
        <div class="top-rated-shows py-24">
            <h2 class="uppercase tracking-wider text-yellow-500 font-semibold">Top Rated TV Shows</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($ratedShows as $show)
                    <x-tv-card :show="$show" />
                @endforeach  
            </div>
        </div>
    </div>
@endsection
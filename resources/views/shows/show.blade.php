@extends('layouts.main')

@section('content')
    <div class="tvShow-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-cold md:flex-row">
            <img src="{{ $tvShow['poster_path'] }}" alt="Poster" class="md:w-96 w-64">
            <div class="ml-24">
                <div class="text-4xl font-semibold">
                    {{ $tvShow['name'] }}
                </div>
                <div class="flex flex-wrap items-center text-gray-400 text-sm mt-2">
                    <svg class="fill-current text-yellow-500 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span class="ml-1">{{ $tvShow['vote_average'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $tvShow['first_air_date'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $tvShow['genres'] }}</span>
                </div>
                <p class="text-gray-300 mt-8">
                    {{ $tvShow['overview']}} 
                </p>
                <div class="mt-12">
                    <h4 class="text-white font-semibold">Featured Cast</h4>
                    <div class="flex mt-4">
                        @foreach ($tvShow['created_by'] as $director)
                            <div @if($loop->index == 0 ) class="" @else  class="ml-8" @endif >
                                <div>{{ $director['name'] }}</div>
                                <div class="text-sm text-gray-400">Creator</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div x-data="{ isOpen:false }">
                    @if(count($tvShow['videos']['results']) > 0)
                    <div class="mt-12">
                            <button 
                            @click="isOpen=true"
                            class="flex inline-flex items-center bg-yellow-800 rounded font-semibold px-5 py-4
                            hover:bg-yellow-600 transition ease-in-out duration-150">
                                <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                <span class="ml-2">Play Trailer</span>    
                            </button>
                        </div>
                    @endif
                    <div
                        style="background-color: rgba(0, 0, 0, .5);"
                        class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                        x-show.transition.opacity="isOpen"
                    >
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2">
                                    <button
                                        class="text-3xl leading-none hover:text-gray-300"
                                        @click="isOpen=false">&times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                        <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $tvShow['videos']['results'][0]['key'] }}" style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if(count($tvShow['credits']['cast']) > 0)
    <div class="tv-cast border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Cast</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($tvShow['cast'] as $cast)
                        <div class="mt-8">
                            <a href="{{ route('actors.show', $cast['id']) }}">
                                <img src={{"https://image.tmdb.org/t/p/w500/". $cast['profile_path']}} alt="Cast" class="h-5/6 hover:opacity-75 transition ease-in-out duration-1">
                            </a>
                            <div class="mt-2">
                                <a href="{{ route('actors.show', $cast['id']) }}" class="text-lg mt-2 hover:text-gray:300">{{ $cast['name']   }}</a>
                                <div class="text-gray-400 text-sm">
                                    {{  $cast['original_name']  }}
                                </div>
                            </div>
                        </div>       
                @endforeach
            </div>
        </div>
    </div>
    @endif
    @if(count($tvShow['images']) > 0)
    <div class="tv-images" x-data="{ isOpen: false, image: ''}">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Images</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($tvShow['images'] as $image)
                        <div class="mt-8">
                            <a 
                            @click.prevent="
                                isOpen=true
                                image='{{'https://image.tmdb.org/t/p/original/'. $image['file_path']}}'
                                "
                            href='#'
                            >
                                <img src={{"https://image.tmdb.org/t/p/w500/". $image['file_path']}} alt="Cast" class="h-5/6 hover:opacity-75 transition ease-in-out duration-1">
                            </a>
                        </div>
                @endforeach
            </div>

            <div
                style="background-color: rgba(0, 0, 0, .5);"
                class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                x-show.transition.opacity="isOpen"
            >
                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                    <div class="bg-gray-900 rounded">
                        <div class="flex justify-end pr-4 pt-2">
                            <button

                                class="text-3xl leading-none hover:text-gray-300"
                                @click="isOpen=false"
                                @keydown.escape.window="isOpen=false">&times;
                            </button>
                        </div>
                        <div class="modal-body px-8 py-8">
                            <img :src="image" alt="backdrop">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif
@endsection
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
    <style>
        :root {
            --accent: #fe662a;
            --primary: #2b3138;
            --secondary: #202329;
            --text-primary: #fff;
            --text-secondary: #ccc;
            --text-bg: #252932;
            --dark: #222832;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background-color: #111;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
        }

        .scrollbar-hidden::-webkit-scrollbar {
            width: 0.5em;
        }

        .scrollbar-hidden::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-hidden::-webkit-scrollbar-thumb {
            background: transparent;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-screen flex flex-col relative">
        @php
            $backdropPath = $movieData ? "{$imageBaseURL}/original{$movieData->backdrop_path}" : '';
        @endphp
        {{-- background image --}}
        <img class="w-full h-screen absolute object-cover lg:object-fill" src="{{ $backdropPath }}">
        <div class="w-full h-screen absolute bg-black bg-opacity-60 z-10"></div>

        {{-- Header section --}}
        <div class="w-full bg-transparent h-[96px] drop-shadow-lg flex flex-row items-center z-10">

            <div class="w-1/3 pl-5">
                <a href="/"
                    class="uppercase text-base mx-5 text-white hover:text-develobe-500 duration-200 font-inter">HOME</a>
                <a href="/movies"
                    class="uppercase text-base mx-5 text-white hover:text-develobe-500 duration-200 font-inter">Movies</a>
                <a href="/tv-shows"
                    class="uppercase text-base mx-5 text-white hover:text-develobe-500 duration-200 font-inter">TV
                    Shows</a>
            </div>

            <div class="w-1/3 flex items-center justify-center">
                <a href="/"
                    class="font-bold text-5xl font-quicksand text-white hover:text-develobe-500 duration-200">CINEMOVIE</a>
            </div>

            <div class="w-1/3 flex flex-row justify-end pr-10">
                <a href="/search" class="group">
                    <svg xmlns="http://www.w3.org/2000/svg" height="28" width="28" viewBox="0 0 512 512">
                        <path
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                            class="fill-white group-hover:fill-develobe-500 duration-200" />
                    </svg>
                </a>
            </div>

        </div>

        @php
            
            $title = '';
            $tagline = '';
            $year = '';
            $duration = '';
            $rating = 0;
            
            if ($movieData) {
                $original_date = $movieData->release_date;
                $timestamp = strtotime($original_date);
                $year = date('Y', $timestamp);
                $rating = (int) ($movieData->vote_average * 10);
                $title = $movieData->title;
            
                if ($movieData->tagline) {
                    $tagline = $movieData->tagline;
                } else {
                    $tagline = $movieData->overview;
                }
            
                if ($movieData->runtime) {
                    $hour = (int) ($movieData->runtime / 60);
                    $minute = $movieData->runtime % 60;
                    $duration = "{$hour}h {$minute}m";
                }
            }
            
            // 2 * phi* r . r = 32pixel
            $circumference = ((2 * 22) / 7) * 32;
            $progressRating = $circumference - ($rating / 100) * $circumference;

            $trailerID = "";
            if (isset($movieData->videos->results)){
                foreach($movieData->videos->results as $item){
                    if (strtolower($item->type)=='trailer'){
                        $trailerID = $item->key;
                        break;
                    }
                }
            }
            
        @endphp

        {{-- content section --}}
        <div class="w-full h-full z-10 flex flex-col justify-center px-20">
            <span class="font-quicksand font-bold text-6xl mt-4 text-white">{{ $title }}</span>
            <span class="font-inter italic text-2xl mt-4 text-white max-w-3xl line-clamp-5">{{ $tagline }}</span>

            <div class="flex flex-row mt-4 items-center">
                {{-- rating --}}
                <div class="w-20 h-20 rounded-full flex items-center justify-center mr-4" style="background:#00304D">
                    <svg class="-rotate-90 w-20 h-20">
                        <circle style="color:#004F80;" stroke-width="8" stroke="currentColor" fill="transparent"
                            r="32" cx="40" cy="40" />

                        <circle style="color:#6FCF97;" stroke-width="8" stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $progressRating }}" stroke-linecap="round" stroke="currentColor"
                            fill="transparent" r="32" cx="40" cy="40" />
                    </svg>

                    <span class="absolute font-inter font-bold text-xl text-white">{{ $rating }}%</span>

                </div>

                {{-- year --}}
                <span
                    class="font-inte text-xl text-white bg-transparent rounded-md border border-white p-2 mr-4">{{ $year }}</span>

                {{-- duration --}}
                @if ($duration)
                    <span
                        class="font-inte text-xl text-white bg-transparent rounded-md border border-white p-2">{{ $duration }}</span>
                @endif

            </div>

            {{-- play trailer --}}
            @if($trailerID)
            <button
                class="w-fit bg-develobe-500 text-white pl-4 pr-6 py-3 mt-5 font-inter text-xl flex flex-row rounded-lg items-center hover:drop-shadow-lg duration-200"
                onclick="showTrailer(true)">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="30" viewBox="0 0 384 512"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" fill="white"/></svg>
                <span>Play Trailer</span>
            </button>
            @endif

        </div>

        {{-- trailer section --}}
        <div id="trailerWrapper" class="absolute z-10 w-full h-screen p-20 bg-black flex flex-col">
            <button class="ml-auto group mb-4" onclick="showTrailer(false)">
                <svg xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                    <path d="m12.45 37.65-2.1-2.1L21.9 24 10.35 12.45l2.1-2.1L24 21.9l11.55-11.55 2.1 2.1L26.1 24l11.55 11.55-2.1 2.1L24 26.1Z" class="fill-white group-hover:fill-develobe-500 duration-200"/>
                </svg>
            </button>
            <iframe id="youtubeVideo" class="w-full h-full" src="https://www.youtube.com/embed/{{$trailerID}}?enablejsapi=1" title="{{$movieData->title}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share;" allowfullscreen></iframe>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>

    <script>
        // hide trailer
        $("#trailerWrapper").hide();

        function showTrailer(isVisible){
            if(isVisible){
                // show trailer
                $("#trailerWrapper").show();
            } else{
                // stop youtube video
                $("#youtubeVideo")[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}','*');


                // hide trailer
                $("#trailerWrapper").hide();
            }
        }
    </script>

</body>

</html>

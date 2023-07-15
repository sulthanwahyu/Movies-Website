<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="icon" href="{{asset('img/tbb.png')}}" type="image/x-icon"> --}}
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

<body class="bg-gray-800">
    <div class="w-full h-auto min-h-screen flex flex-col ">
        {{-- Header Section --}}
        @include('header')

        {{-- Banner Section --}}
        <div class="w-full h-[512px] flex flex-col relative bg-black">

            {{-- Banner Data --}}
            @foreach ($banner as $bannerItem)
                @php
                    $bannerImage = "{$imageBaseURL}/original{$bannerItem->backdrop_path}";
                @endphp

                <div class="flex flex-row items-center w-full h-full relative slide">
                    {{-- Image --}}
                    <img src="{{ $bannerImage }}" class="absolute w-full h-full object-cover">
                    {{-- overlay --}}
                    <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

                    <div class="w-10/12 flex flex-col ml-28 z-10">
                        <span class="font-bold font-inter text-4xl text-white">{{ $bannerItem->title }}</span>
                        <span
                            class="font-inter text-xl text-white w-1/2 line-clamp-2">{{ $bannerItem->overview }}</span>

                        <a href="/movie/{{ $bannerItem->id }}"
                            class="w-fit bg-develobe-500 text-white pl-2 py-2 pr-4 mt-5 font-inter text-sm flex flex-row rounded-full items-center hover:drop-shadow-lg duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" height="15" width="24" class="fill-white"
                                viewBox="0 0 384 512">
                                <path
                                    d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                            </svg>
                            <span class="">Detail</span>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Prev Button --}}
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(-1)">

                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 320 512">
                        <path
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </button>

            </div>

            {{-- Next Button --}}
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(1)">

                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 320 512">
                        <path
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </button>

            </div>

            {{-- indicator --}}
            <div class="absolute bottom-0 w-full mb-8">
                <div class="w-full flex flex-row items-center justify-center">
                    @for ($pos = 1; $pos <= count($banner); $pos++)
                        <div class="w-2.5 h-2.5 rounded-full mx-1 cursor-pointer dot "
                            onclick="currentSlide({{ $pos }})"></div>
                    @endfor
                </div>
            </div>

        </div>

        {{-- top 10 movies section --}}
        <div class="mt-12">
            <span class="ml-20 font-inter font-bold text-xl text-white">Top 10 Movies</span>

            <div class="w-auto flex flex-row overflow-x-auto pl-20 pt-6 pb-10 overflow-hidden scrollbar-hidden ">
                @foreach ($topMovies as $movieItem)
                    @php
                        $original_date = $movieItem->release_date;
                        $timestamp = strtotime($original_date);
                        $movieYear = date('Y', $timestamp);
                        
                        $movieID = $movieItem->id;
                        $movieTitle = $movieItem->title;
                        $movieRating = $movieItem->vote_average * 10;
                        $movieImage = "{$imageBaseURL}/w500{$movieItem->poster_path}";
                    @endphp

                    <a href="movie/{{ $movieID }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">

                            <div class="overvlow-hidden rounded-[32px]">
                                <img class="w-full h-[300px] rounded-[32px] group-hover:scale-105 duration-200"
                                    src="{{ $movieImage }}" />
                            </div>

                            <span
                                class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{ $movieTitle }}</span>
                            <span class="font-inter text-sm mt-1">{{ $movieYear }}</span>

                            <div class="flex flex-row mt-1 items-center">
                                <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                    xmlns="https://www.w3.org/2000/svg">
                                    <path
                                        d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z"
                                        fill="#38B6FF" />
                                </svg>
                                <span class="font-inter text-sm ml-1">{{ $movieRating }}%</span>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>

        </div>


        {{-- top 10 tv shows section --}}

        <div>
            <span class="ml-20 font-inter font-bold text-xl text-white">Top 10 TV Shows</span>

            <div class="w-auto flex flex-row overflow-x-auto pl-20 pt-6 pb-10 overflow-hidden scrollbar-hidden">
                @foreach ($topTVShows as $tvShowsItem)
                    @php
                        $original_date = $tvShowsItem->first_air_date;
                        $timestamp = strtotime($original_date);
                        $tvShowsYear = date('Y', $timestamp);
                        
                        $tvShowsID = $tvShowsItem->id;
                        $tvShowsTitle = $tvShowsItem->original_name;
                        $tvShowsRating = $tvShowsItem->vote_average * 10;
                        $tvShowsImage = "{$imageBaseURL}/w500{$tvShowsItem->poster_path}";
                    @endphp


                    <a href="tv/{{ $tvShowsID }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">

                            <div class="overvlow-hidden rounded-[32px]">
                                <img class="w-full h-[300px] rounded-[32px] group-hover:scale-105 duration-200"
                                    src="{{ $tvShowsImage }}" />
                            </div>


                            <span
                                class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{ $tvShowsTitle }}</span>
                            <span class="font-inter text-sm mt-1">{{ $tvShowsYear }}</span>

                            <div class="flex flex-row mt-1 items-center">
                                <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                    xmlns="https://www.w3.org/2000/svg">
                                    <path
                                        d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z"
                                        fill="#38B6FF" />
                                </svg>
                                <span class="font-inter text-sm ml-1">{{ $tvShowsRating }}%</span>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>

        </div>

        {{-- footer section --}}
      @include('footer')


    </div>

    <script>
        // default active slide 
        let slideIndex = 1;
        showSlide(slideIndex);


        function showSlide(position) {
            let index;
            const slidesArray = document.getElementsByClassName('slide');
            const dotsArray = document.getElementsByClassName('dot');

            // looping effect
            if (position > slidesArray.length) {
                slideIndex = 1;
            }

            if (position < 1) {
                slideIndex = slidesArray.length;
            }

            // hide all slide
            for (index = 0; index < slidesArray.length; index++) {
                slidesArray[index].classList.add('hidden');
            }

            // show acive slide
            slidesArray[slideIndex - 1].classList.remove('hidden');

            // remove active status
            for (index = 0; index < dotsArray.length; index++) {
                dotsArray[index].classList.remove('bg-develobe-500');
                dotsArray[index].classList.add('bg-white');
            }

            // set active status
            dotsArray[slideIndex - 1].classList.remove('bg-white');
            dotsArray[slideIndex - 1].classList.add('bg-develobe-500');
        }

        function moveSlide(moveStep) {
            showSlide(slideIndex += moveStep);
        }

        function currentSlide(position) {
            showSlide(slideIndex = position);
        }
    </script>

</body>

</html>


<div class="relative" x-data="{ isOpen: true }" @click.away="isOpen = false">
    <input 
        wire:model.debounce.500ms="search" 
        type="text" 
        class="bg-gray-800 text-sm rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline" 
        placeholder="Search (Press '/' to focus)"
        x-ref="search"
        @keydown.window="
            if (event.keyCode === 191) {
                event.preventDefault();
                $refs.search.focus();
            }
        "
        @focus="isOpen = true"
        @keydown="isOpen = true"
        @keydown.escape.window="isOpen = false"
        @keydown.shift.tab="isOpen = false"
    >
    <div class="absolute top-0">
        <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 128 128"><path d="M79.2 25.5L79.2 25.5c-14.8-14.8-38.9-14.8-53.7 0-14.8 14.8-14.8 38.9 0 53.7 7.4 7.4 17.1 11.1 26.9 11.1s19.5-3.7 26.9-11.1C94 64.4 94 40.3 79.2 25.5zM75 75c-12.5 12.5-32.8 12.5-45.3 0-12.5-12.5-12.5-32.8 0-45.3 6.2-6.2 14.4-9.4 22.6-9.4 8.2 0 16.4 3.1 22.6 9.4C87.4 42.2 87.4 62.5 75 75zM104.7 113.7c2.3 0 4.6-.9 6.4-2.6l0 0c3.5-3.5 3.5-9.2 0-12.7L98.3 85.6c-1.7-1.7-4-2.6-6.4-2.6-1.4 0-2.7.3-3.9.9l-2.5-2.5c-1.2-1.2-3.1-1.2-4.2 0-1.2 1.2-1.2 3.1 0 4.2l2.5 2.5c-.6 1.2-.9 2.5-.9 3.9 0 2.4.9 4.7 2.6 6.4L98.3 111C100.1 112.8 102.4 113.7 104.7 113.7zM88.9 91.9c0-.8.3-1.6.9-2.1.6-.6 1.3-.9 2.1-.9s1.6.3 2.1.9l12.7 12.7c1.2 1.2 1.2 3.1 0 4.2-1.2 1.2-3.1 1.2-4.2 0L89.8 94.1C89.2 93.5 88.9 92.7 88.9 91.9z"/><path d="M52.3 26.3C45.4 26.3 38.9 29 34 34c-4.7 4.7-7.3 10.8-7.6 17.4-.1 1.7 1.2 3 2.9 3.1 0 0 .1 0 .1 0 1.6 0 2.9-1.3 3-2.9.2-5.1 2.3-9.8 5.8-13.4 3.8-3.8 8.8-5.9 14.1-5.9 1.7 0 3-1.3 3-3S54 26.3 52.3 26.3zM35 64A3 3 0 1 0 35 70 3 3 0 1 0 35 64z"/></svg>
    </div>
    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>
    @if(strlen($search) >= 2)
        <div 
            class="z-50 absolute bg-gray-800 text-sm rounded w-64 mt-4" 
            x-show.transition.opacity="isOpen"
        >
            @if ($searchResults->count() > 0)
                <ul>
                    @foreach($searchResults as $result) 
                        <li class="border-b border-gray-700">
                            <a 
                                href="{{ route('movies.show', $result['id']) }}" 
                                class="block hover:bg-gray-700 px-3 py-3 flex items-center"
                                @if ($loop->last) @keydown.tab="isOpen = false" @endif
                            >
                                @if ($result['poster_path'])
                                    <img src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="poster" class="w-8">
                                @else
                                    <img src="https://via.placeholder.com/50x75" alt="poster" class="w-8">
                                @endif
                                <span class="ml-4">{{ $result['title'] }}</span>
                            </a>
                        </li>
                    @endforeach  
                </ul>
            @else
                <div class="px-3 py-3">No results for "{{ $search }}"</div>
            @endif
        </div>
    @endif
</div>


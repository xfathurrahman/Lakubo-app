<div class="bg-white pb-4 mx-2 sm:mx-0 flex items-center flex-wrap">
    <ul class="flex items-center bg-gray-100 rounded-md px-2">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-500">
                <svg class="w-5 h-auto fill-current mx-2 text-gray-400 hover:text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z"/></svg>
            </a>
            <span class="mx-2 h-auto text-gray-400 font-medium mb-1"> <i class="fa-solid fa-chevron-right text-xs mr-3"></i> </span>
        </li>
        <li class="inline-flex items-center">
            <p class="text-xs md:text-sm font-medium text-gray-600 text-blue-500 line-clamp-2">
                {{ $productsCategoryName }}
            </p>
        </li>
    </ul>
</div>

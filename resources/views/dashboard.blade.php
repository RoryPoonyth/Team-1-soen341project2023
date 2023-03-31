<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-12">
                        <h2 class="text-2xl font-medium text-gray-900 title-font px-4">
                            @if (Auth::user()->is_employer)
                                All jobs Created
                            @else
                                All jobs applied to
                            @endif
                            ({{ $listings->count() }})
                        </h2>
                    </div>
                    <div class="-my-6">
                        @foreach($listings as $listing)
                            <a
                                href="{{ route('applications.show', $listing->slug) }}"
                                class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100
                                {{ $listing->is_highlighted ? 'bg-yellow-100 hover:bg-yellow-200' : 'bg-white hover:bg-gray-100' }}"
                            >
                                <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                                    <img src="/storage/{{ $listing->logo }}" alt="{{ $listing->company }}
                                    logo" class="w-16 h-16 rounded-full object-cover">
                                </div>
                                <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                                    <h2 class="text-xl font-bold text-gray-900 title-font mb-1">{{ $listing->title }}</h2>
                                    <p class="leading-relaxed text-gray-900">
                                        {{ $listing->company }} &mdash; <span class="text-gray-600">{{ $listing->location }}</span>
                                    </p>
                                </div>
                                <div class="md:flex-grow mr-8 flex items-center justify-start">
                                    @foreach($listing->tags as $tag)
                                       <span class="inline-block ml-2 tracking-wide text-xs font-medium title-font py-0.5 px-1.5 border border-indigo-500 uppercase
                                       {{ $tag->slug === request()->get('tag') ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }}">
                                           {{ $tag->name }}
                                       </span>
                                    @endforeach
                                </div>
                                <span class="md:flex-grow flex items-center justify-end">
                                    <span>{{ $listing->created_at->diffForHumans() }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

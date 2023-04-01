<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="mb-12">
                <h2 class="text-2xl font-medium text-gray-900 title-font">
                    {{ $listing->title }}
                </h2>
                <div class="md:flex-grow mr-8 mt-2 flex items-center justify-start">
                    @foreach ($listing->tags as $tag)
                        <span
                            class="inline-block mr-2 tracking-wide text-indigo-500 text-xs font-medium title-font py-0.5 px-1.5 border
                         border-indigo-500 uppercase">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="-my-6">
                <div class="flex flex-wrap md:flex-nowrap">
                    <div class="content w-full md:w-3/4 pr-4 leading-relaxed text-base">
                        <div class="py-6 px-4 border-b border-gray-100 bg-white">
                            {!! $listing->content !!}
                        </div>
                        @if (Auth::user()->is_employer)
                            <h4 class="text-xl font-medium text-gray-900 title-font mt-5">
                                Applications ({{ $applications->count() }})
                            </h4>
                            @foreach ($applications as $application)
                                <div
                                    class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100 bg-white hover:bg-gray-100">
                                    <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                                        <img src="/storage/{{ $listing->logo }}"
                                            alt="{{ $listing->company }}
                                                logo"
                                            class="w-16 h-16 rounded-full object-cover">
                                    </div>
                                    <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                                        <h2 class="text-xl font-bold text-gray-900 title-font mb-1">
                                            {{ $application->name }}</h2>
                                        <p class="leading-relaxed text-gray-900">
                                            {{ $application->email }} &mdash; <span
                                                class="text-gray-600">{{ $application->status }}</span>
                                        </p>
                                    </div>
                                    <div class="md:flex-grow mr-8 flex items-center justify-start">
                                        <span
                                            class="inline-block ml-2 tracking-wide font-large title-font py-0.5 px-1.5 border border-indigo-500 uppercase bg-white text-indigo-500  hover:bg-indigo-500 hover:text-white">
                                            <a href="{{ Storage::url($application->resume) }}">resume</a>
                                        </span>
                                        <span
                                            class="inline-block ml-2 tracking-wide font-large title-font py-0.5 px-1.5 border border-indigo-500 uppercase bg-white text-indigo-500 hover:bg-indigo-500 hover:text-white">
                                            <a href="{{ route('applications.edit', ['id' => $application->id]) }}">Update
                                                status</a>
                                        </span>
                                    </div>
                                    <span class="md:flex-grow flex items-center justify-end">
                                        <span>{{ $listing->created_at->diffForHumans() }}</span>
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <h4 class="text-xl font-medium text-gray-900 title-font mt-5">
                                Your application
                            </h4>
                            <div
                                class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100 bg-white hover:bg-gray-100">
                                <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                                    <img src="/storage/{{ $listing->logo }}"
                                        alt="{{ $listing->company }}
                                        logo"
                                        class="w-16 h-16 rounded-full object-cover">
                                </div>
                                <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                                    <h2 class="text-xl font-bold text-gray-900 title-font mb-1">
                                        {{ $application->name }}</h2>
                                    <p class="leading-relaxed text-gray-900">
                                        {{ $application->email }}
                                    </p>
                                </div>
                                <div class="md:flex-grow mr-8 flex items-center justify-start">
                                    <span
                                        class="inline-block ml-2 tracking-wide  font-large title-font py-0.5 px-1.5 border border-indigo-500 uppercase bg-white text-indigo-500">
                                        <a href="{{ Storage::url($application->resume) }}">resume</a>
                                    </span>
                                    <span
                                        class="inline-block ml-2 tracking-wide  font-large title-font py-0.5 px-1.5 border border-indigo-500 uppercase bg-white text-indigo-500
                                        {{ $application->status === 'accepted'
                                            ? 'bg-green-500 border-green-500 text-white'
                                            : ($application->status === 'refused'
                                                ? 'bg-rose-500 border-rose-500 text-white'
                                                : 'bg-indigo-500 border-indigo-500 text-white') }}">
                                        {{ $application->status }}
                                    </span>
                                </div>
                                <span class="md:flex-grow flex items-center justify-end">
                                    <span>{{ $listing->created_at->diffForHumans() }}</span>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="w-full md:w-1/4 pl-4">
                        <img src="/storage/{{ $listing->logo }}" alt="{{ $listing->company }} logo"
                            class="max-w-full mb-4">
                        <p class="leading-relaxed text-base">
                            <strong>Location: </strong>{{ $listing->location }}<br>
                            <strong>Company: </strong>{{ $listing->company }}
                            @if (Auth::user()->is_employer)
                                <a href="{{ route('listings.edit', $listing->id ) }}" class="block text-center my-4 tracking-wide
                                 bg-white text-indigo-500 text-sm font-medium title-font py-2 border border-indigo-500 hover:bg-indigo-500 hover:text-white uppercase">
                                    Update Job Status
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

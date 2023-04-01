<header class="text-gray-600 body-font border-b border-gray-100">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a href="{{ route('listings.index') }}"
            class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full"
                viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ml-3 text-xl">Laravel Job Board</span>
        </a>

        @guest
            <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
                <a href="{{ route('login') }}" class="mr-5 hover:text-gray-900">Login</a>
            </nav>
            <a href="{{ route('register') }}"
                class="inline-flex items-center bg-indigo-500 text-white border-0 py-1 px-3 focus:outline-none hover:bg-indigo-600 rounded text-base mt-4 md:mt-0">Register
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
        <div class="md:ml-auto">
            <x-dropdown align="right" width="48" >
                <x-slot name="trigger">
                    <button
                        class="py-2 pl-3 pr-9 text-lg font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                        {{ Auth::user()->name }}
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 14l-5-5 1.41-1.41L10 11.17l3.59-3.58L15 9l-5 5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-dropdown-link>
                    @if (Auth::user()->is_employer)
                        <x-dropdown-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                            Create Listing
                        </x-dropdown-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Logout
                        </x-dropdown-link>
                    </form>
                </x-slot>

            </x-dropdown>
        </div>
        @endguest
    </div>
</header>


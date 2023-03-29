<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="w-full md:w-1/2 py-24 mx-auto">
            <div class="mb-4">
                <h2 class="text-2xl font-medium text-gray-900 title-font">
                    Apply to Job
                </h2>
            </div>
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-200 text-red-800">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form
                action="{{ route('applications.store', $listing->slug) }}"
                id="application_form"
                method="post"
                enctype="multipart/form-data"
                class="bg-gray-100 p-4"
            >
                    <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                            <x-input-label for="name" value="Full Name" />
                            <x-text-input
                                class="block mt-1 w-full"
                                id="name"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required />
                        </div>
                        <div class="flex-1 mx-2">
                            <x-input-label for="email" value="Email Address" />
                            <x-text-input
                                class="block mt-1 w-full"
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus />
                        </div>
                        <div class="flex-1 mx-2">
                            <x-input-label for="phone" value="Phone Number" />
                            <x-text-input
                                class="block mt-1 w-full"
                                id="phone"
                                type="text"
                                name="phone"
                                :value="old('phone')"
                                required
                                autofocus />
                        </div>
                    </div>
                @guest
                    <div class="flex mb-4">
                        <div class="flex-1 mx-2">
                            <x-input-label for="password" value="Password" />
                            <x-text-input
                                class="block mt-1 w-full"
                                id="password"
                                type="password"
                                name="password"
                                required />
                        </div>
                        <div class="flex-1 mx-2">
                            <x-input-label for="password_confirmation" value="Confirm Password" />
                            <x-text-input
                                class="block mt-1 w-full"
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required />
                        </div>
                    </div>
                @endguest
                <div class="mb-4 mx-2">
                    <x-input-label for="resume" value="Resume" />
                    <x-text-input
                        id="resume"
                        class="block mt-1 w-full"
                        type="file"
                        name="resume"
                        required />
                </div>
                <div class="mb-4 mx-2">
                    <x-input-label for="cover->letter" value="Listing Content (Markdown is okay)" />
                    <textarea
                        id="content"
                        rows="8"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                        name="content"
                    ></textarea>
                </div>
                <div class="mb-2 mx-2">
                    <button type="submit" id="form_submit" class="block w-full items-center bg-indigo-500 text-white border-0 py-2 focus:outline-none hover:bg-indigo-600 rounded text-base mt-4 md:mt-0">Submit Application</button>
                </div>
            </form>
        </div>
    </section>
    <script>
        document.getElementById('form_submit').addEventListener('click', async (e) => {
            // prevent the submission of the form immediately
            e.preventDefault();
            if (error) {
                alert(error.message);
            } else {
                document.getElementById('application_form').submit();
            }
        })
    </script>
</x-app-layout>

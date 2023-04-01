<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="w-full md:w-1/2 py-24 mx-auto">
            <div class="mb-4">
                <h2 class="text-2xl font-medium text-gray-900 title-font">
                    Update Application Status
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

            <form action="{{ route('listings.update', $id ) }}" id="active_form" method="POST"
                enctype="multipart/form-data" class="bg-gray-100 p-4">
                @csrf
                @method("PATCH")

                <div class="mb-4 mx-2">
                    <label for="is_active">Update the status of this listing </label>
                    <select name="is_active" id="is_active" class="block mt-1 w-full">
                        <option value="1">Is Active</option>
                        <option value="0">Is not Active</option>
                    </select>
                </div>

                <div class="mb-2 mx-2">
                    @csrf
                    <button type="submit" id="form_submit"
                        class="block w-full items-center bg-indigo-500 text-white border-0 py-2 focus:outline-none hover:bg-indigo-600 rounded text-base mt-4 md:mt-0">
                        Update status
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
    document.getElementById('form_submit').addEventListener('click', async (e) => {
        // prevent the submission of the form immediately
        e.preventDefault();
        document.getElementById('active_form').submit();
    })
    </script>
</x-app-layout>
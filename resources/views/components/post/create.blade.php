@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush
<div class="max-w-4xl relative p-4 bg-white rounded-lg border dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Post</h3>
    </div>

    <!-- Modal body -->
    <form action="/dashboard" method="POST" id="post-form">
        @csrf
        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" name="title" id="title"
                class="border @error('title')bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="Type post title" value="{{ old('title') }}" autofocus>
            @error('title')
                <p class="mt-2 text-xs text-red-600 dark:text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="category"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label><select
                id="category" name="category_id"
                class="border @error('category_id')bg-red-50 border-red-500 text-red-700 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option selected="" value="">Select post category</option>
                @foreach (App\Models\Category::get() as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-2 text-xs text-red-600 dark:text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
            <textarea id="body" name="body" rows="4"
                class="hidden block p-2.5 w-full text-sm text-gray-900 rounded-lg border @error('body')bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="Write post body here"></textarea>
            <div id="editor">
            </div>
            @error('body')
                <p class="mt-2 text-xs text-red-600 dark:text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit"
                class="text-white inline-flex items-center cursor-pointer bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add new post
            </button>
            <a href="/dashboard"
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 cursor-pointer focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write post body here...',
            modules: {
                toolbar: [
                    [{
                        font: []
                    }],
                    [{
                        header: [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                    ['blockquote', 'code-block'],

                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    [{
                        script: 'sub'
                    }, {
                        script: 'super'
                    }], // superscript/subscript
                    [{
                        indent: '-1'
                    }, {
                        indent: '+1'
                    }], // outdent/indent
                    [{
                        direction: 'rtl'
                    }], // text direction
                    [{
                        size: ['small', false, 'large', 'huge']
                    }], // custom dropdown
                    [{
                        color: []
                    }, {
                        background: []
                    }], // dropdown with defaults from theme
                    [{
                        align: []
                    }],

                    ['clean'], // remove formatting button

                    ['link', 'image', 'video'] // link and image, video
                ]
            }
        });

        const postForm = document.querySelector('#post-form');
        const postBody = document.querySelector('#body');
        const quillEditor = document.querySelector('#editor');

        postForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const content = quill.root.innerHTML;
            postBody.value = content;
            this.submit();
        })
    </script>
@endpush

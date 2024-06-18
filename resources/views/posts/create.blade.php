<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Create Posts') }}
      </h2>
  </x-slot>

  {{-- <div class="py-1 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-whiteoverflow-hidden shadow-sm sm:rounded-lg"> --}}
      <form action="{{ route('posts.store') }}" class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12" method="POST">
          @csrf
          <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" id="title" name= "title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Title" required />
          </div>
          <div class="form-group">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
            <textarea id="content" name="content" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Content"></textarea>
          </div>
          <div class="py-10">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">Create New Post
            </button>
      </form>
    {{-- </div>
  </div> --}}

</x-app-layout>
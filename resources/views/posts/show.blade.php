<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Replying to ' . $post->user->name) }}
      </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    <!-- Showing the post that want to reply -->
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-200">
        <a href="{{ route('posts.index') }}" class="text-blue-500">Back</a>
        <br>
        <br>
        <div class="card mb-3">
            <div class="card-body">
                <h1 class="text-2xl font-semibold">{{ $post->title }}</h1>
                <p class="text-gray-500 text-xl">{{ $post->content }}</p>
            </div>
        </div>
    </div>

    <!-- Reply form -->
    <div class="p-6 bg-white dark:bg-gray-800 dark:text-gray-200">
        <form action="{{ route('posts.reply', ['post' => $post->id]) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="content" class="sr-only">Content</label>
                <textarea name="content" id="content" cols="30" rows="4" class="bg-gray-100 border-2 w-full p-4 rounded-lg text-black @error('content') border-red-500 @enderror" placeholder="Reply to this post"></textarea>
                @error('content')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Reply</button>
            </div>
        </form>
    </div>
  </div>
  


</x-app-layout>
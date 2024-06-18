<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Post</a>
        </div>
    </div>

    <div class="py-0">
        @forelse ($posts as $post)
            <div class="py-1 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title font-bold">{{ $post->title }}</h5>
                                <p class="card-text">{{ $post->user->name . " | " . $post->published_at->diffForHumans() }}</p>
                                <p class="card-text mt-4">{{ $post->content }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex justify-start">
                                <!-- Reply Button -->
                                <a href="{{ route('posts.show', ['post' => $post]) }}" class='hover:underline hover:font-bold text-blue-400 hover:text-blue-500'>Reply</a>
                            </div>
                            <div class="flex space-x-2">
                                <!-- Like Button -->
                                <form action="{{ route('posts.like', ['post' => $post]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-like hover:underline hover:font-bold hover:text-blue-400">
                                        Like {{ $post->likes_count }}
                                    </button>
                                </form>
                                
                                <!-- Share Button -->
                                <form action="{{ route('posts.share', ['post' => $post]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-like hover:underline hover:font-bold hover:text-blue-400">
                                        Share {{ $post->shares_count }}
                                    </button>
                                </form>
                            </div>
                        </div>
        
                        <!-- Include recursive component to display nested replies -->
                        @include('components.post-replies', ['replies' => $post->replies])
                    </div>
                </div>
            </div>
        @empty
            <p>No posts found.</p>
        @endforelse
    </div>
</x-app-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replyLinks = document.querySelectorAll('.reply-link');
            replyLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    console.log('Reply link clicked');
                    const postId = this.getAttribute('data-post-id');
                    console.log('Reply link clicked for post ID:', postId);
                    const replyForm = document.getElementById(`reply-form-${postId}`);
                    if (replyForm) {
                        console.log('Toggling reply form visibility for post ID:', postId);
                        replyForm.classList.toggle('hidden');
                    } else {
                        console.error('Reply form not found for post ID:', postId);
                    }
                });
            });

            // AJAX form submission for reply
            const replyForms = document.querySelectorAll('.reply-form form');
            replyForms.forEach(form => {
                console.log('Adding submit event listener to reply form');
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Reply submitted:', data);
                        document.getElementById(`form-reply-${data.post_id}`).reset(); // Clear form fields
                        document.getElementById(`reply-form-${data.post_id}`).classList.add('hidden'); // Hide reply form
                        // Optionally, update UI to display newly added reply without refreshing the page
                    })
                    .catch(error => {
                        console.error('Error submitting reply:', error);
                        // Handle error scenario, e.g., display error message
                    });
                });
            });
        });
    </script>
@endpush

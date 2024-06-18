@props(['replies'])

@if($replies->isNotEmpty())
    <div class="mt-4 ml-4">
        @foreach($replies as $reply)
            <div class="card mb-3">
              <div class="card-body">
                  
                  <p class="card-text">{{ $reply->user->name }} | {{ $reply->published_at->diffForHumans() }}</p>
                  <p class="card-text">{{ $reply->content }}</p>
                  {{-- <p>Likes: {{ $reply->likes->count() }} | Shares: {{ $reply->shares->count() }}</p> --}}
                  <div class="flex justify-start space-x-2">
                    <a href="{{ route('posts.show', ['post' => $reply]) }}" class='hover:underline hover:font-bold text-blue-400 hover:text-blue-500'>Reply</a>
                    <form action="{{ route('posts.like', ['post' => $reply]) }}" method="POST">
                      @csrf
                      <button type="submit" class='hover:underline hover:font-bold hover:text-gray-400'>Like {{ $reply->likes->count() }}</button>
                    </form>
                  
                    <form action="{{ route('posts.share', ['post' => $reply]) }}" method="POST">
                        @csrf
                        <button type="submit" class='hover:underline hover:font-bold hover:text-gray-400'>Share {{ $reply->shares->count() }}</button>
                    </form>
                  </div>
              </div>
              <!-- Recursive call to include nested replies -->
              @include('components.post-replies', ['replies' => $reply->replies])
            </div>
        @endforeach
    </div>
@endif
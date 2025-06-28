<x-customer-layout title="Give Feedback">
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    <div class="max-w-xl mx-auto mt-6 md:mt-10 bg-white p-6 md:p-8 rounded-lg shadow">
      <h2 class="text-xl md:text-2xl font-bold mb-4 text-indigo-700">Feedback for {{ $event->event_name }}</h2>
      <form action="{{ route('feedback.store', $event->id) }}" method="POST" class="space-y-6">
        @csrf

        <div x-data="{ rating: {{ old('rating', 0) }} }">
          <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
          <div class="flex items-center space-x-2">
            @for ($i = 1; $i <= 5; $i++)
              <button type="button"
                @click="rating = {{ $i }}"
                @keydown.enter="rating = {{ $i }}"
                :aria-checked="rating === {{ $i }}"
                class="focus:outline-none focus:ring-0"
                :class="{}"
                tabindex="0">
                <svg class="w-6 h-6 md:w-8 md:h-8 cursor-pointer" fill="none" viewBox="0 0 20 20">
                  <path 
                    :fill="rating >= {{ $i }} ? '#facc15' : '#fff'"
                    :stroke="rating >= {{ $i }} ? '#facc15' : '#d1d5db'"
                    stroke-width="2"
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.364 1.118l1.287 3.966c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.045 9.394c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z"/>
                </svg>
              </button>
            @endfor
          </div>
          <input type="hidden" name="rating" x-model="rating">
          @error('rating')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title (optional)</label>
          <input type="text" name="title" id="title" value="{{ old('title') }}"
                 class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          @error('title')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div>
          <label for="comments" class="block text-sm font-medium text-gray-700 mb-1">Comments</label>
          <textarea name="comments" id="comments" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('comments') }}</textarea>
          @error('comments')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex justify-end">
          <button type="submit"
                  class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
            Submit Feedback
          </button>
        </div>
      </form>
    </div>
  </main>
</x-customer-layout>
<x-layout title="Edit Book">
    <div class="p-8 max-w-4xl mx-auto">
        <div class="bg-slate-900/90 rounded-3xl shadow-xl border border-white/10 overflow-hidden">
            <div class="bg-slate-800/80 px-8 py-6 border-b border-white/10">
                <h1 class="text-3xl font-bold text-white">Edit Book</h1>
                <p class="text-slate-400 mt-1">Update the book details below.</p>
            </div>

            <div class="p-8 space-y-6">
                @if($errors->any())
                    <div class="rounded-xl bg-red-500/10 border border-red-500/30 text-red-200 px-4 py-3">
                        <div class="font-semibold">Please fix the following:</div>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/books/{{ $book->id }}" class="grid gap-4 lg:grid-cols-2" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Title</label>
                        <input type="text" name="title" value="{{ old('title', $book->title) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Author</label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Genre</label>
                        <select name="genre" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                            <option value="">Select genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" {{ old('genre', $book->genre) === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Published Year</label>
                        <input type="number" name="published_year" value="{{ old('published_year', $book->published_year) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" min="1000" max="2100" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Number of Pages</label>
                        <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" min="1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Language</label>
                        <input type="text" name="language" value="{{ old('language', $book->language) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Publisher</label>
                        <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Price</label>
                        <input type="number" name="price" value="{{ old('price', $book->price) }}" step="0.01" min="0" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Cover Image (Optional)</label>
                        @if($book->cover_image)
                            <div class="mt-2 mb-3">
                                <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}" class="h-32 w-24 rounded-lg object-cover">
                                <p class="text-xs text-slate-400 mt-2">Current image</p>
                            </div>
                        @endif
                        <input type="file" name="cover_image" accept="image/jpeg,image/png,image/jpg,image/gif" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white file:bg-indigo-600 file:text-white file:font-semibold file:border-0 file:rounded-lg file:cursor-pointer">
                        <p class="text-xs text-slate-400 mt-1">Max size: 2MB. Supported: JPEG, PNG, JPG, GIF</p>
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-300">Description</label>
                        <textarea name="description" rows="5" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>{{ old('description', $book->description) }}</textarea>
                    </div>

                    <div class="lg:col-span-2 flex items-center gap-4">
                        <label class="flex items-center gap-3 text-slate-300">
                            <input type="checkbox" name="is_available" value="1" {{ old('is_available', $book->is_available) ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-700 bg-slate-950">
                            <span>Available for borrowing</span>
                        </label>
                    </div>

                    <div class="lg:col-span-2 flex items-center justify-between gap-4">
                        <button type="submit" class="rounded-2xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-500 transition">
                            Update Book
                        </button>
                        <a href="/books" class="text-sm text-slate-300 hover:text-white">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

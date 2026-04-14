<x-layout title="Books Management">
    <div class="p-8 max-w-7xl mx-auto">
        <div class="bg-slate-900/90 rounded-3xl shadow-xl border border-white/10 overflow-hidden">
            <div class="bg-slate-800/80 px-8 py-6 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Books Management</h1>
                    <p class="text-slate-400 mt-1">Add, edit, and manage your book collection.</p>
                </div>
                <a href="/books/create" class="rounded-2xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-500 transition">
                    + Add Book
                </a>
            </div>

            <div class="p-8 space-y-6">
                @if(session('success'))
                    <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search & Filter -->
                <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700">
                    <form method="GET" action="/books" class="flex flex-col lg:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">Search by Title or Author</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter title or author..." 
                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-600">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">Filter by Genre</label>
                            <select name="genre" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white">
                                <option value="">All Genres</option>
                                @foreach($genres as $g)
                                    <option value="{{ $g }}" {{ request('genre') === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-500 transition">
                                Search
                            </button>
                            <a href="/books" class="rounded-xl bg-slate-700 px-6 py-3 font-semibold text-white hover:bg-slate-600 transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Books Table -->
                @if($books->isEmpty())
                    <div class="rounded-2xl bg-slate-900/80 p-6 text-slate-400 border border-slate-700 text-center">
                        <p class="mb-3">No books found.</p>
                        <a href="/books/create" class="text-indigo-400 hover:text-indigo-300">Add your first book</a>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-3xl border border-slate-800 bg-slate-900/80">
                        <table class="min-w-full divide-y divide-slate-800 text-sm">
                            <thead class="bg-slate-950/80 text-slate-300">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Cover</th>
                                    <th class="px-4 py-3 text-left font-semibold">Title</th>
                                    <th class="px-4 py-3 text-left font-semibold">Author</th>
                                    <th class="px-4 py-3 text-left font-semibold">Genre</th>
                                    <th class="px-4 py-3 text-left font-semibold">Price</th>
                                    <th class="px-4 py-3 text-left font-semibold">Availability</th>
                                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 text-slate-200">
                                @foreach($books as $book)
                                    <tr class="hover:bg-slate-900/70">
                                        <td class="px-4 py-3">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}" class="h-16 w-12 rounded-lg object-cover">
                                            @else
                                                <div class="h-16 w-12 rounded-lg bg-slate-700 flex items-center justify-center text-xs text-slate-500">No image</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $book->title }}</td>
                                        <td class="px-4 py-3">{{ $book->author }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block px-3 py-1 rounded-lg bg-indigo-500/20 text-indigo-300 text-xs">
                                                {{ $book->genre }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">₱{{ number_format($book->price, 2) }}</td>
                                        <td class="px-4 py-3">
                                            @if($book->is_available)
                                                <span class="inline-block px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 text-xs">Available</span>
                                            @else
                                                <span class="inline-block px-3 py-1 rounded-lg bg-rose-500/20 text-rose-300 text-xs">Unavailable</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 space-x-2">
                                            <a href="/books/{{ $book->id }}/edit" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-500 inline-block">View/Edit</a>
                                            <form method="POST" action="/books/{{ $book->id }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500" onclick="return confirm('Delete this book?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="text-center py-6 bg-slate-950/50 border-t border-white/10 text-slate-400 text-sm">
                Total Books: <span class="font-bold text-white">{{ $books->count() }}</span>
            </div>
        </div>
    </div>
</x-layout>

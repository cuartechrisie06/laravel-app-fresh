<x-layout title="User Registration">
    <div class="p-8 max-w-6xl mx-auto">
        <div class="bg-slate-900/90 rounded-3xl shadow-xl border border-white/10 overflow-hidden">
            <div class="bg-slate-800/80 px-8 py-6 border-b border-white/10">
                <h1 class="text-3xl font-bold text-white">User Registration</h1>
                <p class="text-slate-400 mt-1">Enter user details, save them to the database, and manage users below.</p>
            </div>

            <div class="p-8 space-y-6">
                @if(session('success'))
                    <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

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

                <form method="POST" action="{{ isset($user) ? '/users/'.$user->id : '/users' }}" class="grid gap-4 lg:grid-cols-2">
                    @csrf
                    @if(isset($user))
                        @method('PATCH')
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Nickname</label>
                        <input type="text" name="nickname" value="{{ old('nickname', $user->nickname ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300">Age</label>
                        <input type="number" name="age" value="{{ old('age', $user->age ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" min="1" max="120" required>
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-300">Address</label>
                        <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-300">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number ?? '') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" required>
                    </div>

                    <div class="lg:col-span-2 flex items-center justify-between gap-4">
                        <button type="submit" class="rounded-2xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-500 transition">
                            {{ isset($user) ? 'Update User' : 'Save User' }}
                        </button>
                        @if(isset($user))
                            <a href="/users" class="text-sm text-slate-300 hover:text-white">Cancel edit</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-slate-950/90 p-8 border-t border-white/10">
                <h2 class="text-xl font-bold text-white mb-4">Registered Users</h2>

                @if($users->isEmpty())
                    <div class="rounded-2xl bg-slate-900/80 p-6 text-slate-400 border border-slate-700">
                        No users found. Submit the form above to add a user.
                    </div>
                @else
                    <div class="overflow-x-auto rounded-3xl border border-slate-800 bg-slate-900/80">
                        <table class="min-w-full divide-y divide-slate-800 text-sm">
                            <thead class="bg-slate-950/80 text-slate-300">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Name</th>
                                    <th class="px-4 py-3 text-left font-semibold">Email</th>
                                    <th class="px-4 py-3 text-left font-semibold">Age</th>
                                    <th class="px-4 py-3 text-left font-semibold">Contact</th>
                                    <th class="px-4 py-3 text-left font-semibold">Nickname</th>
                                    <th class="px-4 py-3 text-left font-semibold">Address</th>
                                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 text-slate-200">
                                @foreach($users as $item)
                                    <tr class="hover:bg-slate-900/70">
                                        <td class="px-4 py-3">{{ $item->name }}</td>
                                        <td class="px-4 py-3">{{ $item->email }}</td>
                                        <td class="px-4 py-3">{{ $item->age }}</td>
                                        <td class="px-4 py-3">{{ $item->contact_number }}</td>
                                        <td class="px-4 py-3">{{ $item->nickname ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $item->address }}</td>
                                        <td class="px-4 py-3 space-x-2">
                                            <a href="/users/{{ $item->id }}/edit" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-500">Edit</a>
                                            <form method="POST" action="/users/{{ $item->id }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500" onclick="return confirm('Delete this user?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

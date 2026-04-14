<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Ideas;
use App\Models\Post;
use App\Models\User;
use App\Models\Book;

Route::view('/', 'welcome', [
    'greeting' => 'Hello, World!',
    'name' => 'John Doe',
    'age' => 30,
    'tasks' => [
        'Learn Laravel',
        'Build a project',
        'Deploy to production',
    ],
]);

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::get('/formtest', function(){
    $posts = Post::all();

    return view('formtest',[
        'posts' => $posts,
    ]);
});

Route::post('/formtest', function(){
    Post::create([
        'description' => request('description'),
    ]);

    return redirect('/formtest');
});

Route::delete('/formtest/{id}', function ($id) {
    Post::findOrFail($id)->delete();

    return redirect('/formtest');
});

Route::get('/delete', function(){
    Post::truncate();  

    return redirect('/formtest');
});

Route::get('/users', function () {
    return view('user_registration', [
        'users' => User::orderBy('created_at', 'desc')->get(),
    ]);
});

Route::get('/users/{user}/edit', function (User $user) {
    return view('user_registration', [
        'users' => User::orderBy('created_at', 'desc')->get(),
        'user' => $user,
    ]);
});

Route::post('/users', function () {
    $attributes = request()->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'nickname' => 'nullable|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'age' => 'required|integer|min:1|max:120',
        'address' => 'required|string|max:500',
        'contact_number' => 'required|string|max:50',
    ]);

    $attributes['name'] = trim($attributes['first_name'].' '.$attributes['middle_name'].' '.$attributes['last_name']);

    User::create($attributes);

    return redirect('/users');
});

Route::patch('/users/{user}', function (User $user) {
    $attributes = request()->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'nickname' => 'nullable|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        'age' => 'required|integer|min:1|max:120',
        'address' => 'required|string|max:500',
        'contact_number' => 'required|string|max:50',
    ]);

    $attributes['name'] = trim($attributes['first_name'].' '.$attributes['middle_name'].' '.$attributes['last_name']);

    $user->update($attributes);

    return redirect('/users');
});

Route::delete('/users/{user}', function (User $user) {
    $user->delete();

    return redirect('/users');
});

// Books CRUD
Route::get('/books', function () {
    $query = Book::query();
    
    // Search by title or author
    if (request('search')) {
        $search = request('search');
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('author', 'like', "%$search%");
        });
    }
    
    // Filter by genre
    if (request('genre')) {
        $query->where('genre', request('genre'));
    }
    
    $books = $query->orderBy('created_at', 'desc')->get();
    $genres = Book::distinct()->pluck('genre')->sort();
    
    return view('books.index', [
        'books' => $books,
        'genres' => $genres,
    ]);
});

Route::get('/books/create', function () {
    $genres = ['Fiction', 'Non-Fiction', 'Sci-Fi', 'Mystery', 'Romance', 'Thriller', 'Biography', 'History', 'Self-Help', 'Fantasy'];
    
    return view('books.create', [
        'genres' => $genres,
    ]);
});

Route::post('/books', function () {
    $attributes = request()->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'description' => 'required|string',
        'genre' => 'required|string',
        'published_year' => 'required|integer|min:1000|max:2100',
        'isbn' => 'required|string|unique:books,isbn',
        'pages' => 'required|integer|min:1',
        'language' => 'required|string',
        'publisher' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_available' => 'nullable|boolean',
    ]);
    
    $attributes['is_available'] = request()->has('is_available');
    
    if (request()->hasFile('cover_image')) {
        $path = request()->file('cover_image')->store('covers', 'public');
        $attributes['cover_image'] = $path;
    }
    
    Book::create($attributes);
    
    return redirect('/books');
});

Route::get('/books/{book}/edit', function (Book $book) {
    $genres = ['Fiction', 'Non-Fiction', 'Sci-Fi', 'Mystery', 'Romance', 'Thriller', 'Biography', 'History', 'Self-Help', 'Fantasy'];
    
    return view('books.edit', [
        'book' => $book,
        'genres' => $genres,
    ]);
});

Route::patch('/books/{book}', function (Book $book) {
    $attributes = request()->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'description' => 'required|string',
        'genre' => 'required|string',
        'published_year' => 'required|integer|min:1000|max:2100',
        'isbn' => 'required|string|unique:books,isbn,'.$book->id,
        'pages' => 'required|integer|min:1',
        'language' => 'required|string',
        'publisher' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_available' => 'nullable|boolean',
    ]);
    
    $attributes['is_available'] = request()->has('is_available');
    
    if (request()->hasFile('cover_image')) {
        if ($book->cover_image) {
            \Storage::disk('public')->delete($book->cover_image);
        }
        $path = request()->file('cover_image')->store('covers', 'public');
        $attributes['cover_image'] = $path;
    }
    
    $book->update($attributes);
    
    return redirect('/books');
});

Route::delete('/books/{book}', function (Book $book) {
    if ($book->cover_image) {
        \Storage::disk('public')->delete($book->cover_image);
    }
    $book->delete();
    
    return redirect('/books');
});

//index
Route::get('/posts', function(){
    $posts = Post::all();

    return view('posts.index', [
        'posts' => $posts,
    ]);
});

//show
Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show', [
        'post' => $post,
    ]);
});

//edit
Route::get('/posts/{post}/edit', function (Post $post) {
    return view('posts.edit', [
        'post' => $post,
    ]);
}
);

//update
Route::patch('/posts/{post}', function (Post $post) {
    $post->update([
        'description' => request('description'),
        'updated_at' => now(),
    ]);

    return redirect('/posts' . '/' . $post->id);
}
);

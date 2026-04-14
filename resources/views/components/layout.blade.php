@props([
    'title' => 'My Laravel App',
])
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head> 
<style>
    body{
        background-color: #1c3056;
        color: white;
        font-family: Arial, sans-serif;
    }
    nav{
        background-color:rgb(252, 248, 242);
        padding: 10px;
        color:#000000;
        font-weight: bold;
    }
    a{
        padding: 10px;
    }
    </style>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/contact">Contact</a>
        <a href="/formtest">Form Test</a>
        <a href="/posts">Posts</a>
        <a href="/users">User Registration</a>
        <a href="/books">Books</a>
    </nav>
{{ $slot }}

</body>
</html>
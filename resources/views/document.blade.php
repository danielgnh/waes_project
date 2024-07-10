<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .signature {
            margin-top: 50px;
            border-top: 2px solid black;
            width: 200px;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Document Title</h1>
<p><strong>Full Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
<p><strong>Date:</strong> {{ $date }}</p>
<div class="signature">
    <p>{{$user->signature}}</p>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
    </svg>
</div>
</body>
</html>

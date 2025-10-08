<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Paste</title>
    <style>
        .is-invalid { color: red; }
    </style>
</head>
<body>
    <h2>Add Paste</h2>
    <form method="POST" action="{{ url('/paste/store') }}">
        @csrf

        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}">
        @error('title')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <label>Main Text</label>
        <textarea id="main_text" name="main_text" rows="10" cols="30" required></textarea><br><br>
        @error('main_text')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <label>Expiration</label>
        <select name="expiration">
            <option value="">-- select --</option>
            <option value="24" {{ old('expiration') == '1 day' ? 'selected' : '' }}>1 day</option>
            <option value="72" {{ old('expiration') == '3 days' ? 'selected' : '' }}>3 days</option>
            <option value="168" {{ old('expiration') == '7 days' ? 'selected' : '' }}>7 days</option>
            <option value="720" {{ old('expiration') == '30 days' ? 'selected' : '' }}>30 days</option>
        </select>
        @error('expiration')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <label>Access</label>
        <select name="access">
            <option value="">-- select --</option>
            <option value="false" {{ old('access') == 'public' ? 'selected' : '' }}>Public</option>
            <option value="true" {{ old('access') == 'private' ? 'selected' : '' }}>Private</option>
        </select>
        @error('access')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <input type="submit" value="Create">
    </form>
</body>
</html>
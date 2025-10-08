<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Paste</title>
    <style>
        .is-invalid { color: red; }
    </style>
</head>
<body>
    <h2>Edit Paste</h2>
    <form method="POST" action="{{ url('/paste/update/'.$paste->id) }}">
        @csrf

        <label>Title</label>
        <input type="text" name="title" value="{{ old('title', $paste->title) }}">
        @error('title')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <label>Main Text</label>
        <textarea name="main_text" rows="10" cols="30">{{ old('main_text', $paste->main_text) }}</textarea>
        @error('main_text')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <label>Expiration</label>
        <input type="text" name="expiration" value="{{ old('expiration', $paste->expiration) }}">
        @error('expiration')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <label>Access</label>
        <select name="access">
            <option value="false" {{ old('access', $paste->access) == 'public' ? 'selected' : '' }}>Public</option>
            <option value="true" {{ old('access', $paste->access) == 'private' ? 'selected' : '' }}>Private</option>
        </select>
        @error('access')
            <div class="is-invalid">{{ $message }}</div>
        @enderror
        <br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
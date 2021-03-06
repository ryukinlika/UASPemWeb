@extends('layouts.adminapp')

@section('content')
<div class="container">
    <form action="{{ route('movies.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title :</label>
            <input type="text" class="form-control" id="title" name="title" >
        </div>
        <div class="form-group">
            <label for="director">Director :</label>
            <input type="text" class="form-control" id="director" name="director" >
        </div>
        <div class="form-group">
            <label for="synopsis">Synopsis :</label>
            <textarea type="text" class="form-control" id="synopsis" name="synopsis"></textarea>
        </div>
        <div class="form-group">
            <label for="time">Duration :</label>
            <input type="number" class="form-control" id="time" name="time" >
        </div>
        <div class="form-group">
            <label for="age">Age Rating:</label>
            {{-- <input type="number" class="form-control" id="age" name="age"> --}}
            <select class="form-control form-control-md" id="age" name="age">
                <option value="G">General Audiences (G)</option>
                <option value="PG">Parental Guidance Suggested (PG)</option>
                <option value="PG-13">Parents Strongly Cautioned (PG-13)</option>
                <option value="R">Restricted (R)</option>
                <option value="NC-17">Adults Only (NC-17)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="categories">Categories (separates with commas):</label>
            <input type="text" class="form-control" id="categories" name="categories" placeholder="e.g. Funny,Romance,Adventure">
        </div>
        <div class="form-group">
            <label for="casts">Casts (separates with commas):</label>
            <input type="text" class="form-control" id="casts" name="casts" placeholder="e.g. Gordon Ramsay,Tom Hanks">
        </div>
        <div class="form-group">
            <label for="trailer">Trailer Embed Link</label>
            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Embed Link from YouTube">
        </div>
        <div class="form-group">
            <label for="poster">Poster image</label>
            <input type="file" name="poster" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection

@extends('layouts.OB_admin')

@section('content')

<h2>Create Category</h2>

{{-- ERRORS --}}
@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf

    <div>
        <label>Category name</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>

    <br>

    <button type="submit" class="btn-primary">
        Create Category
    </button>
</form>

@endsection

@extends('layouts.OB_app')

@section('content')
<div class="profile-page">
    <h2>My profile</h2>

    <form method="POST"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field">
            <label>Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   required>
        </div>

        <div class="field">
            <label>Email</label>
     
            <input type="email"
                   name="email"
                   value="{{ $user->email }}"
                   readonly>
        </div>

        <div class="field">
            <label>Profile image</label>
            <input type="file" name="profile_image">
        </div>

        <button class="btn-primary">Save</button>
    </form>
</div>
@endsection

@extends('layouts.OB_admin')

@section('content')

<div class="page-wrapper">

    <h2 class="page-title">Edit Event</h2>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.events.update', $event->id) }}"
          enctype="multipart/form-data"
          class="event-form">

        @csrf
        @method('PUT')

        {{-- EVENT TITLE --}}
        <div class="form-group">
            <label>Event Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $event->title) }}"
                   required>
        </div>

        {{-- CATEGORY --}}
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $event->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DATES --}}
        <div class="form-row">
            <div class="form-group">
                <label>Start date</label>
                <input type="datetime-local"
                       name="start_date"
                       value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}"
                       required>
            </div>

            <div class="form-group">
                <label>End date</label>
                <input type="datetime-local"
                       name="end_date"
                       value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}"
                       required>
            </div>
        </div>

        {{-- PLACE & CAPACITY --}}
        <div class="form-row">
            <div class="form-group">
                <label>Place</label>
                <input type="text"
                       name="place"
                       value="{{ old('place', $event->place) }}"
                       required>
            </div>

            <div class="form-group">
                <label>Capacity</label>
                <input type="number"
                       name="capacity"
                       min="1"
                       value="{{ old('capacity', $event->capacity) }}"
                       required>
            </div>
        </div>

        {{-- PRICING --}}
        <div class="form-row">
            <div class="form-group">
                <label>Pricing</label>
                <select name="is_free" id="is_free" onchange="togglePrice()">
                    <option value="1" @selected($event->is_free)>Free access</option>
                    <option value="0" @selected(!$event->is_free)>Paid</option>
                </select>
            </div>

            <div class="form-group" id="priceField"
                 style="{{ $event->is_free ? 'display:none' : '' }}">
                <label>Amount</label>
                <input type="number"
                       name="price"
                       min="0"
                       step="0.01"
                       value="{{ old('price', $event->price) }}">
            </div>
        </div>

        {{-- EVENT IMAGE --}}
        <div class="form-group">
            <label>Event Image</label>

            @if($event->image)
                <div class="image-preview">
                    <img src="{{ asset('storage/'.$event->image) }}" alt="Event image">
                </div>
            @endif

            <input type="file" name="image" accept="image/*">
            <small>Leave empty to keep current image</small>
        </div>

        {{-- DESCRIPTION --}}
        <div class="form-group">
            <h3>Event Description</h3>
            <textarea name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
        </div>

        {{-- SUBMIT --}}
        <button type="submit" class="btn-primary btn-full">
            Update Event
        </button>

    </form>
</div>

{{-- JS --}}
<script>
function togglePrice() {
    const isFree = document.getElementById('is_free').value;
    document.getElementById('priceField').style.display =
        isFree == 0 ? 'block' : 'none';
}
</script>

@endsection

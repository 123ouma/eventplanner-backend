@extends('layouts.OB_admin')

@section('content')

<div class="admin-card">

    <h1 class="admin-title">Create Event</h1>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.events.store') }}"
          enctype="multipart/form-data">

        @csrf

        {{-- TITLE --}}
        <div class="form-group">
            <label>Event Title</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Title">
        </div>

        {{-- CATEGORY --}}
        <div class="form-group">
            <label>Category</label>
            <select name="category_id">
                <option value="">Select category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DATES --}}
        <div class="form-row">
            <div class="form-group">
                <label>Start date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}">
            </div>

            <div class="form-group">
                <label>End date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}">
            </div>
        </div>

        {{-- PLACE / CAPACITY --}}
        <div class="form-row">
            <div class="form-group">
                <label>Place</label>
                <input type="text" name="place" value="{{ old('place') }}" placeholder="Place">
            </div>

            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity') }}" min="1">
            </div>
        </div>

        {{-- PRICING --}}
        <div class="form-row">
            <div class="form-group">
                <label>Pricing</label>
                <select name="is_free" id="is_free" onchange="togglePrice()">
                    <option value="1" {{ old('is_free') == '1' ? 'selected' : '' }}>
                        Free access
                    </option>
                    <option value="0" {{ old('is_free') == '0' ? 'selected' : '' }}>
                        Paid
                    </option>
                </select>
            </div>

            <div class="form-group" id="priceField" style="display:none;">
                <label>Amount</label>
                <input type="number" name="price"
                       value="{{ old('price') }}"
                       min="0" step="0.01"
                       placeholder="Amount">
            </div>
        </div>

        {{-- IMAGE --}}
     <div class="form-group">
    <label>Event Image</label>

    <!-- IMAGE PREVIEW -->
    <div class="image-preview" id="imagePreview" style="display:none;">
        <img id="previewImg">
    </div>

    <input type="file"
           name="image"
           accept="image/*"
           onchange="previewImage(event)">
</div>

        {{-- DESCRIPTION --}}
        <div class="form-group">
            <label>Event Description</label>
            <textarea name="description" placeholder="Type here...">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn-primary full-width">
            Create event
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

// trigger on load
togglePrice();

</script>
<script>
function previewImage(event) {
    const input = event.target;
    const previewBox = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewBox.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection

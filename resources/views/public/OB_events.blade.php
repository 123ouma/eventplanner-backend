@extends('layouts.OB_app')

@section('content')
<div class="page-wrapper">

<section class="hero">
    <div class="hero-overlay">
        <h1>MADE FOR THOSE<br>WHO DO</h1>
    </div>
</section>

<section class="events-section">
    <div class="events-top">
        <h2>Upcoming <span>Events</span></h2>

        <form method="GET" class="events-filters">
            <input class="search-input" name="search"
                   placeholder="Search"
                   value="{{ request('search') }}">

            <select name="category" class="filter-select">
                <option value="">Any category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(request('category') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button class="btn-primary btn-fit">Filter</button>
        </form>
    </div>

    <div class="events-grid">
        @forelse($events as $event)
            <div class="event-card">
                <img src="{{ $event->image
                    ? asset('storage/' . $event->image)
                    : asset('images/default-event.jpg') }}">

                <div class="event-body">
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->start_date->format('d M Y • H:i') }}</p>

                    <a href="{{ route('event.show', $event->id) }}">
                        View details
                    </a>
                </div>
            </div>
        @empty
            <p>No events available.</p>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $events->withQueryString()->links() }}
    </div>
</section>

</div>
@endsection

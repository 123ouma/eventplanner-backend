@extends('layouts.OB_app')

@section('content')

<div class="page-wrapper">

    {{-- FLASH MESSAGES --}}
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- HERO --}}
    <section class="event-hero"
        style="background-image: url('{{ $event->image
            ? asset('storage/' . $event->image)
            : asset('images/default-event.jpg') }}');">

        <div class="event-hero-overlay">
            <a href="{{ route('home') }}" class="back-btn">← Back</a>

            <h1>{{ $event->title }}</h1>
            <p class="event-place">{{ $event->place }}</p>

            @if($event->capacity <= 0)
                <button class="btn-primary btn-fit" disabled>Sold out</button>
            @elseif(auth()->check())
                <button class="btn-primary btn-fit" onclick="openModal()">Book now</button>
            @else
                <a href="{{ route('login') }}" class="btn-primary btn-fit">
                    Login to book
                </a>
            @endif
        </div>
    </section>

    {{-- DETAILS --}}
    <section class="event-details">

        <div class="event-desc">
            <h3>Description</h3>
            <p>{{ $event->description }}</p>
        </div>

        <div class="event-meta">
            <div>
                <h4>Date</h4>
                <p>
                    {{ $event->start_date->format('d/m/Y H:i') }}
                    →
                    {{ $event->end_date->format('d/m/Y H:i') }}
                </p>
            </div>

            <div>
                <h4>Capacity</h4>
                <p><strong>{{ $event->capacity }} persons</strong></p>
            </div>

            <div>
                <h4>Price</h4>
                <p>
                    {{ $event->is_free ? 'Free' : $event->price.' DT' }}
                </p>
            </div>
        </div>

    </section>

    {{-- OTHER EVENTS --}}
    <section class="events-section">
        <h2>Other events you may like</h2>

        <div class="events-grid">
            @foreach($otherEvents as $other)
                <div class="event-card">
                    <img src="{{ $other->image
                        ? asset('storage/' . $other->image)
                        : asset('images/default-event.jpg') }}">

                    <div class="event-body">
                        <h3>{{ $other->title }}</h3>
                        <p>{{ $other->start_date->format('d/m/Y') }}</p>

                        <a href="{{ route('event.show', $other->id) }}">
                            View
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>

{{-- MODAL --}}
<div class="modal-overlay" id="bookModal">
    <div class="modal-box">
        <h3>Confirm booking</h3>

        <p>You are about to book <strong>{{ $event->title }}</strong></p>

        <form method="POST" action="{{ route('registrations.store') }}">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <div class="modal-actions">
                <button type="button" class="btn-outline-modal" onclick="closeModal()">
                    Cancel
                </button>
                <button type="submit" class="btn-primary btn-fit">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal() {
    document.getElementById('bookModal').style.display = 'flex';
}
function closeModal() {
    document.getElementById('bookModal').style.display = 'none';
}
</script>
@endpush

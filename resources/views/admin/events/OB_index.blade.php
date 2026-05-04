@extends('layouts.OB_admin')

@section('content')

<div class="admin-content">

    <div class="events-card">

        {{-- HEADER --}}
        <div class="events-header">
            <h2 class="events-title">List of <span>Events</span></h2>

            <a href="{{ route('admin.events.create') }}" class="btn-primary">
                Create event
            </a>
        </div>

        {{-- TABLE --}}
        <div class="events-table-wrapper">
            <table class="events-table">
                <thead>
                    <tr>
                        <th>Event name</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Pricing</th>
                        <th>Capacity</th>
                        <th>Place</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td class="event-title">{{ $event->title }}</td>

                            <td>
                                {{ $event->start_date?->format('d M Y, H:i') }}
                            </td>

                            <td>
                                {{ $event->end_date?->format('d M Y, H:i') }}
                            </td>

                            <td>
                                @if($event->is_free)
                                    Free
                                @else
                                    {{ number_format($event->price, 2) }} DT
                                @endif
                            </td>

                            <td>{{ $event->capacity }}</td>

                            <td>{{ $event->place }}</td>

                            {{-- ACTIONS --}}
                            <td class="actions-cell">
                                <div class="actions-menu">
                                    <span class="dots">⋮</span>

                                    <div class="actions-dropdown">
                                        <a href="{{ route('admin.events.edit', $event->id) }}">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.events.delete', $event->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Delete this event ?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:20px;">
                                No events found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection

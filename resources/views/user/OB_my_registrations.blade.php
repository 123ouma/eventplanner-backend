@extends('layouts.OB_app')

@section('content')

<div class="page-wrapper">

    <h1 style="margin-bottom:20px;">My Registrations</h1>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($registrations->isEmpty())
        <p>You have not registered for any events yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($registrations as $registration)
                    <tr>
                        <td>{{ $registration->event->title }}</td>

                        <td>
                            {{ $registration->event->category->name ?? '—' }}
                        </td>

                        <td>
                            {{ $registration->event->start_date->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <form method="POST"
                                  action="{{ route('registrations.destroy', $registration->id) }}"
                                  onsubmit="return confirm('Cancel this registration?');">
                                @csrf
                                @method('DELETE')

                                <button class="btn-danger btn-fit">
                                    Cancel
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

@endsection

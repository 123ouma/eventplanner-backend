@extends('layouts.OB_admin')

@section('content')

<div class="admin-card">

    {{-- TITLE --}}
    <h2 style="color:#6C63FF; margin-bottom:25px;">
        List of registrations
    </h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE CONTAINER --}}
    <div style="
        background:#fff;
        border-radius:16px;
        overflow:hidden;
    ">

        {{-- TABLE HEADER --}}
        <div style="
            display:grid;
            grid-template-columns: 2fr 1.5fr 2fr 80px;
            padding:16px 20px;
            background:#f3f4f6;
            font-weight:600;
            font-size:14px;
        ">
            <div>Event title</div>
            <div>Start date</div>
            <div>User email</div>
            <div></div>
        </div>

        {{-- TABLE ROWS --}}
        @forelse($registrations as $registration)
            <div style="
                display:grid;
                grid-template-columns: 2fr 1.5fr 2fr 80px;
                padding:16px 20px;
                border-bottom:1px solid #eee;
                align-items:center;
                font-size:14px;
            ">

                <div>
                    {{ $registration->event?->title }}
                </div>

                <div style="color:#555;">
                    {{ $registration->event?->start_date->format('d M Y, H:i') }}
                </div>

                <div style="color:#555;">
                    {{ $registration->user?->email }}
                </div>

                {{-- ACTION --}}
                <div style="text-align:right;">
                    <form method="POST"
                          action="{{ route('admin.registrations.delete', $registration->id) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            style="
                                border:none;
                                background:none;
                                cursor:pointer;
                                color:#e11d48;
                                font-weight:600;
                            ">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div style="
                padding:20px;
                text-align:center;
                color:#777;
            ">
                No registrations found
            </div>
        @endforelse

    </div>

</div>

@endsection

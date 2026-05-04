@extends('layouts.OB_admin')

@section('content')

<div class="admin-card">

    {{-- TITLE --}}
    <h2 style="margin-bottom:30px;">
        Admin <span style="color:#6C63FF;">Dashboard</span>
    </h2>

    {{-- STATS CARDS --}}
    <div style="
        display:grid;
        grid-template-columns: repeat(3, 1fr);
        gap:20px;
    ">

        {{-- EVENTS --}}
        <a href="{{ route('admin.events.index') }}"
           style="text-decoration:none;">
            <div style="
                background:#f3f4f6;
                padding:24px;
                border-radius:16px;
                transition:0.2s;
            " onmouseover="this.style.background='#eef2ff'"
               onmouseout="this.style.background='#f3f4f6'">

                <h3 style="margin:0 0 10px 0;">Events</h3>
                <p style="margin:0;color:#555;">
                    Manage all events
                </p>
            </div>
        </a>

        {{-- CATEGORIES --}}
        <a href="{{ route('admin.categories.index') }}"
           style="text-decoration:none;">
            <div style="
                background:#f3f4f6;
                padding:24px;
                border-radius:16px;
                transition:0.2s;
            " onmouseover="this.style.background='#eef2ff'"
               onmouseout="this.style.background='#f3f4f6'">

                <h3 style="margin:0 0 10px 0;">Categories</h3>
                <p style="margin:0;color:#555;">
                    Manage categories
                </p>
            </div>
        </a>

        {{-- REGISTRATIONS --}}
        <a href="{{ route('admin.registrations.index') }}"
           style="text-decoration:none;">
            <div style="
                background:#f3f4f6;
                padding:24px;
                border-radius:16px;
                transition:0.2s;
            " onmouseover="this.style.background='#eef2ff'"
               onmouseout="this.style.background='#f3f4f6'">

                <h3 style="margin:0 0 10px 0;">Registrations</h3>
                <p style="margin:0;color:#555;">
                    View event registrations
                </p>
            </div>
        </a>

    </div>

</div>

@endsection

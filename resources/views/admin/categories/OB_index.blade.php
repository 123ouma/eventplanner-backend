@extends('layouts.OB_admin')

@section('content')

<div class="admin-card">

    {{-- HEADER --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="color:#6C63FF; margin:0;">List of categories</h2>

        <button class="btn-primary" onclick="openCategoryModal()">
            Create category
        </button>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- LIST --}}
    <div style="background:#fff; border-radius:14px; overflow:hidden;">

        {{-- TABLE HEADER --}}
        <div style="
            display:grid;
            grid-template-columns:1fr 60px;
            padding:14px 18px;
            background:#f3f4f6;
            font-weight:600;
        ">
            <div>Category</div>
            <div></div>
        </div>

        {{-- ROWS --}}
        @forelse($categories as $category)
            <div style="
                display:grid;
                grid-template-columns:1fr 60px;
                padding:14px 18px;
                border-bottom:1px solid #eee;
                align-items:center;
            ">
                <div>{{ $category->name }}</div>

                {{-- ACTIONS --}}
                <div style="text-align:right; position:relative;">
                    <details>
                        <summary style="cursor:pointer; font-size:20px;">⋮</summary>

                        <div style="
                            position:absolute;
                            right:0;
                            background:white;
                            border-radius:10px;
                            box-shadow:0 10px 25px rgba(0,0,0,.12);
                            margin-top:6px;
                            overflow:hidden;
                            z-index:10;
                        ">
                            <form method="POST"
                                  action="{{ route('admin.categories.delete', $category->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    style="
                                        padding:10px 14px;
                                        border:none;
                                        background:none;
                                        cursor:pointer;
                                        width:100%;
                                        text-align:left;
                                    ">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            </div>
        @empty
            <div style="padding:18px; text-align:center; color:#777;">
                No categories found
            </div>
        @endforelse

    </div>
</div>

{{-- ================= MODAL ================= --}}
<div class="modal-overlay" id="categoryModal">
    <div class="modal-box" style="max-width:420px">

        <h3>Create category</h3>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="form-group">
                <label>Category name</label>
                <input
                    type="text"
                    name="name"
                    placeholder="Enter category name"
                    required
                >
            </div>

            <div class="modal-actions">
                <button
                    type="button"
                    class="btn-outline-modal"
                    onclick="closeCategoryModal()">
                    Cancel
                </button>

                <button type="submit" class="btn-primary btn-fit">
                    Create
                </button>
            </div>
        </form>

    </div>
</div>

{{-- JS --}}
<script>
function openCategoryModal() {
    document.getElementById('categoryModal').style.display = 'flex';
}

function closeCategoryModal() {
    document.getElementById('categoryModal').style.display = 'none';
}
</script>

@endsection

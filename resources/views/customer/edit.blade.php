@extends('navbar')

@section('title', 'Update Tickets')

@section('content')

<div class="container py-5" style="max-width: 800px;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        </div>
    @endif

    <div class="card shadow-sm p-4 bg-white">

        <h3 class="mb-4 text-secondary">
            Update Support Ticket
        </h3>

        <form action="{{ route('customer.update', $data->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            {{-- Subject --}}
            <div class="row mb-3 align-items-center">

                <label for="subject"
                    class="col-sm-2 col-form-label fw-semibold">
                    Subject
                </label>

                <div class="col-sm-10">

                    <input type="text"
                        name="subject"
                        id="subject"
                        class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject', $data->subject) }}"
                        placeholder="Enter subject">

                    @error('subject')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            {{-- Description --}}
            <div class="row mb-3">

                <label for="description"
                    class="col-sm-2 col-form-label fw-semibold">
                    Description
                </label>

                <div class="col-sm-10">

                    <textarea name="description"
                        id="description"
                        rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter description">{{ old('description', $data->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            {{-- Priority / Category / Status --}}
            <div class="row g-3 mb-4">

                {{-- Priority --}}
                <div class="col-md-4">

                    <label for="priority"
                        class="form-label fw-semibold">
                        Priority
                    </label>

                    <select id="priority"
                        name="priority"
                        class="form-select @error('priority') is-invalid @enderror">

                        <option value="Low"
                            {{ old('priority', $data->priority) == 'Low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option value="Medium"
                            {{ old('priority', $data->priority) == 'Medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option value="High"
                            {{ old('priority', $data->priority) == 'High' ? 'selected' : '' }}>
                            High
                        </option>

                        <option value="Critical"
                            {{ old('priority', $data->priority) == 'Critical' ? 'selected' : '' }}>
                            Critical
                        </option>

                    </select>

                    @error('priority')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Category --}}
                <div class="col-md-4">

                    <label for="category"
                        class="form-label fw-semibold">
                        Category
                    </label>

                    <select name="category"
                        id="category"
                        class="form-select @error('category') is-invalid @enderror">

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $cat)

                            <option value="{{ $cat->category }}"
                                {{ old('category', $data->category) == $cat->category ? 'selected' : '' }}>

                                {{ $cat->category }}

                            </option>

                        @endforeach

                    </select>

                    @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Status --}}
                <div class="col-md-4">

                    <label for="status"
                        class="form-label fw-semibold">
                        Status
                    </label>

                    <select id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror">

                        <option value="Open"
                            {{ old('status', $data->status) == 'Open' ? 'selected' : '' }}>
                            Open
                        </option>

                        <option value="In Progress"
                            {{ old('status', $data->status) == 'In Progress' ? 'selected' : '' }}>
                            In Progress
                        </option>

                        <option value="Resolved"
                            {{ old('status', $data->status) == 'Resolved' ? 'selected' : '' }}>
                            Resolved
                        </option>

                        <option value="Pending"
                            {{ old('status', $data->status) == 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Closed"
                            {{ old('status', $data->status) == 'Closed' ? 'selected' : '' }}>
                            Closed
                        </option>

                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            {{-- Current Attachment --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Current Attachment
                </label>

                <br>

                @if($data->attachment)

                    <img src="{{ asset('storage/' . $data->attachment) }}"
                        width="120"
                        class="img-thumbnail">

                @else

                    <p class="text-muted">
                        No Attachment
                    </p>

                @endif

            </div>

            {{-- Change Attachment --}}
            <div class="mb-4">

                <label for="attachment"
                    class="form-label fw-semibold">
                    Change Attachment
                </label>

                <input type="file"
                    name="attachment"
                    id="attachment"
                    class="form-control @error('attachment') is-invalid @enderror">

                @error('attachment')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Button --}}
            <div class="d-grid d-md-flex justify-content-md-end">

                <button type="submit"
                    class="btn btn-primary px-4 shadow-sm">

                    Update Ticket

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
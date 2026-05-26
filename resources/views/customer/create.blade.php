@extends('navbar')

@section('title', 'Create Tickets')

@section('content')
<div class="container py-5" style="max-width: 800px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm p-4 bg-white">
        <h3 class="mb-4 text-secondary">Create Support Ticket</h3>

        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="row mb-3 align-items-center">
                <label for="subject" class="col-sm-2 col-form-label fw-semibold">Subject</label>
                <div class="col-sm-10">
                    <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="Enter a subject">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label fw-semibold">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Enter a description">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <label for="priority" class="form-label fw-semibold">Priority</label>
                    <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror">
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                        <option value="Critical" {{ old('priority') == 'Critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                    @error('priority')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">

                    <label for="category" class="form-label fw-semibold">
                        Category
                    </label>

                    <select id="category" name="category" class="form-select">

                        <option value="">Select Category</option>

                        @foreach($categories as $cat)

                        <option value="{{ $cat->category}}">{{ $cat->category }}</option>

                        @endforeach

                    </select>

                </div>




                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="Open" {{ old('status', 'Open') == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Resolved" {{ old('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <div class="mb-4">
                <label for="attachment" class="form-label fw-semibold">Attachment</label>
                <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror">
                @error('attachment')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="d-grid d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Add Ticket</button>
            </div>
        </form>
    </div>
</div>
@endsection
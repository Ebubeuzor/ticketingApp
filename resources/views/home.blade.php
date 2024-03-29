@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Your Tickets</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @elseif (session('failed'))
                        <div class="alert alert-danger text-center">{{ session('failed') }}</div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        @forelse ($tickets as $ticket)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $ticket->title }}</h5>
                                        <p class="card-text">{{ $ticket->description }}</p>
                                        <p class="card-text"><strong>Status:</strong> {{ $ticket->status }}</p>
                                        <p class="card-text"><strong>Category:</strong> {{ $ticket->category->category }}</p>
                                        <p class="card-text"><strong>Created at:</strong> {{ $ticket->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary">
                                                <i class="bi bi-pencil-fill"></i> Edit
                                            </a>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">
                                                    <i class="bi bi-trash-fill"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info" role="alert">
                                    No tickets found.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.student')

@section('title', 'Document Request Status')

@section('content')

    <div class="container my-5">
        <div class="row mt-8">
            @forelse ($documentrequests as $data)
                <div class="col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm" style="border: 2px solid #8F0C00;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Student Name:</strong> {{ $data->studentname }}</p>
                                <p><strong>Year & Course:</strong> {{ $data->year }} {{ $data->course }}</p>
                                <p><strong>Student ID:</strong> {{ $data->student_id }}</p>
                                <p><strong>Date Requested:</strong>
                                    {{ \Carbon\Carbon::parse($data->request_date)->format('m-d-Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Document Requested</h5>
                                <ul class="list-unstyled">
                                    @foreach ($data->items as $item)
                                        <li class="d-flex justify-content-between align-items-center">
                                            {{ $item->type }} ({{ $item->quantity }}x)
                                        </li>
                                    @endforeach
                                </ul>
                                <p><strong>Purpose:</strong> {{ $data->items->first()->purpose ?? '-' }}</p>
                                <p><strong>Total Amount:</strong> ₱{{ number_format($data->total_amount, 2) }}</p>
                            </div>
                        </div>

                        @if ($data->status === 'Cancelled')
                            <div class="alert alert-danger text-center fw-bold">
                                This request has been <span class="text-uppercase">Cancelled</span>.
                            </div>
                        @elseif ($data->status === 'Completed')
                            <div class="alert alert-success text-center fw-bold"> 
                                This request has been <span class="text-uppercase">Completed</span>.
                            </div>
                        @else
                            <div class="d-flex justify-content-between align-items-center position-relative px-3"
                                style="margin-top: 30px;">
                                @foreach ($timelineSteps as $index => $step)
                                    <div class="text-center" style="z-index: 1;">
                                        <div class="rounded-circle mx-auto mb-2"
                                            style="width: 30px; height: 30px;
                                                background-color: {{ $index <= $data->currentStep ? '#198754' : '#ccc' }};
                                                display: flex; align-items: center; justify-content: center;">
                                            @if ($index <= $data->currentStep)
                                                <i class="fas fa-check text-white"></i>
                                            @else
                                                <i class="fas fa-circle text-white"></i>
                                            @endif
                                        </div>
                                        <small>{{ $step }}</small>
                                    </div>
                                    @if (!$loop->last)
                                        <div class="flex-grow-1 border-top"
                                            style="height: 2px; background-color: {{ $index < $data->currentStep ? '#198754' : '#ccc' }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <small class="text-muted d-block mt-4">
                                <strong>Note:</strong> Estimated processing is 3–5 working days after payment verification.
                            </small>
                        @endif
                    </div>
                </div>
            @empty
                 <div class="col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm" style="border: 2px solid #8F0C00;">
                        <div class="row mt-5 mb-5">
                            <div class="col-md-12 text-center">
                                   <h1 class="text-black">No document request found.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($documentrequests->hasPages())
            <div class="d-flex justify-content-between align-items-center pt-4">
                <div class="text-white">
                    Showing {{ $documentrequests->firstItem() }} to {{ $documentrequests->lastItem() }} of
                    {{ $documentrequests->total() }} entries
                </div>

                <ul class="pagination">
                    <!-- Previous -->
                    @if ($documentrequests->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link text-white" style="background-color: transparent; border: 1px solid white;">
                                <i class="fas fa-angle-left text-white"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $documentrequests->previousPageUrl() }}" class="page-link text-white"
                                style="background-color: transparent; border: 1px solid white;"
                                onmouseover="this.style.backgroundColor='#8F0C00'; this.style.borderColor='#8F0C00'"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='white'">
                                <i class="fas fa-angle-left text-white"></i>
                            </a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $documentrequests->lastPage(); $i++)
                        <li class="page-item {{ $i == $documentrequests->currentPage() ? 'active' : '' }}">
                            <a href="{{ $documentrequests->url($i) }}" class="page-link text-white"
                                style="background-color: {{ $i == $documentrequests->currentPage() ? '#8F0C00' : 'transparent' }}; border: 1px solid white;"
                                onmouseover="this.style.backgroundColor='#8F0C00'; this.style.borderColor='#8F0C00'"
                                onmouseout="this.style.backgroundColor='{{ $i == $documentrequests->currentPage() ? '#8F0C00' : 'transparent' }}'; this.style.borderColor='white'">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <!-- Next -->
                    @if ($documentrequests->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $documentrequests->nextPageUrl() }}" class="page-link text-white"
                                style="background-color: transparent; border: 1px solid white;"
                                onmouseover="this.style.backgroundColor='#8F0C00'; this.style.borderColor='#8F0C00'"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='white'">
                                <i class="fas fa-angle-right text-white"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link text-white" style="background-color: transparent; border: 1px solid white;">
                                <i class="fas fa-angle-right text-white"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

    </div>

@endsection

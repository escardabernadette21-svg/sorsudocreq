@extends('layouts.student')

@section('title', 'Announcements')

@section('content')
    <div class="container my-5 mt-5">
        <div class="row mt-4">

            @forelse ($all_announcements as $announcement)
                <div class="col-md-6 mb-4"> <!-- 2 announcements per row -->
                    <div class="bg-white p-4 rounded shadow-sm h-100" style="border: 2px solid #8F0C00;">
                        <!-- Title + Date -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-dark">{{ $announcement->title }}</h5>
                            <small class="text-muted">
                              {{ \Carbon\Carbon::parse($announcement->created_at)->timezone('Asia/Manila')->format('F d, Y h:i A') }}

                            </small>
                        </div>

                        <!-- Content -->
                        <p class="text-dark" style="font-size: 1rem;">
                            {{ $announcement->content }}
                        </p>


                    </div>
                </div>
            @empty
                <div class="col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm text-center" style="border: 2px solid #8F0C00;">
                        <h3 class="text-muted">No announcements available.</h3>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Custom Pagination -->
        @if ($all_announcements->hasPages())
            <div class="d-flex justify-content-between align-items-center pt-4">
                <div class="text-white">
                    Showing {{ $all_announcements->firstItem() }} to {{ $all_announcements->lastItem() }} of
                    {{ $all_announcements->total() }} entries
                </div>

                <ul class="pagination">
                    <!-- Previous -->
                    @if ($all_announcements->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link text-white" style="background-color: transparent; border: 1px solid white;">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $all_announcements->previousPageUrl() }}" class="page-link text-white"
                                style="background-color: transparent; border: 1px solid white;"
                                onmouseover="this.style.backgroundColor='#8F0C00'; this.style.borderColor='#8F0C00'"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='white'">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $all_announcements->lastPage(); $i++)
                        <li class="page-item {{ $i == $all_announcements->currentPage() ? 'active' : '' }}">
                            <a href="{{ $all_announcements->url($i) }}" class="page-link text-white"
                                style="background-color: {{ $i == $all_announcements->currentPage() ? '#8F0C00' : 'transparent' }};
                                       border: 1px solid white;"
                                onmouseover="this.style.backgroundColor='#8F0C00'; this.style.borderColor='#8F0C00'"
                                onmouseout="this.style.backgroundColor='{{ $i == $all_announcements->currentPage() ? '#8F0C00' : 'transparent' }}'; this.style.borderColor='white'">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <!-- Next -->
                    @if ($all_announcements->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $all_announcements->nextPageUrl() }}" class="page-link text-white"
                                style="background-color: transparent; border: 1px solid white;"
                                onmouseover="this.style.backgroundColor='#8F0C00'; this.style.borderColor='#8F0C00'"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='white'">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link text-white" style="background-color: transparent; border: 1px solid white;">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
@endsection

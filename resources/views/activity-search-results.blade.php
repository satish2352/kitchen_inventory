@if (!empty($ActiviyLogData) && count($ActiviyLogData) > 0)
        @foreach ($ActiviyLogData as $item)
            <!-- User Activity Box -->
            <div class="user-request-box p-3 shadow rounded mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="bdr-left">
                        <div class="d-flex align-items-center">
                            <span class="act-user me-2">{{ $item->activity_message }}</span>
                        </div>
                        <p class="mb-1 activity-p">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('D F j, Y | g:ia') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach  

        <!-- Pagination Links -->
        <div class="mt-3">
        <div class="col-md-8">
                                                    <div class="pagination">
                                                        @if ($ActiviyLogData->lastPage() > 1)
                                                            <ul class="pagination">
                                                                <li class="{{ ($ActiviyLogData->currentPage() == 1) ? ' disabled' : '' }}">
                                                                    @if ($ActiviyLogData->currentPage() > 1)
                                                                        <a href="{{ $ActiviyLogData->url($ActiviyLogData->currentPage() - 1) }}">Previous</a>
                                                                    @else
                                                                        <span>Previous</span>
                                                                    @endif
                                                                </li>
                                                                @php
                                                                    $currentPage = $ActiviyLogData->currentPage();
                                                                    $lastPage = $ActiviyLogData->lastPage();
                                                                    $startPage = max($currentPage - 5, 1);
                                                                    $endPage = min($currentPage + 4, $lastPage);
                                                                @endphp
                                                                @if ($startPage > 1)
                                                                    <li>
                                                                        <a href="{{ $ActiviyLogData->url(1) }}">1</a>
                                                                    </li>
                                                                    @if ($startPage > 2)
                                                                        <li>
                                                                            <span>...</span>
                                                                        </li>
                                                                    @endif
                                                                @endif
                                                                @for ($i = $startPage; $i <= $endPage; $i++)
                                                                    <li class="{{ ($currentPage == $i) ? ' active' : '' }}">
                                                                        <a href="{{ $ActiviyLogData->url($i) }}">{{ $i }}</a>
                                                                    </li>
                                                                @endfor
                                                                @if ($endPage < $lastPage)
                                                                    @if ($endPage < $lastPage - 1)
                                                                        <li>
                                                                            <span>...</span>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <a href="{{ $ActiviyLogData->url($lastPage) }}">{{ $lastPage }}</a>
                                                                    </li>
                                                                @endif
                                                                <li class="{{ ($currentPage == $lastPage) ? ' disabled' : '' }}">
                                                                    @if ($currentPage < $lastPage)
                                                                        <a href="{{ $ActiviyLogData->url($currentPage + 1) }}">Next</a>
                                                                    @else
                                                                        <span>Next</span>
                                                                    @endif
                                                                </li>
                                                                <!-- <li>
                                                                    <span>Page {{ $currentPage }}</span>
                                                                </li> -->
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div><!-- Pagination for each category -->
        </div>
    @else
        <div class="border-box mb-4" id="search-results">
            <!-- Header Title -->
            <div class="grid-header text-center">
                <h6 class="m-0 text-white">No Activity Data Found</h6>
            </div>
        </div>    
    @endif
@extends('provider.layouts.main')
@section('title', 'مركز الإشعارات')


@section('content')
    <div class="notifications" id="main_page">
        <div class="section-header">
            <p>مركز الإشعارات</p>

            <form method="GET" action="{{ route('provider.notifications.index') }}">
                <div class="input_group">
                    <input type="search" name="search" placeholder="البحث في الإشعارات..." value="{{ request('search') }}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </form>

            <div class="d-flex justify-content-between">
                <form method="POST" action="{{ route('provider.notifications.markAllRead') }}">
                    @csrf
                    <button type="submit" class="main_btn_bg">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2136_14421)">
                                <path
                                    d="M15.4662 8.18215V8.79548C15.4653 10.2331 14.9998 11.6319 14.139 12.7834C13.2783 13.9348 12.0683 14.7771 10.6897 15.1847C9.3111 15.5924 7.83765 15.5434 6.48913 15.0452C5.1406 14.547 3.98925 13.6262 3.20679 12.4202C2.42432 11.2142 2.05267 9.78753 2.14726 8.35303C2.24185 6.91853 2.79762 5.55303 3.73167 4.4602C4.66571 3.36736 5.928 2.60574 7.33027 2.28891C8.73254 1.97209 10.1997 2.11704 11.5128 2.70215"
                                    stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6.80078 8.1276L8.80078 10.1276L15.4674 3.46094" stroke="white"
                                    stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2136_14421">
                                    <rect width="16" height="16" fill="white" transform="translate(0.800781 0.796875)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <span>تحديد الكل كمقروء</span>
                    </button>
                </form>
            </div>
        </div>


{{--         
        @foreach($notifications as $notification)
            <div class="box {{ $notification->class }}" @if($notification->seen == 1) style="border-color:#fff" @endif>
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <div class="img">{!! $notification->icon !!}</div>
                        <p class="title-card">{{ $notification->title }}</p>
                    </div>
                    <span class="time">{{ $notification->created_at->format('g:i a') }}</span>
                </div>

                <p class="start-text">{{ $notification->description }}</p>
                <p class="look"><a href="{{ route('provider.notifications.seen', $notification->id) }}">عرض التفاصيل ←</a></p>
            </div>
        @endforeach --}}


        <div id="provider-notifications-wrapper">
            @foreach($notifications as $notification)
                <div class="box provider-notification-card {{ $notification->class }}" 
                    @if($notification->seen == 1) style="border-color:#fff" @endif>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="img">{!! $notification->icon !!}</div>
                            <p class="title-card">{{ $notification->title }}</p>
                        </div>
                        <span class="time">{{ $notification->created_at->format('g:i a') }}</span>
                    </div>

                    <p class="start-text">{{ $notification->description }}</p>
                    <p class="look"><a href="{{ route('provider.notifications.seen', $notification->id) }}">عرض التفاصيل ←</a></p>
                </div>
            @endforeach
        </div>

        @if($notifications->count() > 0)
            <div class="pagination mt-3 mb-5">
                <button id="prevBtnProvider"><i class="fa-solid fa-angle-right"></i></button>
                <div id="pageNumbersProvider"  class="pageNumbers"></div>
                <button id="nextBtnProvider"><i class="fa-solid fa-angle-left"></i></button>
            </div>
        @endif


    </div>


    <script src="../../../../assets/js/pagination.js?v={{ time() }}"></script>

@endsection
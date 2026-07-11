@extends('provider.layouts.main')

@php
    use Carbon\Carbon;
    use App\Enums\ProjectStatus;

    $firstInspection = $project->firstInspection();
    $requestedDate = $firstInspection?->requested_date;
    $date = $firstInspection?->date ? Carbon::parse($firstInspection->date)->toDateString() : null;
    $today = now()->toDateString();
    $tomorrow = now()->addDay()->toDateString();
@endphp
@section('title')
    عرض مشروع {{ $project->reference_number }}
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <div class="project_details provider" id="main_page">


        <div class="project_info">
            <div class="head">
                <a href="{{ route('provider.project.index') }}">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>العودة للمشاريع</span>
                </a>
                @if ($project->status == \App\Enums\ProjectStatus::OPEN_FOR_OFFERS->value)
                    <a class="buttons" href="{{ route('provider.offers.create', $project->id) }}">
                        <div class="main_btn_bg">تقديم عرض سعر</div>
                    </a>
                @endif

            </div>


            <div class="categors">
                <div class="status">
                    <span>{{ ProjectStatus::getLabel($project->status) }}</span>
                </div>
                <div>
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.98067 2.52397C8.73068 2.2739 8.3916 2.13338 8.03801 2.1333H3.25667C2.90305 2.1333 2.56391 2.27378 2.31386 2.52383C2.06382 2.77387 1.92334 3.11301 1.92334 3.46663V8.24797C1.92342 8.60156 2.06394 8.94064 2.31401 9.19063L8.11667 14.9933C8.41968 15.2944 8.8295 15.4634 9.25667 15.4634C9.68384 15.4634 10.0937 15.2944 10.3967 14.9933L14.7833 10.6066C15.0844 10.3036 15.2534 9.8938 15.2534 9.46663C15.2534 9.03947 15.0844 8.62964 14.7833 8.32663L8.98067 2.52397Z"
                            stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M5.58999 6.13298C5.77408 6.13298 5.92332 5.98374 5.92332 5.79964C5.92332 5.61555 5.77408 5.46631 5.58999 5.46631C5.40589 5.46631 5.25665 5.61555 5.25665 5.79964C5.25665 5.98374 5.40589 6.13298 5.58999 6.13298Z"
                            fill="#374151" stroke="#374151" stroke-width="1.33333" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>{{ $project->category->name }}</span>
                </div>
                <div>
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.98067 2.52397C8.73068 2.2739 8.3916 2.13338 8.03801 2.1333H3.25667C2.90305 2.1333 2.56391 2.27378 2.31386 2.52383C2.06382 2.77387 1.92334 3.11301 1.92334 3.46663V8.24797C1.92342 8.60156 2.06394 8.94064 2.31401 9.19063L8.11667 14.9933C8.41968 15.2944 8.8295 15.4634 9.25667 15.4634C9.68384 15.4634 10.0937 15.2944 10.3967 14.9933L14.7833 10.6066C15.0844 10.3036 15.2534 9.8938 15.2534 9.46663C15.2534 9.03947 15.0844 8.62964 14.7833 8.32663L8.98067 2.52397Z"
                            stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M5.58999 6.13298C5.77408 6.13298 5.92332 5.98374 5.92332 5.79964C5.92332 5.61555 5.77408 5.46631 5.58999 5.46631C5.40589 5.46631 5.25665 5.61555 5.25665 5.79964C5.25665 5.98374 5.40589 6.13298 5.58999 6.13298Z"
                            fill="#374151" stroke="#374151" stroke-width="1.33333" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>{{ $project->projectType->name }}</span>
                </div>
            </div>

            <h2 class="project_name">{{ $project->serviceType->name }} {{ $project->buildingType->name }}</h2>


            <div class="info">
                <div>
                    <span>{{ $project->duration }} شهر</span>
                    <p>مدة الانتهاء المتوقعة:</p>
                    <img src="/assets/images/customer/icons/culander.png" alt="">
                </div>
                <div>
                    <span>{{ $project->city->name }}</span>
                    <img src="/assets/images/customer/icons/location.png" alt="">
                </div>
                <div>
                    <p>ريال</p>
                    <span>{{ number_format($project->budget, 0, '.', ',') }}</span>
                    <img src="/assets/images/customer/icons/budget.png" alt="">
                </div>
                <div>
                    <p>عروض مقدم</p>
                    <span class="offer_num">{{ count($project->offers) }}</span>
                    <img src="/assets/images/customer/icons/globe.png" alt="">
                </div>
            </div>



        </div>


        <div class="progress_step">
            <ul class="list-unstyled multi-steps">
                <li>
                    <span class="top">تاريخ النشر</span>
                    <span class="bottom">{{ $project->created_at->format('Y-m-d') }}</span>
                </li>
                <li class="is-{{ \App\Enums\ProjectStatus::getStatusOrder($project->status) == 5 ? 'active' : '' }}">
                    <span class="top">فتح العروض</span>
                    <span class="bottom">{{  $project->open_for_offers_date?->format('Y-m-d') }}</span>
                </li>
                <li class="is-{{ \App\Enums\ProjectStatus::getStatusOrder($project->status) == 6 ? 'active' : '' }}">
                    <span class="top">قبول العروض</span>
                    <span class="bottom">{{ $project->accept_offer_date?->format('Y-m-d') ?? '---' }}</span>
                </li>
                <li>
                    <span class="top">تاريخ الترسيه</span>
                    <span class="bottom">{{ $project->start_date }}</span>
                </li>



            </ul>
        </div>


        <div class="about_project">

            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="overview">
                        <i class="fa-regular fa-eye"></i>
                        <span>نظرة عامة</span>
                    </li>
                    {{-- <li data-target="requirements">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>المتطلبات</span>
                    </li> --}}

                    <li data-target="documents">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>المستندات</span>
                    </li>
                </ul>
            </div>



            <div class="contents">

                @include('provider.project.show.overview')

                @include('provider.project.show.documents')
            </div>




        </div>




    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('assets/js/switch-tabs.js') }}"></script>
@endpush

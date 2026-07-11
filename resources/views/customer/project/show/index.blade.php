@extends('customer.layouts.main')

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
    <div class="project_details"  id="main_page">
        <div class="project_info">
            <div class="head">
                <a href="{{ route('customer.project.index') }}" class="back_to_projects">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_2116_5648)">
                            <path d="M4.16797 10H15.8346" stroke="#4B5563" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M10 4.16797L15.8333 10.0013L10 15.8346" stroke="#4B5563" stroke-width="1.66667"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clipPath id="clip0_2116_5648">
                                <rect width="20" height="20" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span>العودة للمشاريع</span>
                </a>
                <div class="buttons">
                    @if ($project->firstInspection()?->status == 'completed')
                        <a href="{{ route('customer.inspection.show', $project->firstInspection()->id) }}"
                            class="main_btn_bg" >
                            <i class="fa-regular fa-file" style="color: #ffffff"></i>
                            <span style="color: #ffffff">عرض تقرير المعاينة</span>
                        </a>
                    @endif
                    @if ($project->status == ProjectStatus::PENDING->value)

                        {{-- <button class="main_btn_bg  update">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9 2.25H3.75C3.35218 2.25 2.97064 2.40804 2.68934 2.68934C2.40804 2.97064 2.25 3.35218 2.25 3.75V14.25C2.25 14.6478 2.40804 15.0294 2.68934 15.3107C2.97064 15.592 3.35218 15.75 3.75 15.75H14.25C14.6478 15.75 15.0294 15.592 15.3107 15.3107C15.592 15.0294 15.75 14.6478 15.75 14.25V9"
                                    stroke="#F5932E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M13.7813 1.9699C14.0796 1.67153 14.4843 1.50391 14.9063 1.50391C15.3282 1.50391 15.7329 1.67153 16.0313 1.9699C16.3296 2.26827 16.4972 2.67294 16.4972 3.0949C16.4972 3.51685 16.3296 3.92153 16.0313 4.2199L9 11.2511L6 12.0011L6.75 9.00115L13.7813 1.9699Z"
                                    stroke="#F5932E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>تعديل الطلب</span>
                        </button>
                        <button class="main_btn_bg delete">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.83464 3.33464C5.83464 2.89261 6.01023 2.46868 6.32279 2.15612C6.63535 1.84356 7.05927 1.66797 7.5013 1.66797H12.5013C12.9433 1.66797 13.3673 1.84356 13.6798 2.15612C13.9924 2.46868 14.168 2.89261 14.168 3.33464V5.0013H17.5013C17.7223 5.0013 17.9343 5.0891 18.0906 5.24538C18.2468 5.40166 18.3346 5.61362 18.3346 5.83464C18.3346 6.05565 18.2468 6.26761 18.0906 6.42389C17.9343 6.58017 17.7223 6.66797 17.5013 6.66797H16.6105L15.888 16.7863C15.858 17.2068 15.6699 17.6003 15.3614 17.8876C15.0529 18.1749 14.647 18.3346 14.2255 18.3346H5.7763C5.35475 18.3346 4.94886 18.1749 4.64037 17.8876C4.33189 17.6003 4.14373 17.2068 4.1138 16.7863L3.39297 6.66797H2.5013C2.28029 6.66797 2.06833 6.58017 1.91205 6.42389C1.75577 6.26761 1.66797 6.05565 1.66797 5.83464C1.66797 5.61362 1.75577 5.40166 1.91205 5.24538C2.06833 5.0891 2.28029 5.0013 2.5013 5.0013H5.83464V3.33464ZM7.5013 5.0013H12.5013V3.33464H7.5013V5.0013ZM5.06297 6.66797L5.77714 16.668H14.2263L14.9405 6.66797H5.06297ZM8.33464 8.33464C8.55565 8.33464 8.76761 8.42243 8.92389 8.57871C9.08017 8.73499 9.16797 8.94695 9.16797 9.16797V14.168C9.16797 14.389 9.08017 14.6009 8.92389 14.7572C8.76761 14.9135 8.55565 15.0013 8.33464 15.0013C8.11362 15.0013 7.90166 14.9135 7.74538 14.7572C7.5891 14.6009 7.5013 14.389 7.5013 14.168V9.16797C7.5013 8.94695 7.5891 8.73499 7.74538 8.57871C7.90166 8.42243 8.11362 8.33464 8.33464 8.33464ZM11.668 8.33464C11.889 8.33464 12.1009 8.42243 12.2572 8.57871C12.4135 8.73499 12.5013 8.94695 12.5013 9.16797V14.168C12.5013 14.389 12.4135 14.6009 12.2572 14.7572C12.1009 14.9135 11.889 15.0013 11.668 15.0013C11.447 15.0013 11.235 14.9135 11.0787 14.7572C10.9224 14.6009 10.8346 14.389 10.8346 14.168V9.16797C10.8346 8.94695 10.9224 8.73499 11.0787 8.57871C11.235 8.42243 11.447 8.33464 11.668 8.33464Z"
                                    fill="#F85735" />
                            </svg>
                            <span>حذف الطلب</span>
                        </button> --}}

                        @endif

                        @if ($project->status == ProjectStatus::FIRST_INSPECTION_SCHEDULED->value)
                            <button class="main_btn_bg  change_inspection ">
                                <i class="fa-regular fa-calendar"></i>
                                <span>تغيير موعد المعاينة</span>
                            </button>
                        @endif
                </div>
            </div>
            @if ($project->status == ProjectStatus::FIRST_INSPECTION_SCHEDULED->value)
                <div class="request_inspection">
                    <div class="wrapper">
                        <h6>تعديل موعد المعاينة</h6>
                        <form action="{{ route('customer.inspection.update', $firstInspection->id) }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="new_date">
                                <label for="inlineCalendar">اختر التاريخ الجديد</label>
                                <input type="text" value="{{ $project->firstInspection()->date }}" name="new_date"
                                    id="inlineCalendar" hidden>
                            </div>
                            <div class="input_group">
                                <label for="time">اختر الوقت</label>
                                <input type="time" value="{{ $project->firstInspection()->time }}" name="time"
                                    id="time">
                            </div>
                            <p class="note">ملاحظة: يمكن تغيير الموعد مرة واحدة فقط، ويجب أن يكون قبل الموعد المحدد بـ 24
                                ساعة على الأقل.</p>


                            @if (!$requestedDate && $date !== $today && $date !== $tomorrow)
                                <div class="buttons">
                                    <button class="main_btn_bg">تأكيد التغيير</button>
                                    <button class="main_btn_bg cancel">إلغاء</button>
                                </div>
                            @endif
                        </form>
                        <div class="close_change_popup">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4L4 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M4 4L12 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
            <div class="categors">
                <div class="status">
                    <span>{{ ProjectStatus::getLabel($project->status) }}</span>
                </div>
                <div>
                    <img src="../../public/assets/images/customer/icons/tag-01.png" alt="">
                    <span>{{ $project->category?->name }}</span>
                </div>
                <div>
                    <img src="../../public/assets/images/customer/icons/tag-01.png" alt="">
                    <span>{{ $project->projectType?->name }}</span>
                </div>
            </div>

            <h2 class="project_name">{{ $project->serviceType?->name }} {{ $project->buildingType?->name }}</h2>


            <div class="info">
                <div>
                    <span>{{ $project->duration }} شهر</span>
                    <p>مدة الانتهاء المتوقعة:</p>
                    <img src="/assets/images/customer/icons/culander.png" alt="">
                </div>
                <div>
                    <span>{{ $project->city?->name }}</span>
                    <img src="/assets/images/customer/icons/location.png" alt="">
                </div>
                <div>
                    <p>ريال</p>
                    <span>{{ number_format($project->budget, 0, '.', ',') }}</span>
                    <img src="/assets/images/customer/icons/budget.png" alt="">
                </div>
                <div>
                    <p>{{ $project->acceptedOffer()?->provider?->company_name }}</p>
                    <span> المقاول</span>

                    <img src="/assets/images/customer/icons/globe.png" alt="">
                </div>
            </div>



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
                    <li data-target="order_status">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>حالة الطلب</span>
                    </li>

                    @if ($project->status != ProjectStatus::PENDING->value || $project->status != ProjectStatus::REQUIRE_COMPLETE->value)
                        <li data-target="assigned_consultant">
                            <i class="fa-regular fa-user"></i>
                            <span>الاستشاري المعين</span>
                        </li>
                    @endif
                    <li data-target="documents">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>المستندات</span>
                    </li>
                </ul>
            </div>



            <div class="contents">

                @include('customer.project.show.overview')


                @include('customer.project.show.orderstatus')

                @if($project->consultant_id)
                @include('customer.project.show.consultant')
                @endif


                @include('customer.project.show.documents')

            </div>
        </div>


    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('assets/js/customer/project.js') }}"></script>
    <script src="{{ asset('assets/js/switch-tabs.js') }}"></script>
@endpush

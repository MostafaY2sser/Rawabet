@extends('admin.layouts.main')

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
    <style>
        .provider_scope_card {
            padding-top: 20px !important;
        }

        .provider_scope_list .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .provider_scope_list .form-check-input {
            position: static;
            float: none;
            margin: 0;
        }

        .provider_scope_list .form-check-label {
            margin: 0;
            line-height: 1.5;
        }
    </style>
@endpush
@section('content')
    <div class="project_details" id="main_page">
        <div class="project_info">
            <div class="head">
                <a href="{{ route('admin.projects.pending.index') }}" class="back_to_projects">
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
                    @if ($project->status == ProjectStatus::PENDING->value)
                        @can('edit projects.pending')
                        <button class="main_btn_bg  update pop_up_button" data-bs-target="changeStatusModal">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9 2.25H3.75C3.35218 2.25 2.97064 2.40804 2.68934 2.68934C2.40804 2.97064 2.25 3.35218 2.25 3.75V14.25C2.25 14.6478 2.40804 15.0294 2.68934 15.3107C2.97064 15.592 3.35218 15.75 3.75 15.75H14.25C14.6478 15.75 15.0294 15.592 15.3107 15.3107C15.592 15.0294 15.75 14.6478 15.75 14.25V9"
                                    stroke="#F5932E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M13.7813 1.9699C14.0796 1.67153 14.4843 1.50391 14.9063 1.50391C15.3282 1.50391 15.7329 1.67153 16.0313 1.9699C16.3296 2.26827 16.4972 2.67294 16.4972 3.0949C16.4972 3.51685 16.3296 3.92153 16.0313 4.2199L9 11.2511L6 12.0011L6.75 9.00115L13.7813 1.9699Z"
                                    stroke="#F5932E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>تعديل الحالة</span>
                        </button>
                        @endcan
              

                                                @can('create inspections')

                        <button class="main_btn_bg  change_inspection ">
                            <i class="fa-regular fa-calendar"></i>
                            <span>اضافه معاينة</span>
                        </button>
                        @endcan
                    @endif

                </div>
            </div>
                @if ($project->status == ProjectStatus::PENDING->value)
                <div class="request_inspection">
                    <div class="wrapper">
                        <h6>تعديل موعد المعاينة</h6>
                        <form action="{{ route('admin.inspection.schedule', $project->id) }}" method="POST">
                            @csrf
                            <div class="new_date">
                                <label for="inlineCalendar">اختر التاريخ </label>
                                <input type="text" value="" name="date"
                                    id="inlineCalendar" hidden>
                            </div>
                            <div class="input_group my-2">
                                <label for="time">اختر الوقت</label>
                                <input type="time" value="" name="time" id="time">
                            </div>
                         
                            <div class="input_group my-3">
                                <label for="notes">اختيار الاستشاري</label>
                                <select class="form-control" name="consultant_id" id="consultant_id">
                                    <option value="">اختر استشاري</option>
                                    @foreach ($consultants as $consultant)
                                        <option value="{{ $consultant->id }}">{{ $consultant->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>

                                <div class="buttons">
                                    <button class="main_btn_bg">تأكيد </button>
                                    <button class="main_btn_bg cancel">إلغاء</button>
                                </div>
                        </form>
                        <div class="close_request_inspection">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
                <div class="change_status" id="changeStatusModal">
                  <div class="wrapper">
                        <h6>تعديل </h6>
                        <form action="{{ route('admin.projects.pending.update.status', $project->id) }}" method="POST">

                            @csrf
                            <div class="input_group my-5">
                                <label for="time">اختر الحاله</label>
                                <select name="status" class="form-control" id="customerStatus">
                                    <option value="">اختر</option>
                                    <option value="{{ \App\Enums\ProjectStatus::REQUIRE_COMPLETE->value }}">
                                        {{ \App\Enums\ProjectStatus::getLabel('require_complete') }}</option>
                                    
                                    <option value="{{ \App\Enums\ProjectStatus::OPEN_FOR_OFFERS->value }}">
                                        {{ \App\Enums\ProjectStatus::getLabel('open_for_offers') }}</option>
                        
                                </select>

                            </div>
                            <div class="input_group mt-4 mb-4" id="msgWrapper" style="display: none;">
                                <label for="msg">الرساله</label>
                                <textarea name="msg" id="msg" cols="30" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="buttons d-flex align-items-center justify-content-between">
                                <button class="main_btn_bg">تأكيد التغيير</button>
                                <button class="main_btn_bg cancel_request_inspection" >إلغاء</button>
                            </div>
                        </form>
                        <div class="close_request_inspection" >
                            <i class="fa-solid fa-xmark"></i>
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



        {{-- @if ($project->status === ProjectStatus::OPEN_FOR_OFFERS->value) --}}
            @canany(['edit projects.pending', 'edit projects.active'])
                <div class="about_project mt-4 provider_scope_card">
                    <h6 class="main_title">نطاق المقاولين المتاح لهم المشروع</h6>
                    <form action="{{ route('admin.projects.provider.scope.update', $project->id) }}" method="POST">
                        @csrf
                        <div class="input_group mt-3">
                            <button type="button" class="main_btn_bg toggle_provider_scope_btn" data-target="#providerScopePanelPending">
                                إظهار/إخفاء نطاق المقاولين
                            </button>
                            <div id="providerScopePanelPending" class="mt-3" style="display: none;">
                                <label class="d-block mb-2">اختر المقاولين</label>
                                <div class="provider_scope_list">
                                    @foreach (($providers ?? []) as $provider)
                                        <div class="form-check mb-2">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="provider_ids[]"
                                                value="{{ $provider->id }}"
                                                id="provider_pending_{{ $provider->id }}"
                                                @checked(in_array($provider->id, $selectedProviderIds ?? []))
                                            >
                                            <label class="form-check-label" for="provider_pending_{{ $provider->id }}">
                                                {{ $provider->company_name }} - {{ $provider->phone_number }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted d-block mt-2">عند عدم اختيار أي مقاول، يكون المشروع متاحًا لكل المقاولين.</small>
                            </div>
                        </div>
                        <div class="buttons mt-3">
                            <button class="main_btn_bg" type="submit">حفظ النطاق</button>
                        </div>
                    </form>
                </div>
            @endcanany
        {{-- @endif --}}

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

                    @if ($project->consultant)
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


                <div class="overview section_tap">
                    <div class="project_desc">
                        <h6>وصف المشروع</h6>
                        <p> {{ $project->work_description }}</p>
                    </div>
                    <div class="info">
                        <div class="row w-100">
                            <div class="col-6">
                                <div class=" box location">
                                    <div>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>الموقع</span>
                                    </div>
                                    <h6>
    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($project->address) }}" target="_blank">
        {{ $project->address }}
    </a>
</h6>                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box type">
                                    <div>
                                        <i class="fa-regular fa-building"></i>
                                        <span>نوع المشروع</span>
                                    </div>
                                    <h6>سكني</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box dateline">
                                    <div>
                                        <i class="fa-regular fa-clock"></i>
                                        <span>مدة التنفيذ المتوقعة</span>
                                    </div>
                                    <h6>{{ $project->duration }} شهر</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box budget">
                                    <div>
                                        <i class="fa-solid fa-dollar-sign"></i>
                                        <span>الميزانية المتوقعة</span>
                                    </div>
                                    <h6>{{ number_format($project->budget, 0, '.', ',') }} ريال</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="order_status   section_tap">
                    <h6 class="main_title">حالة الطلب</h6>
                    <div class="timeline">
                        @php
                            $steps = ProjectUtility::getProjectTrackStatus();
                            $statusKeys = array_keys($steps);
                            $currentStatus = is_object($project->status) ? $project->status->value : $project->status;
                            $currentStatusIndex = array_search($currentStatus, $statusKeys);
                        @endphp

                        @foreach ($steps as $status => $step)
                            @php
                                $index = array_search($status, $statusKeys);
                                $stepClass =
                                    $index < $currentStatusIndex
                                        ? 'completed'
                                        : ($index === $currentStatusIndex
                                            ? 'current'
                                            : 'waiting');
                            @endphp

                            <div class="step {{ $stepClass }}">
                                <div class="icon"><i class="{{ $step['icon'] }}"></i></div>
                                <div class="content">
                                    <div class="title">
                                        <h6>{{ $step['title'] }}</h6>
                                        <span class="{{ $stepClass }}">
                                            {{ $stepClass === 'completed' ? 'مكتمل' : ($stepClass === 'current' ? 'الحالي' : 'في الانتظار') }}
                                        </span>



                                    </div>
                                    <p class="status">{{ $step['description'] }}</p>
                                    <div class="date">
                                        <img src="{{ asset('assets/images/customer/icons/culander.png') }}"
                                            alt="">
                                        @if($step['key'] === 'pending')  
                                            <span>{{ $project->created_at->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'accepted_inspection')
                                            <span>{{ $project->firstInspection()?->created_at?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'first_inspection_scheduled')
                                            <span>{{ $project->firstInspection()?->date?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'first_inspection_completed')
                                            <span>{{ $project->firstInspection()?->updated_at?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'open_for_offers')
                                            <span>{{ $project->open_for_offers_date?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'in_progress')
                                            <span>{{ $project->accept_offer_date?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'completed')
                                            <span>{{ $project->completed_at?->format('Y-m-d') ?? '---' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                @if ($project->consultant)
                    <div class="assigned_consultant section_tap">

                        <h6 class="main_title mb-5">الاستشاري المسؤول</h6>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="perssonal_info">
                                    <div class="image">
                                        <img src="{{ Storage::url($project->consultant->avatar) }}" alt="">
                                    </div>
                                    <h6>{{ $project->consultant->fullname }}</h6>
                                    <p>{{ $project->consultant->spciality->name }}</p>
                                    <div class="rating">
                                        <img src="../../public/assets/images/home/star.png" alt="">
                                        <h6 class="num"></h6>
                                        <span>({{ rand(0, 10) }} معاينة)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="main_info">
                                            <h6>المعلومات الأساسية</h6>
                                            <div class="national_id">
                                                <p>رقم الهوية:</p>
                                                <span>{{ $project->consultant->identity_number }} </span>
                                            </div>
                                            <div class="experience">
                                                <p>سنوات الخبرة:</p>
                                                <span>{{ $project->consultant->experience_years }} سنة</span>
                                            </div>
                                            <div class="assigned">
                                                <p>المعايانات المكتملة:</p>
                                                <span>{{ rand(0, 15) }} مشروع</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="certifictes">
                                            <h6>الشهادات والاعتمادات</h6>
                                            <div>
                                                <img src="../../public/assets/images/customer/icons/checked.png"
                                                    alt="">
                                                <span>{{ $project->consultant->certificates }} </span>
                                            </div>
                                            {{-- <div>
                                            <img src="../../public/assets/images/customer/icons/checked.png"
                                                alt="">
                                            <span>خبير تقييم عقاري</span>
                                        </div>
                                        <div>
                                            <img src="../../public/assets/images/customer/icons/checked.png"
                                                alt="">
                                            <span>استشاري إنشائي</span>
                                        </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 contact_consultant">
                                       @php
                                    $email = $project->consultant->email ?? "";
                                    $phone = $project->consultant->phone_number ?? "";
                                @endphp
                                <div class="col-md-4">
                                    <a href="mailto:{{ $email }}" class="main_btn_bg">
                                        <i class="fa-regular fa-envelope"></i>
                                        <span>إرسال بريد إلكتروني</span>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="tel:{{ $phone }}" class="main_btn_bg">
                                        <i class="fa-solid fa-phone"></i>
                                        <span>{{$phone}}</span>
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif

                    <div class="documents section_tap">
                        <div class="row">
                            @foreach ($attachments as $key => $list)
                                @foreach ($list as $file)
                                    <div class="col-md-6">

                                        <div class="card_content">
                                            <div class="file_info">
                                                <i class="fas fa-file-pdf icon-pdf fa-lg"></i>
                                                <div class="file_details">
                                                    <p>{{ $key }}</p>
                                                </div>
                                            </div>
                                            <div class="file_actions">
                                                <a class="main_btn_bg preview" href="{{ route('admin.projects.downlaod.file', $file->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>

            </div>
        </div>


    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('assets/js/customer/project.js') }}"></script>
    <script src="{{ asset('assets/js/switch-tabs.js') }}"></script>

     <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.pop_up_button').addEventListener("click", function(e) {
                e.preventDefault();
             relatedTarget = document.getElementById(this.getAttribute('data-bs-target'));
                relatedTarget.classList.add("show");
            });
        });


        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll('.close_request_inspection, .request_inspection .cancel_request_inspection').forEach(button => {
                relatedTarget = document.getElementById(button.getAttribute('data-bs-target'));
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    relatedTarget.classList.remove("show");
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('customerStatus');
            const msgWrapper = document.getElementById('msgWrapper');
            const msgInput = document.getElementById('msg');

            function toggleMsgField() {
                if (statusSelect.value === '{{ \App\Enums\ProjectStatus::REQUIRE_COMPLETE->value }}') {
                    msgWrapper.style.display = 'block';
                    msgInput.setAttribute('required', 'required');
                } else {
                    msgWrapper.style.display = 'none';
                    msgInput.removeAttribute('required');
                }
            }

            // Initial check on page load
            toggleMsgField();

            // Watch for changes
            statusSelect.addEventListener('change', toggleMsgField);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle_provider_scope_btn').forEach(button => {
                button.addEventListener('click', function() {
                    const panel = document.querySelector(this.getAttribute('data-target'));
                    if (!panel) {
                        return;
                    }

                    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                });
            });
        });
    </script>
@endpush

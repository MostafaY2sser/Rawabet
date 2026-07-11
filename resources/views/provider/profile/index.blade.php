@extends('provider.layouts.main')


@section('content')
    <div class="project_details profile " id="main_page">


        <div class="project_info  profile_info   d-flex  justify-content-between ">
            <div class="text">
                <h1>الملف الشخصي</h1>
                <div class="information d-flex align-items-center gap-3 mt-4">
                    <div class="image d-flex align-items-center justify-content-center">
                        <img src="{{ $provider->image ? Storage::url($provider->image) : '/assets/images/home/user.png' }}" alt="">
                    </div>
                    <div class="info d-flex flex-column gap-2 align-items-start">
                        <h2>{{ $provider->company_name }}</h2>
                        {{-- <p>شركة ذات مسؤولية محدودة</p> --}}
                        <div class="rating">
                            <div class="d-flex align-items-center gap-0">
                                <img src="/assets/images/home/star.png" alt="">
                             
                            </div>
                            <span> {{ number_format($averageRate, 1) }} نجوم </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons d-flex flex-column align-items-end">
                <button class="main_btn_bg" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <span>تعديل الملف</span>
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>

                {{-- <div class="status_profile">
                    <i class="fa-regular fa-circle-check"></i>
                    <span>معتمد</span>
                </div> --}}
            </div>

        </div>


        <div class="about_project">

            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="main_info">
                        <i class="fa-regular fa-user"></i>
                        <span>المعلومات الأساسية</span>
                    </li>
                    <li data-target="documents">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>المستندات</span>
                    </li>
                    <li data-target="portfolio">
                        <i class="fa-regular fa-camera"></i>
                        <span>معرض الأعمال</span>
                    </li>
                    <li data-target="evaluation">
                        <i class="fa-regular fa-star"></i>
                        <span>الأداء والتقييم</span>
                    </li>
                </ul>
            </div>



            <div class="contents">

                <div class="section_tap  main_info ">
                    <div class="about">
                        <div class="row">
                            <div class="col-md-6">
                                <p>اسم الشركة</p>
                                <span>{{ $provider->company_name }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>نوع الكيان القانوني</p>
                                <span>{{ $provider->legal_entity_type }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم السجل التجاري</p>
                                <span>{{ $provider->commercial_registration }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم هوية المالك</p>
                                <span>{{ $provider->owner_id }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم الهاتف</p>
                                <span>{{ $provider->phone_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>البريد الإلكتروني</p>
                                <span>{{ $provider->email }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>العنوان الرسمي</p>
                                <span>{{ $provider->city->name }} - {{ $provider->region->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="specialization mb-4">
                        <h6>مجالات التخصص</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @foreach ($provider->specializations as $item)
                                <span>{{ $item->name }}</span>
                            @endforeach
                        </div>
                        <div class="Geographical">
                            <h6>النطاق الجغرافي</h6>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @foreach ($provider->workRegions as $item)
                                    <span>{{ $item->name }}</span>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="section_tap  documents ">
                    <div class="row">
                        @foreach ($attachments as $key => $list)
                            @foreach ($list as $file)
                                <div class="col-md-6">
                                    <div class="file">
                                        <h6>{{ $key }}</h6>
                                        <div class="file_name my-3">
                                            <i class="fa-regular fa-file-lines"></i>
                                            <span>{{ $file->file_name }} </span>
                                        </div>
                                        <div class="buttons d-flex align-items-center gap-2 mt-2">
                                            <button class="main_btn_bg veiw preview"
                                                onclick="previewFile('{{ route('provider.profile.preview.file', $file->id) }}')"><i
                                                    class="fa-regular fa-eye"></i></button>
                                            <button class="main_btn_bg download"
                                                onclick="downloadFile('{{ route('provider.profile.download.file', $file->id) }}')"><i
                                                    class="fa-solid fa-download"></i></button>
                                        </div>
                                        <div class="status_profile">
                                            <i class="fa-regular fa-circle-check"></i>
                                            <span>معتمد</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach


                    </div>
                    <form action="{{ route('provider.profile.add.file') }}" method="POST" class="d-flex gap-1 my-4"
                        enctype="multipart/form-data">
                        @csrf
                        <i class="fa-regular fa-file-lines"></i>
                        <div class="text ">
                            <h6>إضافة مستندات جديدة</h6>
                            <p>يمكنك إضافة أو تحديث المستندات المطلوبة لتحسين ملفك التعريفي</p>
                            <div class="d-flex align-items-center gap-2">
                                <label class="main_btn_bg">
                                    رفع مستندات
                                    <input id="fileInput" name="file" type="file" accept="image/*,.pdf"
                                        style="display: none;">
                                </label>
                                <button type="submit" id="saveBtn" class="main_btn_bg save">حفظ</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="section_tap  portfolio ">
                    {{-- <h1>معرض الأعمال</h1> --}}
                       <div class="projects" style="direction:rtl">
                    <div class="row">
                        @foreach ($myOffers as $offer)
                    <div class="col-md-6 col-lg-6 mb-3">
                        @include('provider.components.offer-card')
                    </div>
                @endforeach
                    </div>
                    </div>
                </div>

                <div class="section_tap evaluation">
                    <div class="row d-flex ">
                        <div class="col-lg-3 col-sm-6 ">
                            <div class="sec sec-1">
                                <i class="fa-regular fa-star"></i>
                                <p>{{ number_format($averageRate, 1) }}</p>
                                <span>متوسط التقييم</span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 ">
                            <div class="sec sec-2">
                                <i class="fa-solid fa-medal"></i>
                                <p>{{ count($myOffers) }}</p>
                                <span>مشروع مكتمل</span>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-sm-6 ">
                            <div class="sec sec-3">
                                <i class="fa-solid fa-chart-line"></i>
                                <p>87%</p>
                                <span>معدل النجاح</span>
                            </div>
                        </div> --}}
                        <div class="col-lg-3 col-sm-6 ">
                            <div class="sec sec-4">
                                <i class="fa-regular fa-calendar"></i>
                                <p>{{ $monthsCount }}</p>
                                <span>شهر في المنصة</span>
                            </div>
                        </div>
                    </div>
                    <div class="last-rating">
                        <h3>آخر التقييمات</h3>

                        @foreach ($latestRatings as $item)
                            <div class="box box-1">
                                <div class="head">
                                    <div class="stars">
                                        @for ($i = 0; $i < $item->contractor_rating; $i++)
                                            <i class="fa-solid fa-star"></i>
                                        @endfor

                                    </div>
                                    <div class="star-text">
                                        <p>{{ $item->project->serviceType?->name }}
                                            {{ $item->project->buildingType?->name }} </p>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="end-text">
                                    <p>{{ $item->contractor_comment }}</p>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>


            </div>




        </div>

        <!-- Edit Profile Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل المعلومات الأساسية</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('provider.profile.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>اسم الشركة</label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ $provider->company_name }}">
                                </div>

                             
                                

                                <div class="col-md-6">
                                    <label>رقم الهاتف</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ $provider->phone_number }}">
                                </div>
                                <div class="col-md-6">
                                    <label>صورة البروفايل</label>
                                    <input type="file" name="image" class="form-control"
                                        >
                                </div>

                               



                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                إلغاء
                            </button>
                            <button type="submit" class="main_btn_bg">
                                حفظ التعديلات
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
@endsection
@push('scripts')
    <script src="/assets/js/switch-tabs.js"></script>
    <script src="/assets/js/provider/profile.js"></script>

    <script>
        // open
        function previewFile(fileName) {
            window.open(`${fileName}`, '_blank')
        }

        // download
        function downloadFile(fileName) {
            const link = document.createElement('a')
            link.href = `${fileName}`
            link.download = fileName
            link.click()
        }
    </script>
@endpush

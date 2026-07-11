@extends('customer.layouts.main')


@section('content')
    <div class="project_details profile " id="main_page">


        <div class="project_info  profile_info   d-flex  justify-content-between ">
            <div class="text">
                <h1>الملف الشخصي</h1>
                <div class="information d-flex align-items-center gap-3 mt-4">
                    <div class="image d-flex align-items-center justify-content-center">
                        <img width="40" height="40" src="{{ $customer->personal_image ? Storage::url($customer->personal_image) : '/assets/images/home/user.png' }}" alt="">
                    </div>
                    <div class="info d-flex flex-column gap-2 align-items-start">
                        <h2>{{ $customer->full_name }}</h2>
                        {{-- <p>شركة ذات مسؤولية محدودة</p> --}}
                        {{-- <div class="rating">
                            <div class="d-flex align-items-center gap-0">
                                <img src="/assets/images/home/star.png" alt="">
                             
                            </div>
                            <span> {{ number_format($averageRate, 1) }} نجوم </span>
                        </div> --}}
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
                  
                    <li data-target="portfolio">
                        <i class="fa-regular fa-camera"></i>
                        <span>المشاريع</span>
                    </li>
              
                </ul>
            </div>



            <div class="contents">

                <div class="section_tap  main_info ">
                    <div class="about">
                        <div class="row">
                            <div class="col-md-6">
                                <p>الاسم</p>
                                <span>{{ $customer->full_name }}</span>
                            </div>
                       
                            <div class="col-md-6">
                                <p>رقم الهوية</p>
                                <span>{{ $customer->national_id }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم الهاتف</p>
                                <span>{{ $customer->phone_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>البريد الإلكتروني</p>
                                <span>{{ $customer->email }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>العنوان الرسمي</p>
                                <span>{{ $customer->city->name }} - {{ $customer->region->name }}</span>
                            </div>
                        </div>
                    </div>
               
                </div>

                <div class="section_tap  portfolio ">
                    {{-- <h1>معرض الأعمال</h1> --}}
                       <div class="projects" style="direction:rtl">
                    <div class="row">
                        @foreach ($myProjects as $project)
                    <div class="col-md-6 col-lg-6 mb-3">
                        @include('customer.components.project-card')
                    </div>
                @endforeach
                    </div>
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

                    <form action="{{ route('customer.profile.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>الاسم</label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="{{ $customer->full_name }}">
                                </div>

                             
                                

                                <div class="col-md-6">
                                    <label>رقم الهاتف</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ $customer->phone_number }}">
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

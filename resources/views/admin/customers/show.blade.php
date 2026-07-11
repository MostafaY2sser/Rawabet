@extends('admin.layouts.main')


@section('content')
    <div class="project_details profile " id="main_page">


        <div class="project_info  profile_info   ">
            <div class="text d-flex align-content-center justify-content-between">
                {{-- <h1>الملف الشخصي</h1> --}}
                <div class="information d-flex align-items-center gap-3 mt-4">
                    <div class="image d-flex align-items-center justify-content-center">
                        <img src="{{ Storage::url($customer->personal_image) }}" alt="">
                    </div>
                    <div class="info d-flex flex-column gap-2 align-items-start">
                        <h2>{{ $customer->full_name }}</h2>
                    </div>
                </div>
                @can('edit customers')
                    <button class="main_btn_bg change_inspection">
                        <span>تعديل </span>
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                @endcan
            </div>
       



            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="main_info">
                        <i class="fa-regular fa-user"></i>
                        <span>المعلومات الأساسية</span>
                    </li>

                </ul>
            </div>



            <div class="contents">

                <div class="section_tap  main_info ">
                    <div class="about">
                        <div class="row">

                            <div class="col-md-6">
                                <p>اسم</p>
                                <span>{{ $customer->full_name }}</span>
                            </div>


                            <div class="col-md-6">
                                <p>رقم هوية </p>
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
                                <p>العنوان </p>
                                @php
                                    $encodedAddress = urlencode($customer->address);
                                    $mapsUrl = "https://www.google.com/maps/search/?api=1&query={$encodedAddress}";
                                @endphp
                                <a href="{{ $mapsUrl }}" target="_blank">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.0434 7.46663C14.0434 11.4666 8.71004 15.4666 8.71004 15.4666C8.71004 15.4666 3.37671 11.4666 3.37671 7.46663C3.37671 6.05215 3.93861 4.69559 4.93881 3.6954C5.939 2.6952 7.29555 2.1333 8.71004 2.1333C10.1245 2.1333 11.4811 2.6952 12.4813 3.6954C13.4815 4.69559 14.0434 6.05215 14.0434 7.46663Z" stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.71002 9.46631C9.81459 9.46631 10.71 8.57088 10.71 7.46631C10.71 6.36174 9.81459 5.46631 8.71002 5.46631C7.60545 5.46631 6.71002 6.36174 6.71002 7.46631C6.71002 8.57088 7.60545 9.46631 8.71002 9.46631Z" stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>   
                                    <span style="text-decoration: underline">View Location</span>
                                </a>                            
                            </div>
                            <div class="col-md-6">
                                <p>وسيلة الدفع الفضلة</p>
                                <span>{{ $customer->payment_method == '1' ? 'paypal' : 'visa' }} </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>




    </div>

    </div>
       <div class="request_inspection">
        <div class="wrapper">
            <h6>تعديل </h6>
            <form action="{{ route('admin.customers.requests.update.status', $customer->id) }}" method="POST">

                @csrf
                <div class="input_group my-5">
                    <label for="time">اختر الحاله</label>
                    <select name="status" class="form-control" id="customerStatus">
                        <option value="{{ \App\Enums\CustomerStatus::PENDING->value }}">
                            {{ \App\Enums\CustomerStatus::getLabel('pending') }}</option>
                        <option value="{{ \App\Enums\CustomerStatus::REQUIREUPDATE->value }}">
                            {{ \App\Enums\CustomerStatus::getLabel('require_update') }}</option>
                    </select>

                </div>
                <div class="input_group mt-4 mb-4" id="msgWrapper" style="display: none;">
                    <label for="msg">الرساله</label>
                    <textarea name="msg" id="msg" cols="30" class="form-control" rows="3"></textarea>
                </div>

                <div class="buttons">
                    <button class="main_btn_bg">تأكيد التغيير</button>
                    <button class="main_btn_bg cancel">إلغاء</button>
                </div>
            </form>
            <div class="close_request_inspection">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4L4 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4 4L12 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </div>
   
@endsection
@push('scripts')
    <script src="/assets/js/switch-tabs.js"></script>
    <script src="/assets/js/provider/profile.js"></script>

 


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.change_inspection').addEventListener("click", function(e) {
                e.preventDefault();
                document.querySelector('.request_inspection').classList.add("show");
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const consultantPopup = document.querySelector('.request_inspection');

            document.querySelectorAll('.close_request_inspection, .request_inspection .cancel').forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    consultantPopup.classList.remove("show");
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
                if (statusSelect.value === '{{ \App\Enums\CustomerStatus::REQUIREUPDATE->value }}') {
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
    @endpush

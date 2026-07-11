@extends('customer.layouts.main')

@section('content')
    <div class="add_project">
        <div class="wrapper">
            <div>
            <div class="head_add">
                <h3> إضافة مشروع جديد</h3>
                <div class="stepper">
                    <a href="#" class="step {{ $step == 1 ? 'active' : '' }}">
                        <span>01</span>
                        <p>نوع المشروع</p>
                    </a>
                    <a href="#" class="step {{ $step == 2 ? 'active' : '' }}">
                        <span>02</span>
                        <p>تفاصيل الخدمة</p>
                    </a>
                    <a href="#" class="step {{ $step == 3 ? 'active' : '' }}">
                        <span>03</span>
                        <p>الميزانية والتوقيت</p>
                    </a>
                    <a href="#" class="step {{ $step == 4 ? 'active' : '' }}">
                        <span>04</span>
                        <p>المستندات</p>
                    </a>
                    <a href="#" class="step {{ $step == 5 ? 'active' : '' }}">
                        <span>05</span>
                        <p>مراجعة وإرسال الطلب</p>
                    </a>
                </div>
                <a href="{{ route('customer.dashboard') }}" class="close_add_project" id="">
                  <i class="fa-solid fa-xmark"></i>
                </a>
            </div>
            @switch($step)
                @case(1)
                    @include('customer.project.edit.project-type')
                @break

                @case(2)
                    @include('customer.project.edit.Service-details')
                @break

                @case(3)
                    @include('customer.project.edit.timeline')
                @break

                @case(4)
                    @include('customer.project.edit.attachment')
                @break

                @case(5)
                    @include('customer.project.edit.review')
                @break

                @case(6)
                    @include('customer.project.edit.reference')
                    
                @break
                @default
                    <p>خطأ: خطوة غير معروفة.</p>
            @endswitch

            </div>

            <!-- End Wrapper -->
        </div>
    </div>
@endsection

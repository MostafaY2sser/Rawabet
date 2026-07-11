@extends('customer.layouts.main')


@section('content')
    <div class="inspection_report">

        <div class="head">
            <p>تقرير المعاينة المفصل</p>
          
           
            <a href="{{ route('customer.project.show', $inspection->project->id) }}"><i class="fa-solid fa-xmark"></i></a>


        </div>


        @php
            $details = json_decode($inspection->report->details ?? '[]');
            $recommendations = json_decode($inspection->report->recommendations ?? '[]');
            $features = json_decode($inspection->report->features ?? '[]');
        @endphp

        <div class="section_1">

            <div class="row">
                <div class="col-md-6">
                    <div class="result_summary">
                        <h5>ملخص النتيجة</h5>
                        <p>{{ $inspection->report->result_summary }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="overall_evaluation">
                        <i class="fa-regular fa-thumbs-up"></i>
                        <h6>التقييم الإجمالي</h6>
                        <h1>{{ $inspection->report->rate }}</h1>
                    </div>
                </div>
            </div>

        </div>


        <div class="section_2">
            <div class="row">

                @foreach ($features as $item)
                    <div class="col-md-6 col-lg-4">

                        <div class="box">
                            <p>{{ $item->name }}</p>
                            <h4>{{ $item->value }}</h4>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>



        <div class="section_3">

            <div class="row">
                <div class="col-md-6">
                    <div class="inspection_details">
                        <h6>تفاصيل المعاينة</h6>


                        <ul>
                            @foreach ($details as $item)
                                <li>
                                    <img src="/assets/images/customer/icons/green-check.png" alt="">
                                    <p>{{ $item }}</p>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="recommendations">
                        <h6>التوصيات</h6>


                        <ul>
                            @foreach ($recommendations as $item)
                                <li>
                                    <span>{{ $loop->iteration }}</span>
                                    <p>{{ $item }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>



        <div class="section_4">
            <div class="row">
                @foreach ($inspection->report->attachments as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="box_img">
                            <div class="image">
                                <img src="{{ Storage::url($item->file_path) }}" alt="">
                            </div>
                          
                        </div>
                    </div>
                @endforeach

            </div>
        </div>




    </div>

    <div class="change_status" id="changeStatusModal">
        <div class="wrapper">
            <h6>تعديل </h6>
            <form action="{{ route('admin.projects.pending.update.status', $inspection->project->id) }}" method="POST">

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.pop_up_button').addEventListener("click", function(e) {
                e.preventDefault();
                relatedTarget = document.getElementById(this.getAttribute('data-bs-target'));
                relatedTarget.classList.add("show");
            });
        });
    </script>
@endpush

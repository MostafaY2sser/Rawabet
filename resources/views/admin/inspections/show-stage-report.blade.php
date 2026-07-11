@extends('admin.layouts.main')

@section('content')

    <section class="report_details"  id="main_page">
        <div class="wrapper">
            <div class="head">
                <h6>تقرير المعاينة المفصل</h6>
                <a href="{{ route('admin.projects.active.workstages' , $inspection->stage->offer->project_id) }}"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <div class="content_rate">
                <div class="header">
                    <div class="box">
                        <i class="fa-regular fa-thumbs-up"></i>
                        <p>التقييم الإجمالي</p>
                    </div>
                    <div class="">
                        <p>{{ $inspection->report->rate }}</p>
                    </div>
                </div>
                <div class="works">

                    <h4>{{ $inspection->stage->title }}</h4>
                    <div class="d-flex justify-content-between gap-2 align-items-center progress_bar">
                        <label for="p">{{ $inspection->stage->progress }}%</label>
                        <progress id="p" value="100" max="100">40%</progress>

                    </div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-between;">
                            <div class="box-2">
                                <div class="wrong">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                                <div class="dateline">
                                    <p>تاريخ البدء</p>
                                    <span>{{ $inspection->stage->start_date }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-between;">
                            <div class="box-2">
                                <div class="wrong">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class=" dateline">
                                    <p>تاريخ الانتهاء</p>
                                    <span>{{ $inspection->stage->end_date }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-3">
                        <p>المواصفات الفنية
                            <br> أمتار مع صب الخرسانة
                        </p>
                    </div>
                </div>
                <div class="box-4">
                    <h4>ملخص النتيجة</h4>
                    <p>{{ $inspection->report->result_summary }}</p>
                </div>
                <div class="hero">
                       

                    <p>
                        <i class="fa-regular fa-eye"></i>
                        <span>صور المعاينة ({{ count($inspection->report->attachments) }} صور)</span>
                    </p>
                    <div class="big-box">
                          @foreach ($inspection->report->attachments as $item)
                  
                        <div class="box-img">
                            <img width="200px" height="200px" src="{{ Storage::url($item->file_path) }}" alt="">
                            <p>{{ $item->title }}</p>
                        </div>

                     @endforeach
                    

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
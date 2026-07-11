@extends('admin.layouts.main')

@section('content')

  <div class="project_details">
        <div class="inspection_form  weekly_report">
            <form action="{{ route('admin.projects.reports.store' , $project->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                <!-- Title -->

                <div class="input_group">
                    <label for="title">العنوان</label>
                    <input type="text" id="title" name="title"  placeholder="عنوان التقرير" required>
                </div>

                <!-- Description -->
                <div class="input_group my-4">
                    <label for="description">الوصف</label>
                    <input type="text" id="description" name="description" rows="3" placeholder="أدخل وصف موجز للتقرير"></input>
                </div>

                <!-- Report لإype -->
                <div class="input_group mb-4">
                    <label for="">نوع التقرير</label>
                    <select id="report_type" name="type" required>
                        <option value="" disabled selected>اختر نوع التقرير</option>
                        <option value="أسبوعي">تقرير أسبوعي</option>
                        <option value="شهري">تقرير شهري</option>
                    </select>
                </div>

                <!-- Add Images -->
                <div class="input_group mb-3">
                    <label for="images" class="form-label">صور التقرير</label>
                    <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <button class="main_btn_bg mt-5">إرسال التقرير</button>
                    <a href="{{ route('admin.projects.active.workstages', $project->id) }}" class="main_btn_bg mt-5">رجوع</a>
                </div>
                
            </form>
        </div>
    </div>

@endsection
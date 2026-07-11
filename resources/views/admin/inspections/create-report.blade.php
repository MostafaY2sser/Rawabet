@extends('admin.layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@section('content')
   <div class="project_details"  id="main_page">
    <div class="inspection_form container mt-4">
            <form id="inspectionForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.inspection.store.report', $inspection->id) }}">
@csrf
                <div class="row">

                    <!-- ملخص النتيجة -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">ملخص النتيجة</label>
                            <textarea class="form-control" name="summary" required rows="3" placeholder="أدخل ملخص النتيجة"></textarea>
                        </div>
                    </div>
                    <!-- التقييم الإجمالي -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">التقييم الإجمالي (من 10)</label>
                            <input type="number" class="form-control" name="evaluation" min="0" max="10" step="0.1" required>
                        </div>
                    </div>
                </div>

                
                <!-- القسم الثاني -->
                 <div class="row mt-4" id="dynamic-fields">
                    <h6>خصائص المعاينة</h6>
                    <div class="col-md-5 mb-3">
                        <input type="text" class="form-control" name="properties[0][name]" placeholder="اسم الخاصية (مثال: المرافق العامة)" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" name="properties[0][value]" placeholder="القيمة (مثال: متوفر بالكامل)" required>
                    </div>
                    <div class="col-md-1 mb-4">
                        <button type="button" class="btn btn-danger remove-field">حذف</button>
                    </div>
                </div>
                <button type="button" class="main_btn_bg no_bg mb-4" id="add-field">إضافة خاصية</button>
                <!-- القسم الثاني -->
                
            

                <!-- تفاصيل المعاينة -->
                <div class="mt-4" id="inspection-points">
                    <h6>تفاصيل المعاينة </h6>
                    <div class="d-flex align-items-center mb-2 point-item">
                        <input type="text" class="form-control me-2" name="points[0]" placeholder="أدخل نقطة مثل: الموقع استراتيجي" required>
                        <button type="button" class="btn btn-danger remove-point">حذف</button>
                    </div>
                </div>
                <button type="button" class="main_btn_bg no_bg mb-4" id="add-point">إضافة نقطة</button>
                <!-- تفاصيل المعاينة -->



                <!-- التوصيات -->
                <div class="mt-4" id="recommendations-list">
                    <div class="d-flex align-items-center mb-2 recommendation-item">
                        <input type="text" class="form-control me-2" name="recommendations[0]" placeholder="أدخل توصية" required>
                        <button type="button" class="btn btn-danger remove-recommendation">حذف</button>
                    </div>
                </div>
                <button type="button" class="main_btn_bg no_bg mb-4" id="add-recommendation">إضافة توصية</button>



                <!-- صور -->
                <div class="mb-3">
                    <label class="form-label">رفع صور المرافق</label>
                    <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                </div>

                <button type="submit" class="main_btn_bg ">حفظ التقرير</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/assets/js/admin/inspection-review.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('inspectionForm');
            const submitButton = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function () {
                submitButton.disabled = true;
                submitButton.innerText = 'جاري الحفظ...'; // Optional: change button text
            });
        });
    </script>
@endpush

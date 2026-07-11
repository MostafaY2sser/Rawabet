@extends('admin.layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@section('content')
   <div class="project_details"  id="main_page">
    <div class="inspection_form container mt-4">
            <form id="inspectionForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.inspection.store.stage.report', $inspection->id) }}">
@csrf
       @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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

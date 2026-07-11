@extends('admin.layouts.main')

@section('title')
    تحديث التقدم
@endsection
@php
    $project = $offerItem->offer ->project;
@endphp



@section('content')
    <div class="update_progress" id="main_page">

        <form action="{{ route('admin.offers.active.update.progress.submit', $offerItem->id) }}" method="POST"
            enctype="multipart/form-data">

            @csrf
            <div class="info">
                <a href="{{ route('admin.projects.active.workstages', $project->id) }}">
                    <i class="fa-solid fa-arrow-right"></i>
                    العودة للمشروع
                </a>
                <span class="status">
                    <i class="fa-regular fa-clock"></i>
                    {{ App\Enums\ProjectStatus::getLabel($project->status) }}
                </span>
                <h3 class="name">{{ $project->serviceType->name }} {{ $project->buildingType->name }}</h3>
                <div class="buttons">
                    <button type="submit" class="main_btn_bg">
                        <i class="fa-regular fa-floppy-disk"></i>
                        حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.projects.active.workstages', $project->id) }}" class="main_btn_bg cancel">إلغاء</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="Phase_Progress">
                        <h6>تقدم المرحلة</h6>
                        <div class="prograss">
                            <div>
                                <span id="progressValue">{{ $offerItem->progress }}%</span>
                                <p>نسبة الإنجاز</p>
                            </div>
                            <input type="range" name="progress" value="{{ $offerItem->progress }}" id="Phase_Progress">
                        </div>
                        <div class="input_group">
                            <label for="phase_type">حالة المرحلة</label>
                            <select name="status" id="phase_type">
                                <option
                                {{ App\Enums\OfferItemStatus::PENDING->value == $offerItem->status ? "selected" : "" }}
                                value="{{ App\Enums\OfferItemStatus::PENDING->value }}">
                                    {{ App\Enums\OfferItemStatus::getLabel(App\Enums\OfferItemStatus::PENDING->value) }}
                                </option>
                                <option 
                            {{ App\Enums\OfferItemStatus::ACTIVE->value == $offerItem->status ? "selected" : "" }}
                                value="{{ App\Enums\OfferItemStatus::ACTIVE->value }}">
                                    {{ App\Enums\OfferItemStatus::getLabel(App\Enums\OfferItemStatus::ACTIVE->value) }}
                                </option>
                                 <option 
                            {{ App\Enums\OfferItemStatus::COMPLETED->value == $offerItem->status ? "selected" : "" }}
                                value="{{ App\Enums\OfferItemStatus::COMPLETED->value }}">
                                    {{ App\Enums\OfferItemStatus::getLabel(App\Enums\OfferItemStatus::COMPLETED->value) }}
                                </option>
                                 <option 
                            {{ App\Enums\OfferItemStatus::REQUESTPAYMENT->value == $offerItem->status ? "selected" : "" }}
                                value="{{ App\Enums\OfferItemStatus::REQUESTPAYMENT->value }}">
                                    {{ App\Enums\OfferItemStatus::getLabel(App\Enums\OfferItemStatus::REQUESTPAYMENT->value) }}
                                </option>
                                {{-- <option value="3">phase_type</option> --}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="timeline">
                        <h6>الجدول الزمني</h6>
                        <div class="line">
                            <div class="icon">
                                <i class="fa-regular fa-calendar"></i>
                                <span>تاريخ البدء</span>
                            </div>
<p>{{ $offerItem->start_date->locale('ar')->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="line">
                            <div class="icon">
                                <i class="fa-regular fa-calendar"></i>
                                <span>تاريخ الانتهاء المتوقع</span>
                            </div>
                            <p>{{ $offerItem->end_date }}</p>
                        </div>
                        <div class="remaining">
                            <div>
                                <i class="fa-regular fa-clock"></i>
                                <p>المدة المتبقية</p>
                            </div>
<span>
    {{ now()->diffForHumans($offerItem->end_date, [
        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
        'parts' => 3
    ]) }}
</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="input_group my-3 not_group">
                <label for="phase_notes">ملاحظات المرحلة</label>
                <textarea name="comments" id="phase_notes" placeholder="80% من أعمال الحفر">{{ $offerItem->comments }}</textarea>
            </div>

            <div class="add_images">
                <div class="head">
                    <h6>صور المرحلة</h6>
                    <div id="addImageBtn" class="main_btn_bg">
                        <i class="fa-solid fa-plus"></i>
                        إضافة صورة
                    </div>
                </div>
                <input type="file" name="images[]" multiple id="imageInput" accept="image/*" style="display: none;">

                <div class="image-container" id="imagesDiv">
                    @foreach ($offerItem->attachments as $item)
                        <img src="{{ Storage::url($item->file_path) }}" style="width: 100px; margin: 5px;">
                    @endforeach
                </div>
            </div>

        </form>


    </div>
@endsection


@push('scripts')
    <!-- Show input  Value in span -->
    <script>
        const rangeInput = document.getElementById('Phase_Progress');
        const progressValue = document.getElementById('progressValue');

        rangeInput.addEventListener('input', function() {
            progressValue.textContent = this.value + '%';
        });
    </script>




    <!-- Add Images :----- -->
    <script>
        const addImageBtn = document.getElementById("addImageBtn");
        const imageInput = document.getElementById("imageInput");
        const imagesDiv = document.getElementById("imagesDiv");

        // Store selected files in an array
        let allFiles = [];

        addImageBtn.addEventListener("click", () => {
            imageInput.click();
        });

        imageInput.addEventListener("change", () => {
            const files = Array.from(imageInput.files);

            files.forEach(file => {
                allFiles.push(file); // Store file for later use (e.g., form submission)

                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.width = "100px"; // Optional styling
                    img.style.margin = "5px";
                    imagesDiv.appendChild(img);
                };
                reader.readAsDataURL(file);
            });

            // Reset input so the same file can be selected again if needed
            imageInput.value = '';
        });

        // OPTIONAL: You can hook this to a form submission
        const form = document.querySelector("form");
        form.addEventListener("submit", function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            allFiles.forEach(file => {
                formData.append("images[]", file);
            });

            fetch(this.action, {
                    method: "POST",
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json(); // Or response.text() if backend doesn't return JSON
                })
                .then(data => {
                    if(data.success == true)
                    window.location.href = "{{ route('admin.projects.active.workstages', $project->id) }}";
                    else
                    window.alert(data.msg)
                })
                .catch(error => {
                    console.error("❌ Error:", error);
                });
        });
    </script>
@endpush

<div class="overview section_tap">
    <div class="project_desc">
        <h6>وصف المشروع</h6>
        <p> {{ $project->work_description }}</p>
    </div>
    <div class="info">
        <div class="row w-100">
            <div class="col-6">
                <div class=" box location">
                    <div>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>الموقع</span>
                    </div>
                    @php
                        $googleMapsUrl =
                            'https://www.google.com/maps/search/?api=1&query=' . urlencode($project->address);
                    @endphp

                    <h6>
                        <a href="{{ $googleMapsUrl }}" target="_blank" rel="noopener" >
                            {{ $project->address }}
                        </a>
                    </h6>

                </div>
            </div>
            <div class="col-6">
                <div class="box type">
                    <div>
                        <i class="fa-regular fa-building"></i>
                        <span>نوع المشروع</span>
                    </div>
                    <h6>سكني</h6>
                </div>
            </div>
            <div class="col-6">
                <div class="box dateline">
                    <div>
                        <i class="fa-regular fa-clock"></i>
                        <span>مدة التنفيذ المتوقعة</span>
                    </div>
                    <h6>{{ $project->duration }} شهر</h6>
                </div>
            </div>
            <div class="col-6">
                <div class="box budget">
                    <div>
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span>الميزانية المتوقعة</span>
                    </div>
                    <h6>{{ number_format($project->budget, 0, '.', ',') }} ريال</h6>
                </div>
            </div>
        </div>

    </div>
</div>

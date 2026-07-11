@extends('provider.layouts.auth')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="auth_page">
        <div class="wrapper complete">

            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box ">
                <form action="{{ route('provider.compelete.account.post', $provider->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <h2 class="mb-4">إستكمال بياناتك</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <!-- Step One Content -->
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="company_name">*اسم الشركة/المؤسسة</label>
                                <input type="text" value="{{ $provider->company_name }}" name="company_name"
                                    id="company_name" placeholder="اسم الشركة/المؤسسة" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="legal_entity_type">نوع الكيان القانوني*</label>
                                <select name="legal_entity_type" id="legal_entity_type" required>
                                    <option value="" disabled selected>نوع الكيان</option>
                                    <option value="1" {{ $provider->legal_entity_type == 1 ? 'selected' : '' }}>test 1
                                    </option>
                                    <option value="2" {{ $provider->legal_entity_type == 2 ? 'selected' : '' }}>test_2
                                    </option>
                                    <option value="3" {{ $provider->legal_entity_type == 3 ? 'selected' : '' }}>test_3
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="owner_id">*رقم الهوية/القامة للمالك</label>
                                <input type="text" value="{{ $provider->owner_id }}" name="owner_id" id="owner_id"
                                    placeholder="1234567890" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="commercial_registration">*رقم السجل التجاري</label>
                                <input type="text" value="{{ $provider->commercial_registration }}"
                                    name="commercial_registration" id="commercial_registration" placeholder="1234567890"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="phone">رقم الهاتف المحمول*</label>
                                <input value="{{ $provider->phone_number }}" type="text" name="phone_number"
                                    id="phone_number" placeholder="+966 50 123 4567" required>
                                <button class="confirm_phone">التحقق من الهاتف المحمول</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="email">البريد الإلكتروني*</label>
                                <input value="{{ $provider->email }}" type="email" name="email" id="email"
                                    placeholder="example@mail.com" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="address">*العنوان الكامل</label>
                                <input value="{{ $provider->address }}" type="text" name="address" id="address"
                                    placeholder="أدخل العنوان التفصيلي" required>
                            </div>
                        </div>
                      
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="region_id">المنطقة</label>
                                <select  name="region_id" id="region_input"
                                    required>
                                    <option value="" disabled selected>المنطقة</option>
                                    @foreach ($regions as $item)
                                        <option @selected($provider->region_id == $item->id) value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                          <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="city_id">المدينة</label>
                                <select data-selected="{{ $provider->city_id }}" name="city_id" value="{{ $provider->city_id }}" id="city_input" required>
                                    <option value="" disabled selected>المدينة</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step Two Content -->
                    <div class="row my-5">
                        @foreach ($attachments as $key => $files)
                            <div class="col-md-4 col-lg-3">
                                <div class="upload_documents">
                                    <label class="file-label">*{{ $key }}</label>
                                    <label class="upload_documents_box" for="fileInput{{ $loop->iteration }}">
                                        <div class="icon">
                                            <svg width="33" height="33" viewBox="0 0 33 33" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9"
                                                    stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF"
                                                    stroke-width="2.66667" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                        <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                        <input type="file"
                                            name="{{ $files['name'] }}{{ $files['multiple'] == true ? '[]' : '' }}"
                                            id="fileInput{{ $loop->iteration }}" accept=".jpg,.jpeg,.png,.pdf"
                                            style="opacity: 0" @if ($files['multiple'] == true) multiple @endif>
                                        @foreach ($files['files'] as $item)
                                            @if ($files['multiple'] == true)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="{{ route('provider.profile.preview.file', $item->id) }}" target="_blank" >
                                                            {{ $item->file_name . '.' . pathinfo($item->file_path, PATHINFO_EXTENSION) }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="delete_documents"
                                                            onclick="deleteAttachment({{ $item->id }})">x</button>
                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{ route('provider.profile.preview.file', $item->id) }}" target="_blank">
                                                    {{ $item->file_name . '.' . pathinfo($item->file_path, PATHINFO_EXTENSION) }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </label>
                                </div>
                            </div>
                        @endforeach

                    </div>


                    <!-- Step Three Content -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="specialization-options">
                                <p>:تحديد مجالت التخصص (اختيار متعدد)</p>
                                <div class="row">
                                    @foreach ($specializations as $specialization)
                                        <div class="col-6 col-md-4">
                                            <input
                                                {{ in_array($specialization->id, $selectedSpecializations->toArray()) ? 'checked' : '' }}
                                                type="checkbox" id="sp{{ $specialization->id }}"
                                                name="specializations[]" value="{{ $specialization->id }}" hidden />
                                            <label class="specialization-box"
                                                for="sp{{ $specialization->id }}">{{ $specialization->name }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="select_location">
                                <h6>تحديد نطاق العمل الجغرافي</h6>
                                <div class="row">
                                            <div class="col-md-6">
                                        <div class="input_group">
                                            <label for="region_id">المناطق</label>
                                            <select id="work_region_id" name="work_region_id[]" class="form-control"
                                                multiple required>
                                                @foreach ($regions as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, $selectedRegionIds ?? []) ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input_group">
                                            <label for="city_id">المدن</label>
                                            <select id="work_city_id" name="work_city_id[]" class="form-control" multiple
                                                required>
                                           

                                            </select>
                                        </div>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    </div>



                    <button type="submit" class="main_bg">إرسال</button>


                </form>
            </div>


        </div>

        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">


    </div>
@endsection
@section('scripts')
    <script>
        $('document').ready(function() {

            // Handle region selection change
            function loadCitiesByRegions(regionId, selectedCityId = null) {
                if (regionId) {
                    $.ajax({
                        url: '{{ route('api.cities.byregion') }}',
                        type: 'GET',
                        data: {
                            region_id: regionId
                        },
                        success: function(data) {
                            $('#city_input').empty();
                            $('#city_input').append('<option value="" disabled>المنطقة</option>');

                            $.each(data, function(index, region) {
                                let selected = (selectedCityId && region.id ==
                                    selectedCityId) ? 'selected' : '';
                                $('#city_input').append(
                                    '<option value="' + region.id + '" ' + selected + '>' +
                                    region.name + '</option>'
                                );
                            });

                            // Set the default selected option if provided
                            if (!selectedCityId) {
                                $('#city_input').prop('selectedIndex', 0);
                            }
                        }
                    });
                } else {
                    $('#city_input').empty();
                    $('#city_input').append('<option value="" disabled selected>المنطقة</option>');
                }
            }

            // On city change
            $('#region_input').change(function() {
                const regionId = $(this).val();
                loadCitiesByRegions(regionId);
            });

            // On page load: if city is pre-selected
            $(document).ready(function() {
                const cityId = $('#city_input').data(
                    'selected');
                const regionId = $('#region_input').val();

                if (regionId) {
                    loadCitiesByRegions(regionId, cityId);
                }
            });

        });
    </script>

    <!-- JS الخاص بـ Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
             // Initialize Select2
        $('#work_city_id, #work_region_id').select2({
            placeholder: 'اختر',
            width: '100%',
            dir: 'rtl'
        });

        // On region change, load cities
        $('#work_region_id').on('change', function () {
            var selectedRegionIds = $(this).val(); // array of selected region IDs
            if (selectedRegionIds.length > 0) {
                $.ajax({
                    url: '{{ route('api.cities.byregions') }}', // <- Create this new route
                    type: 'GET',
                    data: {
                        region_ids: selectedRegionIds
                    },
                    success: function (data) {
                        $('#work_city_id').empty();

                        const selectedCityIds = {!! json_encode($selectedCityIds ?? []) !!};

                        data.forEach(function (city) {
                            const isSelected = selectedCityIds.includes(city.id);
                            $('#work_city_id').append(
                                `<option value="${city.id}" ${isSelected ? 'selected' : ''}>${city.name}</option>`
                            );
                        });

                        $('#work_city_id').trigger('change'); // Refresh select2
                    }
                });
            } else {
                $('#work_city_id').empty();
            }
        });

        // Trigger load on page load (for edit form)
        if ($('#work_region_id').val().length > 0) {
            $('#work_region_id').trigger('change');
        }
    });

        function deleteAttachment(id) {
            $.ajax({
                url: '{{ route('provider.profile.delete.file') }}', // You need to create this route
                type: 'POST',
                data: {
                    file_id: id,
                    _token: $('input[name="_token"]').val()
                },
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    </script>
@endsection

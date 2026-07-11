@extends('customer.layouts.auth')
@section('title')
    إنشاء حساب جديد
@endsection
@section('content')

    <div class="auth_page">
        <div class="wrapper complete_profile">

            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box">
                <form action="{{ route('customer.register.stepThree.post', $id) }}" method="POST"
                    enctype="multipart/form-data">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <h2>إنشاء حساب جديد</h2>

                    @csrf
                    <div class="stepper mx-0 mx-md-5">
                        <div class="step ">
                            <div class="circle" style="background-color: #F5932E;">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.1673 7.38723V8.00056C15.1665 9.43818 14.701 10.837 13.8402 11.9884C12.9794 13.1399 11.7695 13.9822 10.3909 14.3898C9.01227 14.7974 7.53882 14.7485 6.1903 14.2503C4.84177 13.7521 3.69042 12.8313 2.90796 11.6253C2.1255 10.4192 1.75385 8.9926 1.84844 7.5581C1.94303 6.1236 2.49879 4.75811 3.43284 3.66528C4.36689 2.57244 5.62917 1.81082 7.03144 1.49399C8.43371 1.17717 9.90083 1.32212 11.214 1.90723"
                                        stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.5 7.33268L8.5 9.33268L15.1667 2.66602" stroke="white" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="label">البيانات الأساسية</div>
                        </div>
                        {{-- <div class="line"></div>
                        <div class="step ">
                            <div class="circle" style="background-color: #F5932E;">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.1673 7.38723V8.00056C15.1665 9.43818 14.701 10.837 13.8402 11.9884C12.9794 13.1399 11.7695 13.9822 10.3909 14.3898C9.01227 14.7974 7.53882 14.7485 6.1903 14.2503C4.84177 13.7521 3.69042 12.8313 2.90796 11.6253C2.1255 10.4192 1.75385 8.9926 1.84844 7.5581C1.94303 6.1236 2.49879 4.75811 3.43284 3.66528C4.36689 2.57244 5.62917 1.81082 7.03144 1.49399C8.43371 1.17717 9.90083 1.32212 11.214 1.90723"
                                        stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.5 7.33268L8.5 9.33268L15.1667 2.66602" stroke="white" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="label">التحقق من الهوية</div>
                        </div> --}}
                        <div class="line"></div>
                        <div class="step active">
                            <div class="circle">3</div>
                            <div class="label">إكمال الملف</div>
                        </div>
                    </div>

                    <p class="complete_info">أكمل بياناتك لتتمكن من استخدام جميع خدمات المنصة</p>

                    <div class="upload_image">
                        <label class="file-label">الصورة الشخصية (اختياري)</label>

                        <label class="upload-box" for="fileInput">
                            <div class="upload-text">
                                <svg width="51" height="51" viewBox="0 0 51 51" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_2116_332)">
                                        <g clip-path="url(#clip1_2116_332)">
                                            <path
                                                d="M39.0762 23.5742C39.0762 23.457 39.0957 23.3399 39.0957 23.2227C39.0957 16.875 34.0371 11.7383 27.7969 11.7383C23.2949 11.7383 19.4277 14.4141 17.6113 18.2813C16.8203 17.8809 15.9316 17.6465 14.9941 17.6465C12.1133 17.6465 9.71094 19.7852 9.25195 22.5781C5.79492 23.7696 3.32422 27.0801 3.32422 30.9766C3.32422 35.8789 7.24024 39.8633 12.0644 39.8633H22.0742V32.0508H17.3672L25.1992 23.877L33.0312 32.041H28.3242V39.8535H39.0957C43.5097 39.8535 47.0742 36.1914 47.0742 31.709C47.0742 27.2266 43.4902 23.584 39.0762 23.5742Z"
                                                fill="#F5932E" />
                                        </g>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_2116_332">
                                            <rect width="50" height="50" fill="white"
                                                transform="translate(0.199219 0.800781)" />
                                        </clipPath>
                                        <clipPath id="clip1_2116_332">
                                            <rect width="50" height="50" fill="white"
                                                transform="translate(0.199219 0.800781)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <span>قم بسحب وإفلات الملفات هنا</span>
                            </div>
                            <div class="upload-btn">اختر الملفات</div>
                            <input type="file" id="fileInput" name="personal_image" accept=".jpg,.jpeg,.png" multiple>
                        </label>

                        <div class="file-note">jpg,jpeg,png</div>
                    </div>


                    <div class="input_group">
                        <label for="address">العنوان الكامل*</label>
                        <input type="text" value="{{ @old('address') }}" name="address" id="searchInput"
                            placeholder="أدخل العنوان التفصيلي" required>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="input_group">
                                <label for="region">المنطقة</label>
                                <select name="region_id" id="region_input" required>
                                    <option value="" disabled selected>المنطقة</option>
                                    @foreach ($regions as $item)
                                        <option value="{{ $item->id }}"
                                            {{ @old('city_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input_group">
                                <label for="city">المدينة</label>
                                <select name="city_id" id="city_input" required>
                                    <option value="" disabled selected>المدينة</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="location_area" id="map">


                    </div>
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="latitude" id="latitude">


                    <div class="input_group">
                        <label for="payment_method">وسيلة الدفع الفضلة</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="" disabled selected>اختر وسيلة الدفع</option>
                            <option value="1" {{ @old('payment_method') == 1 ? 'selected' : '' }}>paypal</option>
                            <option value="2" {{ @old('payment_method') == 2 ? 'selected' : '' }}>Visa</option>
                        </select>
                    </div>

                    <button type="submit" class="main_bg">إنشاء الحساب</button>


                    <a href="#" class="back_step mt-0">
                        السابق
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.832 8.5H3.16537M3.16537 8.5L7.16536 4.5M3.16537 8.5L7.16536 12.5" stroke="#0C0C0C"
                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                </form>
            </div>

        </div>

        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">

    </div>

    <script src="../../../../assets/js/password-toggle.js"></script>

@endsection

@section('scripts')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?libraries=places&language=ar&key=AIzaSyBGWvk8gWZqa1kHfTvODmKxoYes00z8Vi0&callback=initMap"
        async defer></script>


    <script>
        $('document').ready(function() {
            // Handle region selection change
            $('#region_input').change(function() {
                var regionId = $(this).val();
                if (regionId) {
                    $.ajax({
                        url: '{{ route('api.cities.byregion') }}',
                        type: 'GET',
                        data: {
                            region_id: regionId
                        },
                        success: function(data) {
                            $('#city_input').empty();
                            $('#city_input').append(
                                '<option value="" disabled selected>المنطقة</option>');
                            $.each(data, function(index, city) {
                                $('#city_input').append('<option value="' + city
                                    .id + '">' + city.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city_input').empty();
                    $('#city_input').append('<option value="" disabled selected>المدينة</option>');
                }
            });
        });
    </script>





    <script>
        function initMap() {
            let defaultLatitude = parseInt($("#default-latitude").val() ?? -33.8688);
            let defaultLongitude = parseInt($("#default-longitude").val() ?? 151.2195);

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: defaultLatitude,
                    lng: defaultLongitude
                },
                zoom: 8
            });
            var input = document.getElementById('searchInput');

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                draggable: true,

                position: {
                    lat: defaultLatitude,
                    lng: defaultLongitude
                },
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });
            google.maps.event.addListener(marker, 'dragend', function(event) {
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({
                    latLng: event.latLng
                }, function(results, status) {
                    console.log(results);
                    if (status === google.maps.GeocoderStatus.OK && results[0]) {
                        const address_components = results[0].address_components;

                        let city = '';
                        let region = '';
                        let country = '';
                        const full_address = results[0].formatted_address;

                        // Loop through components to extract values
                        address_components.forEach(component => {
                            const types = component.types;

                            if (types.includes('locality')) {
                                city = component.long_name;
                            }

                            // Fallback if city not found
                            if (!city && types.includes('administrative_area_level_2')) {
                                city = component.long_name;
                            }

                            if (types.includes('administrative_area_level_1')) {
                                region = component.long_name;
                            }

                            if (types.includes('country')) {
                                country = component.long_name;
                            }
                        });

                        // Update the form fields
                        $('#searchInput').val(full_address);
                        $('#address').val(full_address);
                        $('#latitude').val(event.latLng.lat());
                        $('#longitude').val(event.latLng.lng());

                    } else {
                        console.warn('Geocoder failed due to:', status);
                    }
                });
            });

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }


                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setIcon(({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);

                // Location details
                for (var i = 0; i < place.address_components.length; i++) {

                    if (place.address_components[i].types[0] == 'locality') {
                        $('#city').val(place.address_components[i].long_name);


                    }
                    if (place.address_components[i].types[0] == 'country') {
                        $('#country').val(place.address_components[i].long_name);


                    }
                    if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                        $('#state').val(place.address_components[i].long_name);


                    }
                }

                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                $('#address').val(place.formatted_address);


                $('#latitude').val(place.geometry.location.lat());
                $('#longitude').val(place.geometry.location.lng());

            });
        }

        jQuery(document).ready(function() {
            let defaultLatitude = parseInt($("#default-latitude").val() ?? -33.8688);
            let defaultLongitude = parseInt($("#default-longitude").val() ?? 151.2195);

            initMap();
            $('#map').append('<iframe src="https://maps.google.com/maps?q=' + defaultLatitude + ',' +
                defaultLongitude +
                '&hl=en&amp;z=18&amp;output=embed" height="375px" width="800px"></iframe>');



        });
    </script>

@endsection

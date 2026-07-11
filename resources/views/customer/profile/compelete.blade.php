@extends('customer.layouts.auth')

@section('content')
    <div class="auth_page">
        <div class="wrapper complete">

            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box ">
                <form action="{{ route('customer.compelete.account.post' , $customer->id) }}" method="POST" enctype="multipart/form-data">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <h2 class="mb-4">إستكمال بياناتك</h2>

                    <div class="row">

                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="full_name">الاسم كامل*</label>
                                <input type="text" name="full_name" value="{{ $customer->full_name }}" id="full_name"
                                    placeholder="الاسم كامل" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="national_id">رقم الهوية الوطنية/الإقامة*</label>
                                <input type="text" name="national_id" value="{{ $customer->national_id }}"
                                    id="national_id" placeholder="1234567890" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="phone_number">رقم الهاتف المحمول*</label>
                                <input type="text" name="phone_number" value="{{ $customer->phone_number }}"
                                    id="phone_number" placeholder="+966 50 123 4567" required>
                                <button class="confirm_phone">التحقق من الهاتف المحمول</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="input_group">
                                <label for="email">البريد الإلكتروني*</label>
                                <input type="email" name="email" value="{{ $customer->email }}" id="email"
                                    placeholder="example@mail.com" required>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12">
                            <div class="input_group">
                                <label for="full_address">العنوان الكامل*</label>
                                <input type="text" name="address" value="{{ $customer->address }}" id="searchInput"
                                    placeholder="أدخل العنوان التفصيلي" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="location_area" id="map">
                            </div>
                            <input type="hidden" name="longitude"  value="{{ $customer->longitude }}" id="longitude">
                            <input type="hidden" name="latitude"  value="{{ $customer->latitude }}" id="latitude">
                            <input type="hidden" value="{{ $customer->longitude }}" id="default-longitude">
                            <input type="hidden" value="{{ $customer->latitude }}" id="default-latitude">

                        </div>


                          <div class="col-md-6 col-lg-6">
                            <div class="input_group">
                                <label for="region">المنطقة</label>
                                <select  name="region_id" id="region_input" required>
                                    <option value="" disabled selected>المنطقة</option>
                                        @foreach ($regions as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $customer->region_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="input_group">
                                <label for="city">المدينة</label>
                                <select data-selected="{{ $customer->city_id }}" name="city_id" id="city_input"  value="{{ $customer->city_id }}" required>
                                    <option value="" disabled selected>المدينة</option>
                                   
                                </select>
                            </div>
                        </div>
                      
                        <div class="col-md-12">
                            <div class="input_group">
                                <label for="payment_method">وسيلة الدفع الفضلة</label>
                                <select name="payment_method" id="payment_method" required>
                                    <option value="" disabled selected>اختر وسيلة الدفع</option>
                                    <option value="1" {{ $customer->payment_method == 1 ? 'selected' : '' }}>paypal
                                    </option>
                                    <option value="2" {{ $customer->payment_method == 2 ? 'selected' : '' }}>Visa
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
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
                                    <button class="upload-btn">اختر الملفات</button>
                                    <input type="file" id="fileInput" name="personal_image" accept=".jpg,.jpeg,.png"
                                        multiple>
                                </label>

                                @if($customer->personal_image)
                                <div class="file-note"><a href="{{ Storage::url($customer->personal_image) }}">current image</a></div>
                                @endif
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
                                '<option value="" disabled selected>--</option>');
                            $.each(data, function(index, region) {
                                $('#city_input').append('<option value="' + region
                                    .id + '">' + region.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#region_input').empty();
                    $('#region_input').append('<option value="" disabled selected>المدينة</option>');
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
                            console.log(data)
                              $('#city_input').empty();
                              $('#city_input').append('<option value="" disabled>--</option>');

                              $.each(data, function(index, city) {
                                  let selected = (selectedCityId && city.id ==
                                      selectedCityId) ? 'selected' : '';
                                  $('#city_input').append(
                                      '<option value="' + city.id + '" ' + selected + '>' +
                                      city.name + '</option>'
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
      <script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
        const errors = [];

        const fullName = document.getElementById("full_name").value.trim();
        const nationalId = document.getElementById("national_id").value.trim();
        const phoneNumber = document.getElementById("phone_number").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const agreeTerms = document.getElementById("agree_terms").checked;

        // Full name required
        if (fullName === "") {
            errors.push("يرجى إدخال الاسم الكامل.");
        }

        // National ID: required and 10 digits
        if (!/^\d{10}$/.test(nationalId)) {
            errors.push("رقم الهوية يجب أن يكون مكونًا من 10 أرقام.");
        }

        // Saudi mobile number format
        if (!/^0?5\d{8}$/.test(phoneNumber)) {
            errors.push("يرجى إدخال رقم جوال سعودي صحيح يبدأ بـ 5 ويتكون من 9 أرقام.");
        }

        // Email format
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
            errors.push("يرجى إدخال بريد إلكتروني صالح.");
        }

        // Password minimum length
        if (password.length < 6) {
            errors.push("كلمة المرور يجب أن تكون 6 أحرف على الأقل.");
        }

        // Password match
        if (password !== confirmPassword) {
            errors.push("كلمتا المرور غير متطابقتين.");
        }

        // Terms checkbox
        if (!agreeTerms) {
            errors.push("يجب الموافقة على الشروط والأحكام.");
        }

        if (errors.length > 0) {
            e.preventDefault();

            let alertBox = document.querySelector(".alert.alert-danger");
            if (!alertBox) {
                alertBox = document.createElement("div");
                alertBox.className = "alert alert-danger";
                form.prepend(alertBox);
            }

            alertBox.innerHTML = "<ul>" + errors.map(e => `<li>${e}</li>`).join('') + "</ul>";
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
});
</script>
@endsection

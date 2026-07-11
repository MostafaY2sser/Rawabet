  <div class="step_two ">

      <div class="content_step">

          <div class="step_neme">
              <h3>تفاصيل الخدمة</h3>
              <p>أدخل تفاصيل مشروعك والخدمات المطلوبة</p>
          </div>

          <script type="module"
              src="https://ajax.googleapis.com/ajax/libs/@googlemaps/extended-component-library/0.6.11/index.min.js"></script>


          <form action="{{ route('customer.project.update', ['step' => 2, 'id' => $project->id]) }}" method="POST" style="padding-bottom: 20px">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              @method('PUT')
              @csrf
              <div class="form_box">
                  <div class="row">


                      <div class="details-options">
                          <div class="row">
                              <p class="type_order">نوع الخدمة المطلوبة</p>
                              @foreach ($serviceTypes as $item)
                                  <div class="col-6 col-md-4">
                                      <input @checked($project->service_type == $item->id) type="radio" id="pd{{ $item->id }}"
                                          name="service_type" value="{{ $item->id }}" hidden />
                                      <label class="specialization-box"
                                          for="pd{{ $item->id }}">{{ $item->name }}</label>
                                  </div>
                              @endforeach

                          </div>
                      </div>

                      <div class="location">
                          <h5>الموقع الجغرافي</h5>
                          <div class="input_group">
                              <label for="order_location">عنوان الطلب</label>
                              <input id="searchInput" type="text" value="{{ $project->address ?? old('address') }}"
                                  name="address" id="order_location" placeholder="أدخل العنوان التفصيلي" required>
                          </div>
                          <small>move the pin to select your location</small>
                          <div class="location_map" id="map" style="width: 100%; height: 300px;"></div>
                          <input type="hidden" id="default-latitude"
                              value="{{ $project->latitude ?? old('latitude', 24.7136) }}">
                          <input type="hidden" id="default-longitude"
                              value="{{ $project->longitude ?? old('longitude', 46.6753) }}">
                          <input type="hidden" id="latitude" name="latitude"
                              value="{{ $project->latitude ?? old('latitude', 24.7136) }}">
                          <input type="hidden" id="longitude" name="longitude"
                              value="{{ $project->longitude ?? old('longitude', 46.6753) }}">
                          <input type="hidden" id="country" name="country"
                              value="{{ $project->country ?? old('country') }}">
                          <input type="hidden" id="address" name="address"
                              value="{{ $project->address ?? old('address') }}">
                      </div>
                      <div class="row mb-4">
                          <div class="col-md-6">
                              <div class="input_group">
                                  <label for="region"> المنطقة</label>
                                  <select  name="region_id" id="region_input"
                                      required>
                                      <option value="" disabled selected> المنطقة</option>
                                      @foreach ($regions as $item)
                                          <option value="{{ $item->id }}"
                                              {{ $project->region_id == $item->id ? 'selected' : '' }}>
                                              {{ $item->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="input_group">
                                  <label for="city">المدينة</label>
                                  <select data-selected="{{ $project->city_id }}" name="city_id" id="city_input" required>
                                      <option value="" disabled selected>المدينة</option>
                                  </select>
                              </div>
                          </div>

                      </div>

                      <div class="property_type">
                          <h6>نوع العقار</h6>
                          <div class="row">
                              @foreach ($buildingTypes as $item)
                                  <div class="col-6">
                                      <div class="input_group">
                                          <input @checked($project->building_type == $item->id) type="radio" name="building_type"
                                              id="type{{ $item->id }}" value="{{ $item->id }}"
                                                style="width: 20px; height: 20px;"
                                              />
                                          <label for="type{{ $item->id }}">{{ $item->name }}</label>
                                      </div>
                                  </div>
                              @endforeach


                          </div>
                      </div>

                      <div class="description">
                          <h5>وصف الأعمال المطلوبة</h5>
                          <div class="input_group">
                              <label for="category">التصنيف</label>
                              <select name="category_id" id="category">
                                  @foreach ($categories as $item)
                                      <option @selected($project->category_id == $item->id) value="{{ $item->id }}">
                                          {{ $item->name }}
                                      </option>
                                  @endforeach

                              </select>
                          </div>
                          <div class="input_group">
                              <label for="property_description">وصف الاعمال</label>
                              <textarea name="work_description" id="property_description"
                                  placeholder="اكتب وصفاً تفصيلياً للأعمال المطلوبة (حد أقصى 500 حرف)">{{ $project->work_description ?? old('work_description') }}</textarea>
                          </div>
                      </div>

                  </div>
              </div>

              {{-- <button type="submit">save</button> --}}
              <div class="buttons">
                    <a class="back_cancel"
                        href="{{ route('customer.project.edit', ['step' => 1, 'id' => $project->id]) }}">
                        <i class="fa-solid fa-arrow-right"></i>
                        السابق 
                    </a>
                    <button type="submit" class="main_btn_bg next_step ">
                        <span>التالي</span>
                      <i class="fa-solid fa-arrow-left"></i>
                  </button>

              </div>
          </form>


      </div>

  </div>



  @push('scripts')
      <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?libraries=places&language=ar&key=AIzaSyBGWvk8gWZqa1kHfTvODmKxoYes00z8Vi0&callback=initMap"
          async defer></script>

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
                          $('#city').val(city);
                          $('#region').val(region);
                          $('#country').val(country);
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

                      //   if (place.address_components[i].types[0] == 'locality') {
                      //       $('#city').val(place.address_components[i].long_name);


                      //   }
                      //   if (place.address_components[i].types[0] == 'country') {
                      //       $('#country').val(place.address_components[i].long_name);


                      //   }
                      //   if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                      //       $('#state').val(place.address_components[i].long_name);


                      //   }
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
              function loadRegionsByCity(regionId, selectedRegionId = null) {
                  if (regionId) {
                      $.ajax({
                          url: '{{ route('api.cities.byregion') }}',
                          type: 'GET',
                          data: {
                              region_id: regionId
                          },
                          success: function(data) {
                              $('#city_input').empty();
                              $('#city_input').append('<option value="" disabled>المدينة</option>');

                              $.each(data, function(index, region) {
                                  let selected = (selectedRegionId && region.id ==
                                      selectedRegionId) ? 'selected' : '';
                                  $('#city_input').append(
                                      '<option value="' + region.id + '" ' + selected + '>' +
                                      region.name + '</option>'
                                  );
                              });

                              // Set the default selected option if provided
                              if (!selectedRegionId) {
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
                  loadRegionsByCity(regionId);
              });

              // On page load: if city is pre-selected
              $(document).ready(function() {
                  const regionId = $('#region_input').val();
                  const cityId = $('#city_input').data(
                      'selected');

                  if (regionId) {
                      loadRegionsByCity(regionId, cityId);
                  }
              });

          });
      </script>
  @endpush

@extends('site.layouts.main')


{{-- change style header in some pages --}}
@section('body-class', 'dark_header ')


@section('content')
    <div class="project_details">
        @include('site.components.breadcrumb', [
            'title' => 'قائمة المشاريع',
            'urls' => [
                ['name' => 'المشاريع', 'url' => '/projects'],
                ['name' => 'تفاصيل المشروع', 'url' => '/projects/details'],
            ],
        ])

        <div class="container">
            <div class="details_box">
                <div class="info">
                    <div class="image">
                        <img src="../../../../assets/images/building.png" alt="">
                    </div>
                    <h3 class="type_building">{{ $project->serviceType->name }} {{ $project->buildingType->name }}</h3>
                    <div class="date">
                        <p>:تاريخ النشر</p>
                        <span>{{ \Carbon\Carbon::parse($project->created_at)->locale('ar')->translatedFormat('l j F Y') }}</span>
                    </div>
                    <p class="descripption">{{ $project->work_description }}</p>
                </div>




                {{-- progress step --}}
                <div class="progress_step " style="">
                    <ul class="list-unstyled multi-steps">
                        <li>
                            <span class="top">تاريخ النشر</span>
                            <span
                                class="bottom">{{ \Carbon\Carbon::parse($project->created_at)->locale('ar')->translatedFormat('l j F Y') }}</span>
                        </li>
                         <li class="is-active">
                            <span class="top">فتح العروض</span>
                            <span class="bottom">{{ \Carbon\Carbon::parse($project->open_for_offers_date)?->format('Y-m-d') ?? '---' }}</span>
                        </li>
                        <li>
                         <span class="top">قبول العروض</span>
                    <span class="bottom">{{ $project->accept_offer_date?->format('Y-m-d') ?? '---' }}</span>
                        <li>
                           <span class="top">تاريخ الترسيه</span>
                    <span class="bottom">{{ $project->start_date }}</span>
                        </li>
                      
                       
                        
                    </ul>
                </div>
                {{-- progress step --}}




                <div class="details">

                    <div class="buttons">
                        <button id="project-details-btn">
                            <span>تفاصيل المشروع</span>
                            <i class="fa-solid fa-maximize"></i>
                        </button>
                        <button id="project-file-btn">
                            <span>ملفات المشروع</span>
                            <i class="fa-regular fa-circle-play"></i>
                        </button>
                        <button id="project-images-btn">
                            <span>الصور</span>
                            <i class="fa-solid fa-image"></i>
                        </button>
                    </div>

                    <div class="content">
                        <div class="project_details section">
                            <div class="head">
                                <h6>التفاصيل</h6>
                                <p>اطلع علي تفاصيل وكافة المعلومات الخاصة بالمشروع</p>
                            </div>

                            <div class="table">
                                <div class="line">
                                    <div class="value">{{ \App\Enums\ProjectStatus::getLabel($project->status) }}</div>
                                    <div class="title">حالة المشروع</div>
                                </div>
                                <div class="line">
                                    <div class="value">
                                        {{ \Carbon\Carbon::parse($project->start_date)->addMonths($project->duration)->locale('ar')->translatedFormat('l j F Y') }}
                                    </div>
                                    <div class="title">التاريخ المتوقع لتسليم المشروع</div>
                                </div>
                                <div class="line">
                                    <div class="value">{{ $project->address }}</div>
                                    <div class="title">الموقع</div>
                                </div>
                                <div class="line">
                                    <div class="value">{{ $project->ServiceType->name }}</div>
                                    <div class="title">الأنشطة</div>
                                </div>
                                <div class="line">
                                    <div class="value">{{ $project->category->name }}</div>
                                    <div class="title">التصنيف</div>
                                </div>
                                <div class="line">
                                    <div class="value">
                                        {{ \Carbon\Carbon::parse($project->created_at)->locale('ar')->translatedFormat('l j F Y') }}
                                    </div>
                                    <div class="title">تاريخ النشر</div>
                                </div>
                                 <div class="line">
                                    @if (\App\Enums\ProjectStatus::getStatusOrder($project->status) > 4)
                                        
                                    <div class="value">{{ \Carbon\Carbon::parse($project->open_for_offers_date)->locale('ar')->translatedFormat('l j F Y') }}</div>
                                    @else
                                    <div class="value"></div>

                                    @endif

                                    <div class="title">فتح العروض</div>
                                </div>
                                <div class="line">
                                     @if (\App\Enums\ProjectStatus::getStatusOrder($project->status) > 5)
                                        <div class="value"></div>
                                        @else
                                        <div class="value"></div>

                                    @endif      
                                    <div class="title">قبول العروض</div>
                                </div>
                               

                                <div class="line">
                                    <div class="value">
                                        
                                    </div>
                                    <div class="title">التعميد المتوقع</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
                
                <div class="location" id="map">
                    <input type="hidden" id="default-latitude" value="{{ $project->latitude ?? old('latitude', 24.7136) }}">
                    <input type="hidden" id="default-longitude" value="{{ $project->longitude ?? old('longitude', 46.6753) }}">
                </div>

            </div>
        </div>



    </div>
@endsection
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
              draggable: false,

              position: {
                  lat: defaultLatitude,
                  lng: defaultLongitude
              },
              map: map,
              anchorPoint: new google.maps.Point(0, -29)
          });
    

          
      }

      jQuery(document).ready(function() {

           let defaultLatitude = parseInt($("#default-latitude").val() ?? -33.8688);
          let defaultLongitude = parseInt($("#default-longitude").val() ?? 151.2195);

          initMap();
          $('#map').append('<iframe src="https://maps.google.com/maps?q=' + defaultLatitude + ',' + defaultLongitude +
              '&hl=en&amp;z=18&amp;output=embed" height="375px" width="800px"></iframe>');



      });
  </script>
     
 @endpush
@extends('site.layouts.main')

{{-- change style header in some pages --}}
@section('body-class', 'dark_header ')

@section('content')

    <div class="provider_details">

        @include('site.components.breadcrumb' , ['title'=>" مزودي الخدمات" ,
       'urls'=>
       [
        ["name"=>"مزودي الخدمات" , "url"=>'/providers'],
        ["name"=>"تفاصيل مزودي الخدمات","url"=>"/providers/details"]
        ]
])


 <div class="container">
            <section class="hero ">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <h3 class="title-section">{{$provider->company_name}}</h3>
                        <div class="rating  d-flex  align-items-center">
                            <img src="../../../../assets/images/home/star.png" alt="">
                            <img src="../../../../assets/images/home/star.png" alt="">
                            <img src="../../../../assets/images/home/star.png" alt="">
                            <img src="../../../../assets/images/home/star.png" alt="">
                            <img src="../../../../assets/images/home/star.png" alt="">
                            <span>4.9</span>
                        </div>
                        <p class="title-2">بناء فيلا عظم أو تسليم مفتاح على مساحة أرض 2500 م مساحة البناء لا تتجاوز 700 م من
                            مسطحات البناء
                            عدد الطوابق
                            عبارة عن قبو سفلي و دور أرضي و دور الأول و ملحق المواد المستخدمة تطابق المواصفات البناء للكود
                            السعودي للبناء
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-12 ">
                        <div class="hero-img">
                            <img src="CompanyLogo-1701335598_sesksalogo12 1.png" alt="">
                        </div>
                    </div>
                </div>
                <h3 class="specialti_title">التخصصات</h3>
                <div class="specialti d-flex  align-items-center">
                     @foreach($provider->specializations as $speciality)
                        <div>
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                d="M4.41243 4.91219H4.41827M6.43193 2.5498H4.85005C3.86996 2.5498 3.37991 2.5498 3.00557 2.74054C2.67628 2.90832 2.40857 3.17604 2.24079 3.50532C2.05005 3.87966 2.05005 4.36971 2.05005 5.3498V6.93169C2.05005 7.35968 2.05005 7.5737 2.0984 7.77513C2.14127 7.95369 2.21198 8.12437 2.30793 8.281C2.41615 8.45757 2.56748 8.60889 2.87015 8.91158L5.61182 11.6532C6.30482 12.3462 6.65138 12.6928 7.05091 12.8226C7.40242 12.9368 7.78101 12.9368 8.13252 12.8226C8.53205 12.6928 8.87861 12.3462 9.57161 11.6532L11.1535 10.0714C11.8465 9.37836 12.193 9.0318 12.3228 8.63228C12.4371 8.28076 12.4371 7.90218 12.3228 7.55066C12.193 7.15114 11.8465 6.80458 11.1535 6.11157L8.41182 3.36991C8.10913 3.06724 7.95782 2.9159 7.78124 2.80768C7.62462 2.71173 7.45393 2.64103 7.27537 2.59816C7.07395 2.5498 6.85992 2.5498 6.43193 2.5498ZM4.7041 4.91219C4.7041 5.07328 4.57352 5.20385 4.41243 5.20385C4.25135 5.20385 4.12077 5.07328 4.12077 4.91219C4.12077 4.75111 4.25135 4.62052 4.41243 4.62052C4.57352 4.62052 4.7041 4.75111 4.7041 4.91219Z"
                                stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <b>{{ $speciality->name }}</b>
                        </div>
                     @endforeach
                </div>
    
    
                <div class="details container">
                    <div class="row">
                        <h3 class="specialti_title">التفاصيل</h3>
                        <p>اطلع علي تفاصيل وكافة المعلومات الخاصة بالمشروع</p>
                        <div class="rows">
                            <div class="d-flex align-items-center  data ">
                            <span>عضو منذ</span>
                      <p>{{ $provider->created_at->locale('ar')->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="d-flex align-items-center data">
                                <span> رقم الجوال</span>
                                <p>{{$provider->phone_number}}</p>
                            </div>
                            <div class="d-flex align-items-center data">
                                <span>البريد الالكتروني</span>
                                <p>{{$provider->email}}</p>
                            </div>
                            <div class="d-flex align-items-center data">
                                <span>منطقة العمل</span>
                                @foreach ($provider->workRegions as $item)
                                    <p>{{ $item->name }}</p>
                                @endforeach
                            </div>
                            <div class="d-flex align-items-center data">
                                <span>سنوات الخبرة</span>
                                {{-- <p>آكثر من 5 سنوات</p> --}}
                            </div>
                            <div class="d-flex align-items-center data">
                                <span>عدد الموظفين</span>
                                {{-- <p>96</p> --}}
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="location mt-5" id="map">
                    <input type="hidden" id="default-latitude" value="{{ $project->latitude ?? old('latitude', 24.7136) }}">
                    <input type="hidden" id="default-longitude" value="{{ $project->longitude ?? old('longitude', 46.6753) }}">
                </div>

            </section>
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
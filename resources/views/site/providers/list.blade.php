@extends('site.layouts.main')

{{-- change style header in some pages --}}
@section('body-class', 'dark_header ')

@section('content')

    <div class="provider_details">

        @include('site.components.breadcrumb' , ['title'=>"مزودي الخدمات" ,
       'urls'=>
       [
        ["name"=>"مزودي الخدمات" , "url"=>'/projects']
        ]

])
        <div class="container">
            <div class="fillter_search">
                <form action="" method="GET">
                    <div class="input_group">
                        <div class="icon">
                            <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.6748 19.6758L15.6124 16.6133M17.7998 11.3633C17.7998 15.4709 14.4699 18.8008 10.3623 18.8008C6.25468 18.8008 2.9248 15.4709 2.9248 11.3633C2.9248 7.25566 6.25468 3.92578 10.3623 3.92578C14.4699 3.92578 17.7998 7.25566 17.7998 11.3633Z" stroke="#A4A4A4" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <input type="search" name="keyword"    value="{{ request('keyword') }}"
                            id="searchInput" placeholder="ادخل كلمة البحث">
                    </div>
                    <div class="input_group">
                        <div class="icon">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.0996 21C15.5996 17.4 19.0996 14.1764 19.0996 10.2C19.0996 6.22355 15.9656 3 12.0996 3C8.23362 3 5.09961 6.22355 5.09961 10.2C5.09961 14.1764 8.59961 17.4 12.0996 21Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.0996 13C13.7565 13 15.0996 11.6569 15.0996 10C15.0996 8.34315 13.7565 7 12.0996 7C10.4427 7 9.09961 8.34315 9.09961 10C9.09961 11.6569 10.4427 13 12.0996 13Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <select name="region_id" id="region_id">
                            <option value="1">الرباض</option>
                            <option value="2">مكة</option>
                            <option value="3">المدينة</option>
                        </select>
                    </div>
                    <div class="input_group">
                        <div class="icon">
                            <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.68286 9.16671H6.51619C8.34953 9.16671 9.26619 8.25004 9.26619 6.41671V4.58337C9.26619 2.75004 8.34953 1.83337 6.51619 1.83337H4.68286C2.84953 1.83337 1.93286 2.75004 1.93286 4.58337V6.41671C1.93286 8.25004 2.84953 9.16671 4.68286 9.16671Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.6829 9.16671H17.5162C19.3495 9.16671 20.2662 8.25004 20.2662 6.41671V4.58337C20.2662 2.75004 19.3495 1.83337 17.5162 1.83337H15.6829C13.8495 1.83337 12.9329 2.75004 12.9329 4.58337V6.41671C12.9329 8.25004 13.8495 9.16671 15.6829 9.16671Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.6829 20.1667H17.5162C19.3495 20.1667 20.2662 19.25 20.2662 17.4167V15.5834C20.2662 13.75 19.3495 12.8334 17.5162 12.8334H15.6829C13.8495 12.8334 12.9329 13.75 12.9329 15.5834V17.4167C12.9329 19.25 13.8495 20.1667 15.6829 20.1667Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.68286 20.1667H6.51619C8.34953 20.1667 9.26619 19.25 9.26619 17.4167V15.5834C9.26619 13.75 8.34953 12.8334 6.51619 12.8334H4.68286C2.84953 12.8334 1.93286 13.75 1.93286 15.5834V17.4167C1.93286 19.25 2.84953 20.1667 4.68286 20.1667Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>      
                        </div>
                        <select name="fillter" id="fillter">
                            <option value="1">فيلا</option>
                            <option value="2">شقة</option>
                            <option value="3">مول</option>
                        </select>
                    </div>
                    <button type="submit" class="main_button_bg">بحث</button>
                </form>
            </div>


        
            <div class="row mt-md-5">
                {{-- provider List --}}
                <div class="provider_list_page">
                    <div class="row mt-5" id="provider-container">
                        @foreach ($providers as $provider)
                            <div class="col-md-6 col-lg-4 provider-card">
                                @include('site.components.provider-card', ['provider' => $provider])
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($providers->count() > 0)
                    <!-- Pagination Controls -->
                    <div class="pagination mt-3 mb-5">
                        <button id="nextBtnSite"><i class="fa-solid fa-angle-right"></i></button>
                        <div id="pageNumbersSite" class="pageNumbers"></div>
                        <button id="prevBtnSite"><i class="fa-solid fa-angle-left"></i></button>
                    </div>
                @endif
                
            </div>

        
    </div>

 @include('site.components.faq')

    {{-- Pagination file js  --}}
    <script src="../../../../assets/js/pagination.js?v={{ time() }}"></script>
    @endsection






    
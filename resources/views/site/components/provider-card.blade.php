<div class="provider">
    <div class="image">
        <img src="{{ asset('assets/images/home/Provider_image.png') }}" alt="provider">

    </div>
    <h1 class="name">{{$provider->company_name}}</h1>
    <div class="rating">
        <div class="stars">
            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
            <img src="{{ asset('assets/images/home/star.png') }}" alt="">

        </div>
        <span class="num">4.9</span>
    </div>

    <div class="specializations">
        <h6>التخصصات</h6>
        <div class="box">
             @foreach($provider->specializations as $speciality)
            <div class="Specializate">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                    d="M4.41243 4.91219H4.41827M6.43193 2.5498H4.85005C3.86996 2.5498 3.37991 2.5498 3.00557 2.74054C2.67628 2.90832 2.40857 3.17604 2.24079 3.50532C2.05005 3.87966 2.05005 4.36971 2.05005 5.3498V6.93169C2.05005 7.35968 2.05005 7.5737 2.0984 7.77513C2.14127 7.95369 2.21198 8.12437 2.30793 8.281C2.41615 8.45757 2.56748 8.60889 2.87015 8.91158L5.61182 11.6532C6.30482 12.3462 6.65138 12.6928 7.05091 12.8226C7.40242 12.9368 7.78101 12.9368 8.13252 12.8226C8.53205 12.6928 8.87861 12.3462 9.57161 11.6532L11.1535 10.0714C11.8465 9.37836 12.193 9.0318 12.3228 8.63228C12.4371 8.28076 12.4371 7.90218 12.3228 7.55066C12.193 7.15114 11.8465 6.80458 11.1535 6.11157L8.41182 3.36991C8.10913 3.06724 7.95782 2.9159 7.78124 2.80768C7.62462 2.71173 7.45393 2.64103 7.27537 2.59816C7.07395 2.5498 6.85992 2.5498 6.43193 2.5498ZM4.7041 4.91219C4.7041 5.07328 4.57352 5.20385 4.41243 5.20385C4.25135 5.20385 4.12077 5.07328 4.12077 4.91219C4.12077 4.75111 4.25135 4.62052 4.41243 4.62052C4.57352 4.62052 4.7041 4.75111 4.7041 4.91219Z"
                    stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{{ $speciality->name }}</span>
            </div>
             @endforeach
           
        </div>
    </div>
    <a href="{{route('providers.show', $provider->id)}}" class="main_button">آطلع علي مزود الخدمة</a>
</div>
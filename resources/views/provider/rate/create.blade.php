@extends('provider.layouts.main')

@section('content')
  <section class="feedback"  id="main_page" >

        <div class="header">
            <div class="card-x-header">
                <h3>تقييم تجربة المشروع</h3>
                <a href="" class="cancel ">
                    <p>إلغاء</p>
                    <i class="fa-solid fa-x"></i>
                </a>
            </div>

            <div class="start-text">
                <span>{{ $offer->project->serviceType?->name }} {{ $offer->project->buildingType?->name }}</span>
                <span>يرجى تقييم تجربتك في هذا المشروع لمساعدتنا في تحسين الخدمة</span>
            </div>
        </div>

        <form action="{{ route('provider.rate.store' , $offer->id) }}" method="POST">
              @if($errors->any())
                        <div  class="input_error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
            <div class="rate-say">
                <div class="box">
@csrf
                    <div class="icon icon-1">
                        <i class="fa-regular fa-user"></i>
                    </div>

                    <div class="text">
                        <span>تقييم العميل</span>
                        <p>تقييم عام لأداء العميل في هذا المشروع</p>
                    </div>
                </div>
                <div class="box-rate">
                    <p>التقييم (من 1 إلى 5 نجوم)</p>
                    <div class="rating">
                        <i class="fa-solid fa-star" data-value="1"></i>
                        <i class="fa-solid fa-star" data-value="2"></i>
                        <i class="fa-solid fa-star" data-value="3"></i>
                        <i class="fa-solid fa-star" data-value="4"></i>
                        <i class="fa-solid fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="customer_rating" class="ratingValue" value="0">
                </div>
                <div class="notes">
                    <p>ملاحظات وتعليقات (اختياري)</p>
                    <textarea name="customer_comment" id="" placeholder="أضف ملاحظاتك حول تقييم المقاول..."></textarea>
                </div>
            </div>

          

            

            <div class="rate-say">
                <div class="box">

                    <div class="icon icon-5">

                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.4173 2.79688H11.9773C11.4468 2.79688 10.9381 3.00759 10.5631 3.38266C10.188 3.75773 9.97727 4.26644 9.97727 4.79688V4.97687C9.97691 5.3276 9.88432 5.67206 9.70881 5.97571C9.53329 6.27936 9.281 6.53151 8.97727 6.70687L8.54727 6.95687C8.24323 7.13241 7.89834 7.22482 7.54727 7.22482C7.19619 7.22482 6.85131 7.13241 6.54727 6.95687L6.39727 6.87687C5.93833 6.61214 5.3931 6.54032 4.88127 6.67718C4.36943 6.81405 3.93282 7.14841 3.66727 7.60687L3.44727 7.98688C3.18253 8.44581 3.11071 8.99104 3.24758 9.50287C3.38444 10.0147 3.7188 10.4513 4.17727 10.7169L4.32727 10.8169C4.62954 10.9914 4.88089 11.242 5.05632 11.5437C5.23175 11.8454 5.32516 12.1878 5.32727 12.5369V13.0469C5.32867 13.3993 5.23692 13.7458 5.06131 14.0514C4.8857 14.3569 4.63248 14.6107 4.32727 14.7869L4.17727 14.8769C3.7188 15.1424 3.38444 15.579 3.24758 16.0909C3.11071 16.6027 3.18253 17.1479 3.44727 17.6069L3.66727 17.9869C3.93282 18.4453 4.36943 18.7797 4.88127 18.9166C5.3931 19.0534 5.93833 18.9816 6.39727 18.7169L6.54727 18.6369C6.85131 18.4613 7.19619 18.3689 7.54727 18.3689C7.89834 18.3689 8.24323 18.4613 8.54727 18.6369L8.97727 18.8869C9.281 19.0622 9.53329 19.3144 9.70881 19.618C9.88432 19.9217 9.97691 20.2661 9.97727 20.6169V20.7969C9.97727 21.3273 10.188 21.836 10.5631 22.2111C10.9381 22.5862 11.4468 22.7969 11.9773 22.7969H12.4173C12.9477 22.7969 13.4564 22.5862 13.8315 22.2111C14.2066 21.836 14.4173 21.3273 14.4173 20.7969V20.6169C14.4176 20.2661 14.5102 19.9217 14.6857 19.618C14.8612 19.3144 15.1135 19.0622 15.4173 18.8869L15.8473 18.6369C16.1513 18.4613 16.4962 18.3689 16.8473 18.3689C17.1983 18.3689 17.5432 18.4613 17.8473 18.6369L17.9973 18.7169C18.4562 18.9816 19.0014 19.0534 19.5133 18.9166C20.0251 18.7797 20.4617 18.4453 20.7273 17.9869L20.9473 17.5969C21.212 17.1379 21.2838 16.5927 21.147 16.0809C21.0101 15.569 20.6757 15.1324 20.2173 14.8669L20.0673 14.7869C19.7621 14.6107 19.5088 14.3569 19.3332 14.0514C19.1576 13.7458 19.0659 13.3993 19.0673 13.0469V12.5469C19.0659 12.1945 19.1576 11.8479 19.3332 11.5424C19.5088 11.2368 19.7621 10.9831 20.0673 10.8069L20.2173 10.7169C20.6757 10.4513 21.0101 10.0147 21.147 9.50287C21.2838 8.99104 21.212 8.44581 20.9473 7.98688L20.7273 7.60687C20.4617 7.14841 20.0251 6.81405 19.5133 6.67718C19.0014 6.54032 18.4562 6.61214 17.9973 6.87687L17.8473 6.95687C17.5432 7.13241 17.1983 7.22482 16.8473 7.22482C16.4962 7.22482 16.1513 7.13241 15.8473 6.95687L15.4173 6.70687C15.1135 6.53151 14.8612 6.27936 14.6857 5.97571C14.5102 5.67206 14.4176 5.3276 14.4173 4.97687V4.79688C14.4173 4.26644 14.2066 3.75773 13.8315 3.38266C13.4564 3.00759 12.9477 2.79688 12.4173 2.79688Z"
                                stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12.1992 15.7969C13.8561 15.7969 15.1992 14.4537 15.1992 12.7969C15.1992 11.14 13.8561 9.79688 12.1992 9.79688C10.5424 9.79688 9.19922 11.14 9.19922 12.7969C9.19922 14.4537 10.5424 15.7969 12.1992 15.7969Z"
                                stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <div class="text">
                        <span>تقييم المنصة والخدمة</span>
                        <p>تقييم تجربة استخدام المنصة وجودة الخدمة</p>
                    </div>
                </div>
                <div class="box-rate">
                    <p>التقييم (من 1 إلى 5 نجوم)</p>
                    <div class="rating">
                        <i class="fa-solid fa-star" data-value="1"></i>
                        <i class="fa-solid fa-star" data-value="2"></i>
                        <i class="fa-solid fa-star" data-value="3"></i>
                        <i class="fa-solid fa-star" data-value="4"></i>
                        <i class="fa-solid fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="platform_rating" class="ratingValue" value="0">
                </div>
                <div class="notes">
                    <p>ملاحظات وتعليقات (اختياري)</p>
                    <textarea name="platform_comment" id="" placeholder="أضف ملاحظاتك حول تقييم المنصة والخدمة..."></textarea>
                </div>
            </div>

            <div class="general-notes">
                <p>ملاحظات عامة</p>
                <textarea name="general_notes" id="" placeholder="أضف أي ملاحظات أو اقتراحات إضافية لتحسين الخدمة..."></textarea>

            </div>

            <div class="send-file">
                <div class="mine-box">
                    <p>سيتم استخدام تقييمك لتحسين جودة الخدمة وتطوير المنصة</p>
                    <button class="main_btn_bg" type="submit">إرسال التقييم
                        <svg width="29" height="20" viewBox="0 0 29 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2136_16119)">
                                <path
                                    d="M19.1354 1.66406L13.3021 18.3307L9.96875 10.8307L2.46875 7.4974L19.1354 1.66406Z"
                                    stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M19.1354 1.66406L9.96875 10.8307" stroke="white" stroke-width="1.66667"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2136_16119">
                                    <rect width="20" height="20" fill="white" transform="translate(0.800781)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>
        </form>


    </section>



@endsection
@push('scripts')
    <script src="/assets/js/customer/feedback.js"></script>
    
@endpush
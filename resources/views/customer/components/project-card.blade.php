@php
    $overallProgress = 0;

    if ($project->status === App\Enums\ProjectStatus::IN_PROGRESS->value) {
        $offer = $project->acceptedOffer();

        if ($offer) {
            $itemsQuery = $offer->itemsWithSelectedServices();

            $totalProgress = $itemsQuery->sum('progress');
            $itemCount = $itemsQuery->count();

            $overallProgress = $itemCount > 0 ? round($totalProgress / $itemCount, 2) : 0;
        }
    }
@endphp

            <div class="project_user">
                <div class="status">
                    <span class="{{ $project->status }}">{{\App\Enums\ProjectStatus::getLabel($project->status) }}</span>
                </div>
                <h2 class="type">{{ $project->serviceType?->name }} {{ $project->buildingType?->name }}</h2>
                <p class="reference_number">{{ $project->reference_number }}</p>
                <p class="description">{{$project->work_description}}</p>
                <div class="categotes">
                    <div>
                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.66797 5.16797H4.6738M1.16797 3.53463L1.16797 6.14477C1.16797 6.43012 1.16797 6.5728 1.2002 6.70707C1.22878 6.82611 1.27592 6.93992 1.33989 7.0443C1.41204 7.16204 1.51293 7.26292 1.7147 7.4647L6.18807 11.9381C6.8811 12.6311 7.22761 12.9776 7.62719 13.1074C7.97866 13.2216 8.35727 13.2216 8.70875 13.1074C9.10832 12.9776 9.45484 12.6311 10.1479 11.9381L11.4381 10.6479C12.1311 9.95484 12.4776 9.60832 12.6074 9.20875C12.7216 8.85727 12.7216 8.47866 12.6074 8.12719C12.4776 7.72761 12.1311 7.3811 11.4381 6.68807L6.9647 2.2147C6.76292 2.01293 6.66204 1.91204 6.5443 1.83989C6.43992 1.77592 6.32611 1.72878 6.20707 1.7002C6.0728 1.66797 5.93012 1.66797 5.64477 1.66797L3.03464 1.66797C2.38124 1.66797 2.05454 1.66797 1.80498 1.79513C1.58546 1.90698 1.40698 2.08546 1.29513 2.30498C1.16797 2.55454 1.16797 2.88124 1.16797 3.53463ZM4.95964 5.16797C4.95964 5.32905 4.82905 5.45964 4.66797 5.45964C4.50689 5.45964 4.3763 5.32905 4.3763 5.16797C4.3763 5.00689 4.50689 4.8763 4.66797 4.8763C4.82905 4.8763 4.95964 5.00689 4.95964 5.16797Z"
                                stroke="#616171" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> 
                        <span>{{ $project->ServiceType?->name }}</span>
                    </div>
                    <div>
                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.66797 5.16797H4.6738M1.16797 3.53463L1.16797 6.14477C1.16797 6.43012 1.16797 6.5728 1.2002 6.70707C1.22878 6.82611 1.27592 6.93992 1.33989 7.0443C1.41204 7.16204 1.51293 7.26292 1.7147 7.4647L6.18807 11.9381C6.8811 12.6311 7.22761 12.9776 7.62719 13.1074C7.97866 13.2216 8.35727 13.2216 8.70875 13.1074C9.10832 12.9776 9.45484 12.6311 10.1479 11.9381L11.4381 10.6479C12.1311 9.95484 12.4776 9.60832 12.6074 9.20875C12.7216 8.85727 12.7216 8.47866 12.6074 8.12719C12.4776 7.72761 12.1311 7.3811 11.4381 6.68807L6.9647 2.2147C6.76292 2.01293 6.66204 1.91204 6.5443 1.83989C6.43992 1.77592 6.32611 1.72878 6.20707 1.7002C6.0728 1.66797 5.93012 1.66797 5.64477 1.66797L3.03464 1.66797C2.38124 1.66797 2.05454 1.66797 1.80498 1.79513C1.58546 1.90698 1.40698 2.08546 1.29513 2.30498C1.16797 2.55454 1.16797 2.88124 1.16797 3.53463ZM4.95964 5.16797C4.95964 5.32905 4.82905 5.45964 4.66797 5.45964C4.50689 5.45964 4.3763 5.32905 4.3763 5.16797C4.3763 5.00689 4.50689 4.8763 4.66797 4.8763C4.82905 4.8763 4.95964 5.00689 4.95964 5.16797Z"
                                stroke="#616171" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>{{ $project->category?->name }}</span>
                    </div>
                </div>
                
                @if(\App\Enums\ProjectStatus::getStatusOrder($project->status) == 6)
                <div class="progress_Rate">
                    <div class="text">
                        <span>نسبة الإنجاز</span>
                        <p>{{$overallProgress}}%</p>
                    </div>
                    <div class="progress">
                        <div class="count" style="width: {{$overallProgress}}%;"></div>
                    </div>
                </div>
                @endif
                <div class="info">
                    <div class="provider">
                        <i class="fa-solid fa-globe"></i>
                        <span>المقاول : </span>
                        <p>{{ $project->acceptedOffer()?->provider?->company_name }}</p>
                    </div>
                    <div class="start">
                        <i class="fa-regular fa-calendar"></i>
                        <span>البدء : </span>
                        <p> {{ \Carbon\Carbon::parse($project->start_date)->locale('ar')->translatedFormat('l j F Y') }} - {{ \Carbon\Carbon::parse($project->start_date)->addMonths($project->duration)->locale('ar')->translatedFormat('l j F Y') }} </p>
                    </div>
                    <div class="pudget">
                       <i class="fa-solid fa-dollar-sign"></i>
                        <p>{{ number_format($project->budget, 0, ',', '.') }}</p>
                        <span> ريال</span>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>{{ $project->city?->name }} - {{$project->region?->name }}</span>
                    </div>
                </div>
                <div class="last">
                    <div class="buttons">
                        <a href="{{ route('customer.project.implementation.index' , $project->id) }}" class="main_btn_bg order_status {{ $project->status == \App\Enums\ProjectStatus::IN_PROGRESS->value ? "" : "d-none" }} ">متابعة حالة الطلب</a>
                        <a href="{{ route('customer.project.show' , $project->id) }}" class="main_btn_bg show_details {{  \App\Enums\ProjectStatus::getStatusOrder($project->status) >=6 ? 'd-none' : '' }} ">عرض التفاصيل</a>
                        <a href="{{ route('customer.project.show.compeleted' , $project->id) }}" class="main_btn_bg show_details {{   $project->status == \App\Enums\ProjectStatus::COMPLETED->value ? "" : "d-none"  }} ">عرض التفاصيل</a>
                   

                        <a href="{{ route('customer.offer.index' , $project->id) }}" class="main_btn_bg  
                        @if($project->status == \App\Enums\ProjectStatus::OPEN_FOR_OFFERS->value && count($project->approvedOffers) !=0)
                        ''
                        @else
                        d-none
                        @endif
                        ">عرض العروض</a>
                        <a href="#" class="main_btn_bg update d-none">تعديل</a>
                        <a href="#" class="main_btn_bg  project_rating d-none">
                            <span>تقييم المشروع</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2116_9150)">
                                    <path
                                        d="M7.9987 1.33203L10.0587 5.50536L14.6654 6.1787L11.332 9.42537L12.1187 14.012L7.9987 11.8454L3.8787 14.012L4.66536 9.42537L1.33203 6.1787L5.9387 5.50536L7.9987 1.33203Z"
                                        stroke="#047857" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_2116_9150">
                                        <rect width="16" height="16" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                    <div class="offers d-none">
                        <span>{{ count($project->approvedOffers) }}</span>
                        <p> عرض مقدم</p>
                    </div>
                </div>
            </div>
      

@extends('provider.layouts.main')

@section('title')
    عروضي المقدمة
@endsection


@section('content')
    <div class="myOffers" id="main_page" >

        <div class="head">
            <h1>عروضي المقدمة</h1>
            <p>تابع جميع عروضك المقدمة في مكان واحد!</p>
        </div>

   <div class="search">
    <form method="GET" action="{{ route('provider.offers.index') }}" class="projects-filter-form">
        <!-- Search Input -->
        <div class="input_group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" id="project-search"
                   placeholder="البحث في العروض..."
                   value="{{ request('search') }}" />
        </div>

        <!-- Filters -->
        <div class="filter_buttons">
            <button type="submit" name="status" value="all"
                class="{{ request('status', 'all') == 'all' ? 'active' : '' }}">
                الكل ({{ $allCounts['all'] }})
            </button>

            <button type="submit" name="status" value="pending"
                class="{{ request('status') == 'pending' ? 'active' : '' }}">
                قيد المراجعة ({{ $allCounts['pending'] }})
            </button>

            <button type="submit" name="status" value="approved"
                class="{{ request('status') == 'approved' ? 'active' : '' }}">
                معتمد ({{ $allCounts['approved'] }})
            </button>


            <button type="submit" name="status" value="accepted"
                class="{{ request('status') == 'accepted' ? 'active' : '' }}">
                مقبول ({{ $allCounts['accepted'] }})
            </button>
            <button type="submit" name="status" value="require_update"
                class="{{ request('status') == 'require_update' ? 'active' : '' }}">
                يحتاج تعديل ({{ $allCounts['require_update'] }})
            </button>

            <button type="submit" name="status" value="declined"
                class="{{ request('status') == 'declined' ? 'active' : '' }}">
                مرفوض ({{ $allCounts['declined'] }})
            </button>
        </div>
    </form>
</div>

        <div class="projects" style="direction:rtl">
            <div class="row">
                @foreach ($offers as $offer)
                    <div class="col-md-6 col-lg-4 mb-3">
                        @include('provider.components.offer-card')
                    </div>
                @endforeach


            </div>
        </div>

    </div>

@endsection
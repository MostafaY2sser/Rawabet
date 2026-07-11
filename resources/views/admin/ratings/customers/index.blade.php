@extends('admin.layouts.main')
@section('title')
    تقييمات المزودين
@endsection
@section('content')
    <section class="payments" id="main_page">

        <div class="payment-management">
            <div class="payment-management-header">

                <h4>تقييمات العملاء</h4>
            
            </div>
        </div>

        <div class="bills ">
            <div class="head">
                <div class="text">
                    <h6>التقييمات</h6>
                </div>
                {{-- <form action="" method="POST">
                    <div class="input_group">
                        <input type="search" name="search" id="search" placeholder="البحث">
                        <i class="fa-solid fa-magnifying-glass search_icon"></i>
                    </div>
                    <div class="input_group">
                        <select name="filter" id="filter">
                            <option value="1" disabled selected>الكل</option>
                            <option value="2">one</option>
                            <option value="3">two</option>
                        </select>
                    </div>
                </form> --}}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>اسم العميل</th>
                        
                        <th>المشروع</th>
                        <th>التقييم </th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                        <tr>
                            <td class="head_row">{{ $rating->customer()->full_name }}</td>
                            {{-- Assuming relationships exist for project and stage --}}
                            <td>{{ $rating->project->reference_number }}</td>
                            <td>{{ $rating->customer_rating }}</td>
                     

                            <td>
                                @can('view projects.pending')
                                 <a href="{{ route('admin.ratings.customers.show' , $rating->id) }}">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{-- {{ $projecg->links() }} --}}
            </div>
        </div>
    </section>
@endsection

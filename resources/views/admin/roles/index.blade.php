@extends('admin.layouts.main')
@section('title')
    المصتخدمين
@endsection
@section('content')
    <section class="payments" id="main_page">

        <div class="payment-management">
            <div class="payment-management-header">


                <form action="" method="GET">
                    <div class="head">
                        <h4>إدارة الادوار</h4>
                        <div class="left">
                            <div class="input_group">
                                <input type="search" name="search" id="search" placeholder="البحث ..."
                                    value="{{ request('search') }}">
                                <i class="fa-solid fa-magnifying-glass search_icon"></i>
                            </div>
                            <button type="submit" class="main_btn_bg">تصدير التقرير</button>
                        </div>
                    </div>
                    <div class="buttons">
                        <a href="#" class="btn">الكل({{ count($roles) }})</a>

                    </div>
                </form>
            </div>
        </div>

        <div class="bills ">

            <table>
                <thead>
                    <tr>
                        <th>#</th>

                        <th>الاسم </th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $role->name}}</td>
                            <td>
                                @can('edit roles')
                                    
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="action_btn">
                                    <i class="fa-regular fa-pen-to-square"></i>
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

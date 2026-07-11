@extends('admin.layouts.main')
@section('title')
    المستخدمين
@endsection
@section('content')
    <section class="payments" id="main_page">
                     
        @can('create users')
            
        <a href="{{ route('admin.users.create') }}" type="submit" class="main_btn_bg my-4" style="width: fit-content">إضافة مستخدم</a>
        @endcan
        

        <div class="bills ">
            {{-- <div class="head">
                <div class="text">
                    <h6></h6>
                </div>
             
            </div> --}}

            <table>
                <thead>
                    <tr>
                        <th>الاسم </th>
                        <th>البريد</th>
                        <th>الدور</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->full_name}}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->role()->name}}</td>
                            <td>
                                @can('edit users')
                                    
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="action_btn">
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

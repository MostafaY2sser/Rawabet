@extends('admin.layouts.main')

@section('title')
تعديل
@endsection


@section('content')
    <div class="submit_offer" id="main_page">



        <form id="offerForm" method="POST" action="{{ route('admin.users.update' , $user->id) }}" enctype="multipart/form-data">
@method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            <!-- Stepper -->


            <div class="input_group">
                <label for="full_name">الاسم كامل*</label>
                <input type="text" value="{{ $user->full_name }}" name="full_name" id="full_name" placeholder="الاسم كامل"
                    required>
            </div>

            <div class="input_group">
                <label for="email">البريد الإلكتروني*</label>
                <input type="email" value="{{ $user->email }}" name="email" id="email"
                    placeholder="example@mail.com" required>
            </div>
            <div class="input_group">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" id="password" placeholder="اذا لم ترغب ف التحديث اتركها  فارغه " >
            </div>
            <div class="input_group">
                <label for="confirm_password">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="confirm_password" placeholder="تأكيد كلمة المرور"
                    >
            </div>
            <div class="input_group">
                <label for="role">الدور</label>
                <select name="role_id" id="role_select">
                    <option value="">-</option>
                    @foreach ($roles as $role)

                        <option @selected($user->role()->id == $role->id) value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="input_group" id="consultant_extra" style="display: {{ $user->role()->id  == 1 ? 'block' : 'none' }};">

                <div class="input_group">
                    <label for="">تخصص المستشار</label>
                    <select name="specialty_id" id="" class="form-control">
                        @foreach ($specailites as $item)
                            <option @selected($user->consultant?->specialty_id == $item?->id) value={{ $item->id }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input_group">
                    <label for="">الهاتف</label>
                    <input type="text" value="{{ $user->consultant?->phone_number }}" name="phone_number" id="" >
                </div>
                <div class="input_group">
                     <label for="">رقم الهوية</label>
                    <input type="text" value="{{ $user->consultant?->identity_number }}" name="identity_number" id="" >
                </div>
                <div class="input_group">
                    <label for="">سنوات الخبرة</label>
                    <input value="{{ $user->consultant?->experience_years }}" type="text" name="experience_years" id="" >
                </div>
                <div class="input_group">
                    <label for="">الشهادات</label>
                    <textarea name="certificates" id="" cols="30" rows="10">
                    {{ $user->consultant?->certificates }}
                    </textarea>
                </div>
                <div class="input_group">
                    <label for="">الصورة</label>
                    <input type="file" name="avatar" id="" >
                </div>
            
                <div>
                    <img src="{{ Storage::url($user->consultant?->avatar) }}" width="100" height="100" alt="">
                </div>
            </div>



            <button class="main_btn_bg" type="submit">حفط</button>


        </form>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_select');
            const consultantExtra = document.getElementById('consultant_extra');

            roleSelect.addEventListener('change', function() {
                if (this.value == '1') { // Change '1' to your consultant role ID
                    consultantExtra.style.display = 'block';
                } else {
                    consultantExtra.style.display = 'none';
                }
            });
        });
    </script>
@endpush

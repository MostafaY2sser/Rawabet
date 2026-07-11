@extends('admin.layouts.main')

@section('title')
    الادوار
@endsection

<style>
    .submit_offer input[type="checkbox"] {
        width: 25px  !important;
        height: 25px !important;
    }
</style>

@section('content')
    <div class="submit_offer" id="main_page">



        <form id="offerForm" method="POST" action="{{ route('admin.roles.update', $role->id) }}">
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf

            <div class="">
                <div class="mb-3">
                    <div class="input_group">
                        <label for="">الاسم</label>
                        <input type="text" value="{{ $role->name }}" name="name">
                    </div>
                </div>
                @foreach ($permissions as $module => $modulePermissions)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-capitalize">{{ str_replace('_', ' ', $module) }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($modulePermissions as $permission)
                                    <div class="col-md-4  ">
                                        {{-- <div class="form-check"> --}}
                                        <div class="d-flex gap-2 mb-3">
                                            <input {{-- class="form-check-input" --}} class="" type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}" id="perm_{{ Str::slug($permission->name) }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            {{-- <label class="form-check-label" for="perm_{{ Str::slug($permission->name) }}"> --}}
                                            <label class="" for="perm_{{ Str::slug($permission->name) }}">
                                                {{ ucfirst(str_replace(['.', '_'], ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>




            <div class="buttons">
                <button type="submit" class="submit-btn main_btn_bg" name="action" value="submit">إرسال </button>
                {{-- <button type="submit" class="main_btn_bg save" name="action" value="draft">حفظ كمسودة</button> --}}
                <button type="button" class="main_btn_bg cancel"
                    onclick="window.location.href='{{ route('admin.roles.index') }}'">إلغاء</button>
            </div>
        </form>

    </div>
@endsection

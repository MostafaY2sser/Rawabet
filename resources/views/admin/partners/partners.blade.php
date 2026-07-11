@extends('admin.layouts.main')

@section('content')
    <div class="project_details " id="main_page">

        <div class="about_project">


            <div class="container mt-4 complaints">

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-4">الشركاء</h4>

                    @can('create partners')
                        <button class="main_btn_bg mb-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                            <i class="fa-solid fa-plus"></i> إضافة
                        </button>
                    @endcan
                </div>

                <section class="payments mt-4" style="margin: 0;">
                     @if($errors->any())
                        <div  class="input_error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="bills">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الالكتروني</th>
                                    <th>الهاتف</th>
                                    <th>الشعار</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody id="ticketsTable">
                                @foreach ($partners as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone_number }}</td>

                                        <td><img src="{{ Storage::url($item->logo) }}" width="80" height="80"
                                                alt=""></td>


                                        <td>
                                            @can('edit partners')
                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-outline-primary edit-region-btn"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                    data-name="{{ $item->status }}" data-email="{{ $item->email }}"
                                                    data-phone="{{ $item->phone_number }}"
                                                    data-route="{{ route('admin.partners.partners.update', $item->id) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editRegionModal" type="button">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endcan
                                        </td>
                                        <!-- Edit Region Modal -->


                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </section>


            </div>


            <div class="modal fade" id="addComplaintModal" tabindex="-1" aria-labelledby="addComplaintLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.partners.partners.store') }}" class="modal-content" id="complaintForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addComplaintLabel">إضافة </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="name" class="form-label">الاسم</label>
                                <input id="name" name="name" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input id="email" name="email" type="email" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="phone_number" class="form-label">الهاتف</label>
                                <input id="phone_number" name="phone_number" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="logo" class="form-label">الشعار</label>
                                <input id="logo" name="logo" class="form-control" type="file"
                                    required></textarea>
                            </div>
                        </div>


                        <div class="modal-footer d-flex align-items-center justify-content-between">
                            <button type="submit" class="main_btn_bg">إرسال</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Shared Edit Modal -->
            <div class="modal fade" id="editRegionModal" tabindex="-1" aria-labelledby="editRegionLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form enctype="multipart/form-data" method="POST" id="editRegionForm" class="modal-content">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editRegionLabel">تعديل المنطقة</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input_group">
                                <label for="edit_region_name" class="form-label">الاسم</label>
                                <input type="text" id="edit_region_name" name="name" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input id="edit_email" name="email" type="email" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="phone_number" class="form-label">الهاتف</label>
                                <input id="edit_phone_number" name="phone_number" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="logo" class="form-label">الشعار</label>
                                <input id="logo" name="logo" class="form-control" type="file"></textarea>
                            </div>
                        </div>


                        <div class="modal-footer d-flex align-items-center justify-content-between">
                            <button type="submit" class="main_btn_bg">تحديث</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script src="/assets/js/admin/complaints.js"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-region-btn');
            const form = document.getElementById('editRegionForm');
            const nameInput = document.getElementById('edit_region_name');
            const phoneInput = document.getElementById('edit_phone_number');
            const emailInput = document.getElementById('edit_email');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.dataset.name;
                    const phone = this.dataset.phone;
                    const email = this.dataset.email;
                    const route = this.dataset.route;

                    console.log(this.dataset.phone)
                    nameInput.value = name;
                    emailInput.value = email;
                    phoneInput.value = phone;
                    form.action = route;
                });
            });
        });
    </script>
@endpush

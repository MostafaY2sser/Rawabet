@extends('admin.layouts.main')

@section('content')
    <div class="project_details " id="main_page">

        <div class="about_project">


            <div class="container mt-4 complaints">

                <div class="d-flex align-items-center justify-content-between">

                    <h4 class="mb-4">الاقسام</h4>

                    <button class="main_btn_bg mb-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                        <i class="fa-solid fa-plus"></i> إضافة
                    </button>
                </div>

                <section class="payments mt-4"  style="margin: 0;">
                    <div class="bills">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>

                                
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody id="ticketsTable">
                                @foreach ($sections as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
         

                                        <td>
                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-outline-primary edit-region-btn"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-route="{{ route('admin.partners.sections.update', $item->id) }}"
                                                data-bs-toggle="modal" data-bs-target="#editRegionModal" type="button">
                                                <i class="fa fa-edit"></i>
                                            </button>

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
                    <form method="POST" action="{{ route('admin.partners.sections.store') }}" class="modal-content"
                        id="complaintForm">
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
                    <form method="POST" id="editRegionForm" class="modal-content">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editRegionLabel">تعديل المنطقة</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input_group">
                                <label for="edit_region_name" class="form-label">الاسم</label>
                                <input type="text" id="edit_region_name" name="name" class="form-control" required>
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

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.dataset.name;
                    const status = this.dataset.status;
                    const route = this.dataset.route;

                    nameInput.value = name;
                    form.action = route;
                });
            });
        });
    </script>
@endpush

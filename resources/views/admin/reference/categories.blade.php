@extends('admin.layouts.main')

@section('content')
    <div class="project_details" id="main_page">
        <div class="about_project">
            <div class="container mt-4 complaints">

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-4">الأقسام</h4>
                    @can('create resources')
                        <button class="main_btn_bg mb-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                            <i class="fa-solid fa-plus"></i> إضافة
                        </button>
                    @endcan
                </div>

                <section class="payments"  style="margin: 0; ">
                    <div class="bills">
                        <table id="categoriesTable" class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الحالة</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </section>

            </div>

            {{-- Add & Edit Modals نفس اللي عندك --}}
    <div class="modal fade" id="addComplaintModal" tabindex="-1" aria-labelledby="addComplaintLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.reference.categories.store') }}" class="modal-content"
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
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="status" class="form-label">الحاله</label>
                                <select name="status" id="" class="form-control">
                                    <option value="1" selected>نشط</option>
                                    <option value="0">غير نشط</option>
                                </select>
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
                            <h5 class="modal-title" id="editRegionLabel">تعديل </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input_group">
                                <label for="edit_region_name" class="form-label">الاسم</label>
                                <input type="text" id="edit_region_name" name="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="input_group">
                                <label for="edit_region_status" class="form-label">الحالة</label>
                                <select name="status" id="edit_region_status" class="form-control">
                                    <option value="1">نشط</option>
                                    <option value="0">غير نشط</option>
                                </select>
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
   <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.reference.categories.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json"
        }
    });

    // fill edit modal
    $(document).on('click', '.edit-region-btn', function() {
        let name = $(this).data('name');
        let status = $(this).data('status');
        let route = $(this).data('route');

        $('#edit_region_name').val(name);
        $('#edit_region_status').val(status);
        $('#editRegionForm').attr('action', route);
    });
});
</script>
@endpush

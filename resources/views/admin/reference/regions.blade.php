@extends('admin.layouts.main')

@section('content')
    <div class="project_details"  id="main_page" >

        <div class="about_project">


            <div class="container mt-4 complaints">

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-4 ">المناطق</h4>

                    @can('create resources')
                        <button class="main_btn_bg mb-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                            <i class="fa-solid fa-plus"></i> إضافة
                        </button>
                    @endcan
                </div>

                <section class="payments mt-2" style="margin: 0;">
                    <div class="bills">
                       <table id="regions-table" class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الحالة</th>
                                    <th>المدن</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </section>


            </div>


            <div class="modal fade" id="addComplaintModal" tabindex="-1" aria-labelledby="addComplaintLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.reference.regions.store') }}" class="modal-content"
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
                            <h5 class="modal-title" id="editRegionLabel">تعديل المنطقة</h5>
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

    {{-- <script src="/assets/js/admin/complaints.js"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-region-btn');
            const form = document.getElementById('editRegionForm');
            const nameInput = document.getElementById('edit_region_name');
            const statusSelect = document.getElementById('edit_region_status');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.dataset.name;
                    const status = this.dataset.status;
                    const route = this.dataset.route;

                    nameInput.value = name;
                    statusSelect.value = status;
                    form.action = route;
                });
            });
        });
    </script>
 
<script>
$(function () {
    let table = $('#regions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.reference.regions.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'cities', name: 'cities', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
        }
    });

    // Re-bind edit modal button
    $('#regions-table').on('click', '.edit-region-btn', function() {
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

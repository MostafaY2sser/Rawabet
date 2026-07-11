@extends('admin.layouts.main')

@section('content')
    <div class="project_details" id="main_page">
        <div class="about_project">
            <div class="container mt-4 complaints">

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-4">أنواع المشاريع</h4>
                    @can('create resources')
                        <button class="main_btn_bg mb-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                            <i class="fa-solid fa-plus"></i> إضافة
                        </button>
                    @endcan
                </div>

                <section class="payments" style="margin: 0;">
                    <div class="bills">
                        <table id="projectTypesTable" class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الوصف</th>
                                    <th>الحالة</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addComplaintModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.reference.project-types.store') }}" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة نوع مشروع</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input_group">
                                <label class="form-label">الاسم</label>
                                <input name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group">
                                <label class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-control">
                                    <option value="1" selected>نشط</option>
                                    <option value="0">غير نشط</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="main_btn_bg">إرسال</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editRegionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" id="editRegionForm" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">تعديل نوع مشروع</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input_group">
                                <label class="form-label">الاسم</label>
                                <input type="text" id="edit_region_name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group">
                                <label class="form-label">الوصف</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group">
                                <label class="form-label">الحالة</label>
                                <select name="status" id="edit_region_status" class="form-control">
                                    <option value="1">نشط</option>
                                    <option value="0">غير نشط</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function() {
            let table = $('#projectTypesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.reference.project-types.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json"
                }
            });

            // Edit modal setup
            $(document).on('click', '.edit-region-btn', function() {
                $('#edit_region_name').val($(this).data('name'));
                $('#edit_description').val($(this).data('description'));
                $('#edit_region_status').val($(this).data('status'));
                $('#editRegionForm').attr('action', $(this).data('route'));
            });
        });
    </script>
@endpush

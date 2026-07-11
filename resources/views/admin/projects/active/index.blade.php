@extends('admin.layouts.main')
@section('title', 'المشاريع النشطة')

@section('content')
    <section class="payments" id="main_page">
        <div class="payment-management">
            <div class="payment-management-header">
                <div class="head">
                    <h4>إدارة المشاريع النشطة</h4>
                </div>
            </div>
        </div>

        <div class="bills">
            <div class="head mb-3">
                <div class="text">
                    <h6></h6>
                </div>
                <div class="filter">
                    <label for="status-filter">تصفية حسب الحالة:</label>
                    <select id="status-filter" class="form-select">
                        <option value="">الكل</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}">
                                {{ \App\Enums\ProjectStatus::getLabel($status->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table id="projects-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>اسم العميل</th>
                        <th>الرقم التعريفي</th>

                        <th>نوع المشروع</th>
                        <th>التصنيف</th>
                        <th>المنطقة</th>
                        <th>الميزانية</th>
                        <th>الحالة</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            let table = $('#projects-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.projects.active.index') }}',
                    data: function(d) {
                        d.status = $('#status-filter').val();
                    }
                },
                columns: [{
                        data: 'customer_name',
                        name: 'customer.full_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'reference_number',
                        name: 'reference_number'
                    },
                    {
                        data: 'project_type',
                        name: 'projectType.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        name: 'category.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'region',
                        name: 'region.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'budget',
                        name: 'budget'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
                }
            });

            $('#status-filter').change(function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush

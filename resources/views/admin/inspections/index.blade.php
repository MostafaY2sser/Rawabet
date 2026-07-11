
@extends('admin.layouts.main')
@section('title', 'المعاينات')

@section('content')
    <section class="payments" id="main_page">
        <div class="payment-management">
            <div class="payment-management-header">
                <div class="head">
                    <h4>إدارة المعاينات</h4>
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
                        @foreach (\App\Enums\InspectionStatus::cases()  as $status)
                            <option value="{{ $status->value }}">
                                {{ \App\Enums\InspectionStatus::getLabel($status->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table id="projects-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>المشروع</th>
                        <th>الرقم التعريفي</th>
                        <th>العميل</th>
                        <th>التاريخ</th>
                        <th>التوقيت</th>
                        <th>الحاله</th>
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
                    url: '{{ route('admin.inspection.index') }}',
                    data: function(d) {
                        d.status = $('#status-filter').val();
                    }
                },
                columns: [{
                        data: 'project_title',
                        name: 'project_title',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (data && data.includes('#')) {
                                return data.replace('#', '  -  #'); 
                            }
                            return data;
                        }
                    },
                    {
                        data: 'reference_number',
                        name: 'reference_number'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'time',
                        name: 'time'
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

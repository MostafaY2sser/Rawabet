@extends('admin.layouts.main')
@section('title', 'العروض المسودة')

@section('content')
    <section class="payments" id="main_page">
        <div class="payment-management">
            <div class="payment-management-header">
                <div class="head">
                    <h4>إدارة العروض المسودة</h4>
                </div>
            </div>
        </div>

        <div class="bills">
            <table id="offers-drafted-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>اسم المقاول</th>
                        <th>نوع المشروع</th>
                        <th>كود المشروع</th>
                        <th>التصنيف</th>
                        <th>المنطقة</th>
                        <th>الميزانية</th>
                        <th>تاريخ البدء المتوقع</th>
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
            $('#offers-drafted-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.offers.drafted.index') }}',
                columns: [{
                        data: 'provider_name',
                        name: 'provider_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'project_type',
                        name: 'project_type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'reference_number',
                        name: 'reference_number',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        name: 'category',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'region',
                        name: 'region',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
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
        });
    </script>
@endpush

@extends('admin.layouts.main')
@section('title')
    قائمه العملاء
@endsection
@section('content')
<section class="payments" id="main_page">
    <div class="payment-management">
        <div class="payment-management-header">
            <div class="head">
                <h4>قائمة العملاء</h4>
            </div>
        </div>
    </div>

    <div class="bills">
        <div class="head">
            <div class="text">
            </div>
        </div>

        <table id="requests-table" class="table ">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الالكتروني</th>
                    <th>الهاتف</th>
                    <th>الحاله</th>
                    <th>تاريخ التسجيل</th>
                    <th>التعليق</th>
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
$(function () {
    $('#requests-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.customers.index") }}',
        columns: [
            { data: 'full_name', name: 'full_name' },
            { data: 'email', name: 'email' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'admin_comment', name: 'admin_comment' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
        }
    });
});
</script>
@endpush




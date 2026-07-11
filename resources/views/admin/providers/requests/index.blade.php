@extends('admin.layouts.main')
@section('title', 'الطلبات')

@section('content')
    <section class="payments"  id="main_page">
      
        <div class="payment-management">
            <div class="payment-management-header">
             

                <form action="" method="GET">
                    <div class="head">
                        <h4>إدارة الطلبات</h4>
                      
                    </div>
                    <div class="buttons">
                        {{-- <a href="#" class="btn">الكل({{ count($requests) }})</a> --}}
                       
                    </div>
                </form>
            </div>
        </div>

        <div class="bills ">
            <div class="head">
                {{-- <h4>اداره مزودي الخدمه</h4> --}}
            </div>
        </div>
    </div>

    <div class="bills">
        <div class="head">
            <div class="text">
                <h6>قائمة مزودو الخدمات</h6>
            </div>
        </div>

        <table id="providers-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الالكتروني</th>
                    <th>الهاتف</th>
                    <th>الحاله</th>
                    <th>تاريخ التسجيل</th>
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
$(document).ready(function() {
    $('#providers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.providers.requests.index") }}',
        columns: [
            { data: 'company_name', name: 'company_name' },
            { data: 'email', name: 'email' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },

            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
        }
    });
});
</script>
@endpush

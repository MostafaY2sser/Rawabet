@extends('admin.layouts.main')

@section('content')
    <div class="project_details " id="main_page">

        <div class="about_project">


            <div class="container mt-4 complaints">

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-4">العروض</h4>
                    @can('create partnersDiscounts')
                        <button class="main_btn_bg mb-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                            <i class="fa-solid fa-plus"></i> إضافة
                        </button>
                    @endcan
                </div>

                <section class="payments mt-4"  style="margin: 0;">
                    <div class="bills">
                        @if ($errors->any())
                            <div class="input_error">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>القسم</th>
                                    <th>الشركة</th>
                                    <th>السعر</th>
                                    <th>الخصم (%)</th>
                                    <th>مدة التوصيل (يوم)</th>
                                    <th>الصورة</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discounts as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->section->name ?? '-' }}</td>
                                        <td>{{ $item->partner->name ?? '-' }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->discount }}%</td>
                                        <td>{{ $item->shipping_time }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ Storage::url($item->image) }}" width="80" height="80"
                                                    class="rounded" alt="صورة">
                                            @else
                                                <span class="text-muted">لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            @can('edit partnersDiscounts')
                                                <button class="btn btn-sm btn-outline-primary edit-discount-btn"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                    data-section_id="{{ $item->section_id }}"
                                                    data-partner_id="{{ $item->partner_id }}" data-price="{{ $item->price }}"
                                                    data-discount="{{ $item->discount }}"
                                                    data-delivery_duration="{{ $item->shipping_time }}"
                                                    data-image="{{ Storage::url($item->image) }}"
                                                    data-route="{{ route('admin.partners.discounts.update', $item->id) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editDiscountModal">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endcan
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
                        action="{{ route('admin.partners.discounts.store') }}" class="modal-content" id="complaintForm">

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
                                <label for="section_id" class="form-label">القسم</label>
                                <select name="section_id" class="form-control" id="">
                                    @foreach ($sections as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="partner_id" class="form-label">الشركه</label>
                                <select name="partner_id" class="form-control" id="">
                                    @foreach ($partners as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="price" class="form-label">السعر</label>
                                <input id="price" name="price" type="number" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="discount" class="form-label">الخصم</label>
                                <input id="discount" name="discount" type="number" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="delivery_duration" class="form-label">مده التوصيل</label>
                                <input id="delivery_duration" name="delivery_duration" type="number" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="input_group ">
                                <label for="image" class="form-label">الصوره</label>
                                <input id="image" name="image" class="form-control" type="file"
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
            <!-- Edit Discount Modal -->
            <div class="modal fade" id="editDiscountModal" tabindex="-1" aria-labelledby="editDiscountLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form enctype="multipart/form-data" method="POST" id="editDiscountForm" class="modal-content">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editDiscountLabel">تعديل الخصم</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input_group mb-2">
                                <label for="edit_discount_name" class="form-label">الاسم</label>
                                <input type="text" id="edit_discount_name" name="name" class="form-control"
                                    required>
                            </div>

                            <div class="input_group mb-2">
                                <label for="edit_section_id" class="form-label">القسم</label>
                                <select id="edit_section_id" name="section_id" class="form-control" required>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input_group mb-2">
                                <label for="edit_partner_id" class="form-label">الشركة</label>
                                <select id="edit_partner_id" name="partner_id" class="form-control" required>
                                    @foreach ($partners as $partner)
                                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input_group mb-2">
                                <label for="edit_price" class="form-label">السعر</label>
                                <input type="number" id="edit_price" name="price" class="form-control" required>
                            </div>

                            <div class="input_group mb-2">
                                <label for="edit_discount" class="form-label">الخصم (%)</label>
                                <input type="number" id="edit_discount" name="discount" class="form-control" required>
                            </div>

                            <div class="input_group mb-2">
                                <label for="edit_delivery_duration" class="form-label">مدة التوصيل</label>
                                <input type="number" id="edit_delivery_duration" name="shipping_time"
                                    class="form-control" required>
                            </div>

                            <div class="input_group mb-2">
                                <label for="edit_image" class="form-label">الصورة (اختياري)</label>
                                <input type="file" id="edit_image" name="image" class="form-control">
                            </div>

                            <div class="input_group mb-2">
                                <label class="form-label">الصورة الحالية</label>
                                <img id="current_discount_image" src="#" alt="Current Image"
                                    class="img-thumbnail" width="100" height="100">
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class=" main_btn_bg">تحديث</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountButtons = document.querySelectorAll('.edit-discount-btn');
            const form = document.getElementById('editDiscountForm');

            const nameInput = document.getElementById('edit_discount_name');
            const sectionInput = document.getElementById('edit_section_id');
            const partnerInput = document.getElementById('edit_partner_id');
            const priceInput = document.getElementById('edit_price');
            const discountInput = document.getElementById('edit_discount');
            const durationInput = document.getElementById('edit_delivery_duration');
            const currentImage = document.getElementById('current_discount_image');

            discountButtons.forEach(button => {
                button.addEventListener('click', function() {
                    form.action = this.dataset.route;
                    nameInput.value = this.dataset.name;
                    sectionInput.value = this.dataset.section_id;
                    partnerInput.value = this.dataset.partner_id;
                    priceInput.value = this.dataset.price;
                    discountInput.value = this.dataset.discount;
                    durationInput.value = this.dataset.delivery_duration;

                    // Load current image
                    const imageUrl = this.dataset.image;
                    if (imageUrl) {
                        currentImage.src = imageUrl;
                        currentImage.style.display = 'block';
                    } else {
                        currentImage.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush

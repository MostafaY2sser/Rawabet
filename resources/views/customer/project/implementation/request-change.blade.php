@extends('customer.layouts.main')

@section('title')
طلب تغير
@endsection

@section('content')

    <div class="new_change">
        <div class="wrapper">
            <div class="head">
                <h6>طلب تغيير جديد</h6>
                <span><i class="fa-solid fa-xmark"></i></span>
            </div>

            <form action="" method="GET">
                @csrf
                <h4>قم بتعبئة التفاصيل الأساسية لطلب التغيير</h4>
                <div class="input_group my-2 my-md-4">
                    <label for="change_name">عنوان طلب التغيير *</label>
                    <input type="text" name="change_name" id="change_name" placeholder="مثال: إضافة غرفة نوم إضافية">
                </div>
                <div class="input_group my-2 my-md-4">
                    <label for="change_category">عنوان طلب التغيير *</label>
                    <select name="change_category" id="change_category">
                        <option value="" disabled selected hidden>اختر فئة التغيير</option>
                        <option value="1">test</option>
                        <option value="2">test</option>
                        <option value="3">test</option>
                    </select>
                </div>

                <div class="change_type">
                    <label>نوع التغيير *</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="radio" id="change_type1" name="change_type">
                            <label for="change_type1">
                                <span>إضافة</span>
                                <p>إضافة عناصر أو مساحات جديدة</p>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="change_type2" name="change_type">
                            <label for="change_type2">
                                <span>تعديل</span>
                                <p>تغيير في التصميم أو المواصفات</p>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="change_type3" name="change_type">
                            <label for="change_type3">
                                <span>إزالة</span>
                                <p>حذف عناصر من التصميم الأصلي</p>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="change_type4" name="change_type">
                            <label for="change_type4">
                                <span>ترقية</span>
                                <p>تحسين جودة المواد أو التشطيبات</p>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="change_type5" name="change_type">
                            <label for="change_type5">
                                <span>أخرى</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="input_group">
                    <label for="change_descrption">وصف التغيير المطلوب *</label>
                    <textarea name="change_descrption" id="change_descrption" placeholder="اشرح بالتفصيل التغيير المطلوب وكيف تريد تنفيذه..."></textarea>
                </div>

                <div class="change_order">
                    <h4>حدد أولوية التغيير وتأثيره على المشروع</h4>
                    <div class="order_box">
                        <div class="box">
                            <input type="radio" name="change_order" id="low">
                            <label class="low" for="low">منخفض</label>
                        </div>
                        <div class="box">
                            <input type="radio" name="change_order" id="average">
                            <label class="average" for="average">متوسط</label>
                        </div>
                        <div class="box">
                            <input type="radio" name="change_order" id="high">
                            <label class="high" for="high">عالي</label>
                        </div>
                    </div>
                </div>

                <div class="input_group">
                    <label for="change_reason">سبب طلب التغيير *</label>
                    <textarea name="change_reason" id="change_reason" placeholder="اشرح الأسباب التي دفعتك لطلب هذا التغيير..."></textarea>
                </div>

                <div class="input_group my-3">
                    <label for="expected_benefit">الفائدة المتوقعة</label>
                    <textarea name="expected_benefit" id="expected_benefit" placeholder="ما هي الفوائد المتوقعة من هذا التغيير؟"></textarea>
                </div>

                <div class="attachments my-4">
                    <h4>المرفقات</h4>
                    <div class="input_group">
                        <label for="">أرفق الصور أو المستندات التي توضح التغيير المطلوب</label>
                        <div class="upload_documents">
                            <label class="upload_documents_box" for="title_deed">
                                <div class="icon">                              
                                    <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>  
                                </div>
                                <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                <input type="file" name="title_deed" id="title_deed" accept=".jpg,.jpeg,.png" multiple hidden>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="buttons">
                    <div>
                        <button type="submit" class="main_btn_bg">إرسال طلب التغيير</button>
                        <a href="#" class="main_btn_bg">إلغاء</a>
                    </div>
                    <p>سيتم مراجعة طلبك والرد عليك خلال 48 ساعة</p>
                </div>


            </form>

        </div>
    </div>


    @endsection

    @push('scripts')
        
<script>
document.getElementById("title_deed").addEventListener("change", function() {
    const container = document.querySelector(".upload_documents");
    if (this.files.length > 0) {
        container.classList.add("red-border");
    } else {
        container.classList.remove("red-border");
    }
});
</script>
    @endpush



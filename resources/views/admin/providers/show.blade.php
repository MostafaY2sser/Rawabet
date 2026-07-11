@extends('admin.layouts.main')


@section("content")

      <div class="project_details profile "  id="main_page">

   
         <div class="project_info  profile_info  ">
            <div class="text d-flex align-content-center justify-content-between">
                <div class="information d-flex align-items-center gap-3 mt-4">
                    <div class="image d-flex align-items-center justify-content-center">
                        <img src="/assets/images/home/pepole_rate.png" alt="">
                    </div>
                    <div class="info d-flex flex-column gap-2 align-items-start">
                        <h2>{{ $provider->company_name }}</h2>
                        {{-- <p>شركة ذات مسؤولية محدودة</p> --}}
                    </div>
                </div>
                @can('edit providers')            
                    <button class="main_btn_bg change_inspection">
                        <span>تعديل </span>
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                @endcan
            </div>
         

        

            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="main_info" >
                        <i class="fa-regular fa-user"></i>
                        <span>المعلومات الأساسية</span>
                    </li>
                    <li data-target="documents">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>المستندات</span>
                    </li>
                  
                </ul>
            </div>



            <div class="contents">

                <div class="section_tap  main_info ">
                    <div class="about">
                        <div class="row">
                            <div class="col-md-6">
                                <p>اسم الشركة</p>
                                <span>{{ $provider->company_name }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>نوع الكيان القانوني</p>
                                <span>{{ $provider->legal_entity_type }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم السجل التجاري</p>
                                <span>{{ $provider->commercial_registration }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم هوية المالك</p>
                                <span>{{ $provider->owner_id }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>رقم الهاتف</p>
                                <span>{{ $provider->phone_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>البريد الإلكتروني</p>
                                <span>{{ $provider->email }}</span>
                            </div>
                            <div class="col-md-6">
                                <p>العنوان الرسمي</p>
                                <span>{{ $provider->city->name }} - {{$provider->region->name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="specialization mb-4">
                        <h6>مجالات التخصص</h6>
                       <div class="d-flex align-items-center gap-2 flex-wrap">
                        @foreach ($provider->specializations as $item)
                            <span>{{ $item->name }}</span>
                            
                        @endforeach
                    </div>
                    <div class="Geographical">
                        <h6>النطاق الجغرافي</h6>
                       <div class="d-flex align-items-center gap-2 flex-wrap">
                            @foreach ($provider->workRegions as $item)
                            <span>{{ $item->name }}</span>
                            
                        @endforeach
                    
                       </div>
                    </div>
                </div></div>

                <div class="section_tap  documents ">
                   <div class="row">
                                       @foreach ($attachments as $key=>$list)

                              @foreach ($list as $file)
                        <div class="col-md-6">
                             <div class="file">
                                <h6>{{ $key }}</h6>
                                <div class="file_name my-3">
                                    <i class="fa-regular fa-file-lines"></i>
                                    <span>{{ $file->file_name }} </span>
                                </div>
                                <div class="buttons d-flex align-items-center gap-2 mt-2">
                                    {{-- <button class="main_btn_bg veiw preview" onclick="previewFile('{{ Storage::url($file->file_path) }}')"><i class="fa-regular fa-eye"></i></button> --}}
                                    <button class="main_btn_bg download" onclick="downloadFile('{{ Storage::url($file->file_path) }}')"><i class="fa-solid fa-download"></i></button>
                                </div>
                                <div class="status_profile">
                                    <i class="fa-regular fa-circle-check"></i>
                                    <span>معتمد</span>
                                </div>
                             </div>
                        </div>
                        @endforeach
                        @endforeach

                      
                   </div>
                  
                </div>



            </div>




        </div>

        </div>
               <div class="request_inspection">
        <div class="wrapper">
            <h6>تعديل </h6>
            <form action="{{ route('admin.providers.requests.update.status' , $provider->id) }}" method="POST">

                @csrf
                <div class="input_group my-5">
                    <label for="time">اختر الحاله</label>
                    <select name="status" class="form-control" id="ProviderStatus">
                        <option value="{{ \App\Enums\ProviderStatus::PENDING->value }}">
                            {{ \App\Enums\ProviderStatus::getLabel('pending') }}</option>
                        <option value="{{ \App\Enums\ProviderStatus::REQUIREUPDATE->value }}">
                            {{ \App\Enums\ProviderStatus::getLabel('require_update') }}</option>
                    </select>

                </div>
                <div class="input_group mt-4 mb-4" id="msgWrapper" style="display: none;">
                    <label for="msg">الرساله</label>
                    <textarea name="msg" id="msg" cols="30" class="form-control" rows="3"></textarea>
                </div>

                <div class="buttons">
                    <button class="main_btn_bg">تأكيد التغيير</button>
                    <button class="main_btn_bg cancel">إلغاء</button>
                </div>
            </form>
            <div class="close_request_inspection">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4L4 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4 4L12 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </div>
        @endsection
        @push("scripts")
    <script src="/assets/js/switch-tabs.js"></script>
    <script src="/assets/js/request/profile.js"></script>
    
            <script>
    // open
    function previewFile(fileName) {
      window.open(`${fileName}`, '_blank')
    }

    // download
    function downloadFile(fileName) {
      const link = document.createElement('a')
      link.href = `${fileName}`
      link.download = fileName
      link.click()
    }
</script>

<script>

     document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.change_inspection').addEventListener("click", function(e) {
                e.preventDefault();
                document.querySelector('.request_inspection').classList.add("show");
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const consultantPopup = document.querySelector('.request_inspection');

            document.querySelectorAll('.close_request_inspection, .request_inspection .cancel').forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    consultantPopup.classList.remove("show");
                });
            });
        }); 
        </script>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('ProviderStatus');
        const msgWrapper = document.getElementById('msgWrapper');
        const msgInput = document.getElementById('msg');

        function toggleMsgField() {
            if (statusSelect.value === '{{ \App\Enums\ProviderStatus::REQUIREUPDATE->value }}') {
                msgWrapper.style.display = 'block';
                msgInput.setAttribute('required', 'required');
            } else {
                msgWrapper.style.display = 'none';
                msgInput.removeAttribute('required');
            }
        }

        // Initial check on page load
        toggleMsgField();

        // Watch for changes
        statusSelect.addEventListener('change', toggleMsgField);
    });
</script>
        @endpush
<div class="step_five">

                <div class="content_step">

                    <div class="step_neme">
                        <h3>مراجعة وإرسال طلب المشروع</h3>
                        <p>راجع جميع التفاصيل قبل إرسال الطلب</p>
                    </div>

                    <form action="{{ route('customer.project.update' , ['step'=>5 , 'id'=>$project->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form_box">
                            <div class="row ">

                                <div class="review type">
                                    <div class="title">
                                        <h6>تفاصيل الخدمة</h6>
                                        <div class="update">
                                           <a href="{{ route('customer.project.edit' , ['step'=>1 , 'id'=>$project->id]) }}">
                                             <i class="fa-regular fa-pen-to-square"></i>
                                             <span>تعديل</span>
                                           </a>
                                         </div>
                                    </div>
                                    <input type="text" value="{{ $project->projectType->name }}"  readonly >
                                </div>

                                <div class="review details">
                                    <div class="title">
                                        <h6>تفاصيل الخدمة</h6>
                                        <div class="update">
                                         <a href="{{ route('customer.project.edit' , ['step'=>2 , 'id'=>$project->id]) }}">
                                             <i class="fa-regular fa-pen-to-square"></i>
                                             <span>تعديل</span>
                                           </a>
                                         </div>
                                    </div>
                                    <div class="groups_input">
                                        <div class="group">
                                            <label>نوع الخدمة</label>
                                            <input type="text" value="{{ $project->ServiceType->name }}" readonly >
                                        </div>
                                        <div class="group">
                                            <label>الموقع</label>
                                            <input type="text" value="{{ $project->address }}" readonly >
                                        </div>
                                        <div class="group">
                                            <label>وصف الآعمال الشائعة</label>
                                            <input type="text" value="{{ $project->category?->name ?? '' }}" readonly >
                                        </div>
                                        <div class="group">
                                            <label>وصف الأعمال المطلوبة</label>
                                            <input type="text" value="{{ $project->work_description }}" readonly >
                                        </div>
                                    </div>
                                </div>                    
                                <div class="review budget">
                                    <div class="title">
                                        <h6>الميزانية والجدول الزمني</h6>
                                        <div class="update">
                                            <a href="{{ route('customer.project.edit' , ['step'=>3 , 'id'=>$project->id]) }}">
                                             <i class="fa-regular fa-pen-to-square"></i>
                                             <span>تعديل</span>
                                           </a>
                                         </div>
                                    </div>
                                    <div class="groups_input">
                                        <div class="group">
                                            <label>الميزانية المتوقعة (ر.س)</label>
                                            <input type="text" value="{{ $project->budget }}" readonly >
                                        </div>
                                        <div class="group">
                                            <label>تاريخ البدء المتوقع</label>
                                            <input type="text" value="{{ $project->start_date }}" readonly >
                                        </div>
                                        <div class="group">
                                            <label>المدة المتوقعة</label>
                                            <input type="text" value="شهر {{ $project->duration }} " readonly >
                                        </div>
                                    </div>
                                </div>                    
                                <div class="review document">
                                    <div class="title">
                                        <h6>المستندات</h6>
                                        <div class="update">
                                          <a href="{{ route('customer.project.edit' , ['step'=>4 , 'id'=>$project->id]) }}">
                                             <i class="fa-regular fa-pen-to-square"></i>
                                             <span>تعديل</span>
                                           </a>
                                         </div>
                                    </div>
                                    <div class="groups_input">
                                        @if(count($attachments) > 0)
                                            @foreach ($attachments as $key => $attachmentEntry)
                                                @php
                                                    $attachmentItems = $attachmentEntry instanceof \Illuminate\Support\Collection
                                                        ? $attachmentEntry
                                                        : ($attachmentEntry ? collect([$attachmentEntry]) : collect());
                                                @endphp

                                                @if($attachmentItems->isNotEmpty())
                                                    <div class="group">
                                                        <label>{{ $key }}</label>
                                                        <div class="box">
                                                            @foreach ($attachmentItems as $subkey => $item)
                                                                <div class="inputs">
                                                                    <span>
                                                                        <i class="fa-regular fa-file-lines"></i>
                                                                    </span>
                                                                    <a href="{{ route('customer.project.downlaod.file', $item->id) }}" target="_blank">
                                                                        #{{ $subkey + 1 }} {{ $key }}
                                                                    </a>
                                                                </div>
                                                                <input type="file" value="" readonly hidden>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                </div>                    


                            </div>
                        </div>

                    <div class="buttons">
                        <a class="back_cancel" href="{{ route('customer.project.edit' , ['step'=>4  , 'id'=>$project->id]) }}">
                            <i class="fa-solid fa-arrow-right"></i>
                            السابق  
                        </a>
                        <button type="submit" class="main_btn_bg next_step">
                            إرسال المشروع للمراجعة
                        </button>

                    </div>
                    </form>



                </div>
             </div>
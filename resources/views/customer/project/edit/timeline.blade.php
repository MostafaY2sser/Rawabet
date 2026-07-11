<div class="step_three">

             

                <div class="content_step">

                    <div class="step_neme">
                        <h3>الميزانية والجدول الزمني</h3>
                        <p>حدد الميزانية التقديرية والمدة الزمنية المتوقعة</p>
                    </div>

                    <form action="{{ route('customer.project.update' , ['step'=>3 , 'id'=>$project->id ,  'edit'=>1]) }}" method="POST">
                         @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        @method('PUT')
                        @csrf
                        <div class="form_box">
                            <div class="sm:row ">

                                <div class="input_group">
                                    <label for="expected_budget">الميزانية المتوقعة (ر.س)</label>
                                    <input type="text" value="{{ $project->budget ?? old('budget') }}" name="budget" id="expected_budget" placeholder="حد ادني 1000 ر.س" required>
                                </div>

                                <div class="row p-0 my-4">
                                    <div class="col-md-6">
                                        <div class="input_group">
                                            <label for="start_date">تاريخ البدء المتوقع</label>
                                            <input type="date" name="start_date" value="{{ $project->start_date ?? old('start_date') }}" id="start_date" placeholder="يوم / شهر / سنه" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input_group">
                                            <label for="finishing">مدة الانتهاء المتوقعة (بالشهور)</label>
                                            <input 
                                                type="number" 
                                                min="0"
                                                step="1"  
                                                name="duration"
                                                value="{{ $project->duration ?? old('duration') }}" 
                                            >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- <button type="submit">save</button> --}}
                        <div class="buttons">
                            {{-- <a href="{{ route('customer.project.edit' , ['step'=>2  , 'id'=>$project->id]) }}" class="back_cancel" >
                                <i class="fa-solid fa-arrow-right"></i>
                                <span>السابق</span>
                            </a> --}}
                            <button type="submit" class="main_btn_bg next_step">
                                <span>حفظ</span>
                            </button>
                        </div>
                    </form>


                </div>


             </div>
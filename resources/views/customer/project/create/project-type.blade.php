
            <!-- Step One -->
             <div class="step_one ">                
                <div class="content_step">

                    <div class="step_neme">
                        <h3>اختر نوع مشروعك</h3>
                        <p>حدد تصنيف المشروع الذي تريد تنفيذه</p>
                    </div>

                    <form action="{{ route('customer.project.create') }}" method="POST" >
                        @csrf
                        <div class="form_box">
                            <div class="row">
                                @foreach ($types as $item)
                                       <div class="col-6 col-md-4">
                                    <input type="radio" id="tp{{ $item->id }}" 
                                    @if (isset($project) && $project->project_type == $item->id) checked
                                    @elseif (!isset($project) && old('project_type') == $item->id) checked
                                    @endif
                                    name="project_type" value="{{ $item->id }}" hidden />
                                    <label class="specialization-box" for="tp{{ $item->id }}">
                                        <h6>{{$item->name}}</h6>
                                        <span>{{ $item->description }}</span>
                                    </label>
                                </div>
                                @endforeach
            
                            </div>

                            @if (isset($project))
                                <input type="hidden" name="project_id" value="{{ $project->id }}" />

                            @endif

                        </div>
                        <div class="buttons">
                            {{-- <button class="back_cancel" id="close_add_project">إلغاء</button> --}}
                            <a href="/customer/dashboard" id="close_add_project" class="back_cancel">إلغاء</a>
                            <button type="submit" class="main_btn_bg  next_step" >
                                <span>التالي</span>
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        </div>
                    </form>


                </div>

             </div>  
            <!-- Step One -->

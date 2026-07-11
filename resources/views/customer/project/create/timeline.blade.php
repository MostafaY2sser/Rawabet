<div class="step_three">

             

                <div class="content_step">

                    <div class="step_neme">
                        <h3>الميزانية والجدول الزمني</h3>
                        <p>حدد الميزانية التقديرية والمدة الزمنية المتوقعة</p>
                    </div>

                    <form action="{{ route('customer.project.update' , ['step'=>3 , 'id'=>$project->id]) }}" method="POST">
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
                                    {{-- <input type="text" value="{{ $project->budget ?? old('budget') }}" name="budget" id="expected_budget" placeholder="حد ادني 1000 ر.س" required> --}}
                                    
                                    {{-- Input Show user only with commas --}}
                                    <input type="text" id="expected_budget_display" placeholder="حد ادني 1000 ر.س" value="{{ number_format($project->budget, 0, '.', ',') }}" required>
                                    {{-- Input send server  --}}
                                    <input type="hidden" name="budget" id="expected_budget">
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
                            <a href="{{ route('customer.project.edit' , ['step'=>2  , 'id'=>$project->id]) }}" class="back_cancel" >
                                <i class="fa-solid fa-arrow-right"></i>
                                <span>السابق</span>
                            </a>
                            <button type="submit" class="main_btn_bg next_step">
                                <span>التالي</span>
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        </div>
                    </form>


                </div>


             </div>


<script>
    const displayInput = document.getElementById('expected_budget_display');
    const budgetInput = document.getElementById('expected_budget');

    function formatNumber(value) {
        return Number(value.replace(/,/g, '') || 0).toLocaleString('en-US');
    }

    // hidden input value should be the raw number without commas 
    budgetInput.value = displayInput.value.replace(/,/g, '');

    displayInput.addEventListener('input', (e) => {
        let rawValue = e.target.value.replace(/,/g, '');
        
        if (!isNaN(rawValue) && rawValue !== '') {
            displayInput.value = formatNumber(rawValue);
            // Real input without commas 
            budgetInput.value = rawValue;
        } else {
            displayInput.value = '';
            budgetInput.value = '';
        }
    });
</script>
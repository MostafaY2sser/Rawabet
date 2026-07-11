        <style>
            .files_upload {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .upload_documents_box.dragging {
                border: 2px dashed #67b02f;
                background: rgba(79, 70, 229, 0.05);
                transform: scale(1.01);
            }

            .uploaded_file_item {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 6px;
            }

            .uploaded_file_item button {
                border: 0;
                background: #ef4444;
                color: #fff;
                border-radius: 4px;
                padding: 2px 8px;
                font-size: 12px;
                cursor: pointer;
            }

            @media (max-width: 768px) {
                .files_upload {
                    flex-direction: column;
                    align-items: start;
                }
            }
        </style>
        <div class="step_four">

            <div class="content_step">

                <div class="step_neme">
                    <h3>رفع المستندات</h3>
                    <p>ارفع المستندات المطلوبة لمشروعك</p>
                </div>

                <form action="{{ route('customer.project.update', ['step' => 4, 'id' => $project->id , 'edit'=>1]) }}" method="POST"
                    enctype="multipart/form-data">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    @method('PUT')
                    <div class="form_box">

                        <div class="upload_documents">
                            <label class="file-label">صك الملكية</label>
                            <label class="upload_documents_box" for="title_deed">
                                <div class="icon">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </div>
                                <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                <input type="file" name="title_deed" id="title_deed" accept=".jpg,.jpeg,.png,.pdf"
                                     hidden>
                            </label>
                            <div class="files_upload">
                                <div class="file-preview" id="title_deed_preview">
                                    @if(isset($attachments['title_deed']))
                                    <a href="{{ route('customer.project.downlaod.file' , $attachments['title_deed']->id) }}">صك الملكية</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="upload_documents">
                            <label class="file-label">صوره حالية للموقع/العقار  </label>
                            <label class="upload_documents_box" for="curent_img">
                                <div class="icon">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </div>
                                <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                <div class="file-note">JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                <input type="file" name="curent_img" id="curent_img" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" hidden multiple>
                            </label>
                            <div class="files_upload">
                                <div class="file-preview" id="curent_img_preview">
                                      @if(isset($attachments['curent_img']) && count($attachments['curent_img']))
                                        @foreach($attachments['curent_img'] as $file)
                                            <div class="uploaded_file_item">
                                                <a href="{{ route('customer.project.downlaod.file', $file->id) }}">
                                                    صوره حالية
                                                </a>
                                                <button type="button" class="remove-uploaded-file"
                                                    data-url="{{ route('customer.project.delete.attachment', $file->id) }}">
                                                    حذف
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="upload_documents">
                            <label class="file-label">رخصة البناء (إن وجدت)</label>
                            <label class="upload_documents_box" for="building_permit">
                                <div class="icon">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </div>
                                <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                <input type="file" name="building_permit" id="building_permit"
                                    accept=".jpg,.jpeg,.png,.pdf" hidden>
                            </label>
                            <div class="files_upload">
                                <div class="file-preview" id="building_permit_preview">
                                      @if(isset($attachments['building_permit']))
                                    <a href="{{ route('customer.project.downlaod.file' , $attachments['building_permit']->id) }}">رخصة البناء</a>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="upload_documents">
                            <label class="file-label">المخططات الهندسية (إن وجدت)</label>
                            <label class="upload_documents_box" for="drawings">
                                <div class="icon">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </div>
                                <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                <input type="file" name="drawings" id="drawings" accept=".jpg,.jpeg,.png,.pdf"
                                    hidden>
                            </label>
                            <div class="files_upload">
                                <div class="file-preview" id="drawings_preview">
                                      @if(isset($attachments['drawings']))
                                    <a href="{{ route('customer.project.downlaod.file' , $attachments['drawings']->id) }}">المخططات الهندسية</a>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="upload_documents">
                            <label class="file-label">مستندات إضافية (اختياري)</label>
                            <label class="upload_documents_box" for="additional_documents">
                                <div class="icon">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </div>
                                <p>اسحب الملفات هنا أو انقر للتحميل</p>
                                <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                                <input type="file" name="additional_documents" id="additional_documents"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" hidden multiple>
                            </label>
                            <div class="files_upload">
                                <div class="file-preview" id="additional_documents_preview">
                                      @if(isset($attachments['additional_documents']) && count($attachments['additional_documents']))
                                        @foreach($attachments['additional_documents'] as $file)
                                            <div class="uploaded_file_item">
                                                <a href="{{ route('customer.project.downlaod.file', $file->id) }}">
                                                    مستند إضافي
                                                </a>
                                                <button type="button" class="remove-uploaded-file"
                                                    data-url="{{ route('customer.project.delete.attachment', $file->id) }}">
                                                    حذف
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>

                    {{-- <button type="submit">save</button> --}}
                    <div class="buttons">
                        {{-- <a href="{{ route('customer.project.edit', ['step' => 3, 'id' => $project->id]) }}"
                            class="back_cancel">
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




        <script src="../../../../assets/js/customer/project.js?v={{ time() }}"></script>

        <script>
            document.querySelectorAll(".upload_documents_box").forEach(box => {
                const input = box.querySelector('input[type="file"]');

                ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
                    box.addEventListener(eventName, e => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                ["dragenter", "dragover"].forEach(eventName => {
                    box.addEventListener(eventName, () => {
                        box.classList.add("dragging");
                    });
                });

                ["dragleave", "drop"].forEach(eventName => {
                    box.addEventListener(eventName, () => {
                        box.classList.remove("dragging");
                    });
                });

                box.addEventListener("drop", (e) => {
                    const files = e.dataTransfer.files;
                    if (!files.length) return;

                    input.files = files;
                    input.dispatchEvent(new Event("change"));
                });
            });
        </script>

        <script>
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('click', function() {
                    // Allow re-selecting the same files from picker.
                    this.value = null;
                });

                input.addEventListener('change', function() {

                    if (!this.files.length) return;

                    let formData = new FormData();

                    // append project id
                    formData.append('project_id', "{{ $project->id }}");

                    const isMultipleField = this.hasAttribute('multiple');
                    if (isMultipleField) {
                        Array.from(this.files).forEach(file => {
                            formData.append('files[]', file);
                        });
                        // Keep backward compatibility in case backend checks single key.
                        formData.append('file', this.files[0]);
                    } else {
                        formData.append('file', this.files[0]);
                    }

                    // append the field name as a separate field
                    formData.append('field_name', this.name);

                    // csrf
                    formData.append('_token', "{{ csrf_token() }}");

                    fetch("{{ route('customer.project.update.attachment') }}", {
                            method: "POST",
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                window.location.reload();
                            } else {
                                const message = data?.errors
                                    ? Object.values(data.errors).flat().join("\n")
                                    : "حدث خطأ أثناء الرفع";
                                alert(message);
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            alert("فشل الاتصال بالسيرفر");
                        });

                });

            });
        </script>

        <script>
            document.addEventListener('click', function(e) {
                const button = e.target.closest('.remove-uploaded-file');
                if (!button) return;

                e.preventDefault();
                if (!confirm('هل تريد حذف هذا الملف؟')) return;

                fetch(button.dataset.url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            window.location.reload();
                        } else {
                            alert('فشل حذف الملف');
                        }
                    })
                    .catch(() => alert('فشل الاتصال بالسيرفر'));
            });
        </script>

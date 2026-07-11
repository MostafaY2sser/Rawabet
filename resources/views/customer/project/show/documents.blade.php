          <div class="documents  section_tap">
                   <div class="row">
                            @foreach ($attachments as $key=>$list)

                              @foreach ($list as $file)
                        <div class="col-md-6">

                                     <div class="card_content">
                                <div class="file_info">
                                    <i class="fas fa-file-pdf icon-pdf fa-lg"></i>
                                    <div class="file_details">
                                        <p>{{ $key }}</p>
                                    </div>
                                </div>
                                <div class="file_actions">
                                    <a class="main_btn_bg preview" href="{{ route('customer.project.downlaod.file', $file->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- <button class="main_btn_bg download" onclick="downloadFile('{{ Storage::url($file->file_path) }}')">
                                        <i class="fas fa-download"></i>
                                    </button> --}}
                                </div>
                        </div>
                             </div>
                              @endforeach
                                
                            @endforeach
                   </div>
                </div>

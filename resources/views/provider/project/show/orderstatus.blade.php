 <div class="order_status   content_tap d-none">
                    <h6 class="main_title">حالة الطلب</h6>
                    <div class="timeline">
                        @php
                            $steps = ProjectUtility::getStatusesOrder();
                            $statusKeys = array_keys($steps);
                            $currentStatus = is_object($project->status) ? $project->status->value : $project->status;
                            $currentStatusIndex = array_search($currentStatus, $statusKeys);
                        @endphp

                        @foreach ($steps as $status => $step)
                            @php
                                $index = array_search($status, $statusKeys);
                                $stepClass =
                                    $index < $currentStatusIndex
                                        ? 'completed'
                                        : ($index === $currentStatusIndex
                                            ? 'current'
                                            : 'waiting');
                            @endphp

                            <div class="step {{ $stepClass }}">
                                <div class="icon"><i class="{{ $step['icon'] }}"></i></div>
                                <div class="content">
                                    <div class="title">
                                        <h6>{{ $step['title'] }}</h6>
                                        <span class="{{ $stepClass }}">
                                            {{ $stepClass === 'completed' ? 'مكتمل' : ($stepClass === 'current' ? 'الحالي' : 'في الانتظار') }}
                                        </span>
                                    </div>
                                    <p class="status">{{ $step['description'] }}</p>
                                    <div class="date">
                                        <img src="{{ asset('assets/images/customer/icons/culander.png') }}"
                                            alt="">
                                        <span>{{ $project->updated_at->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
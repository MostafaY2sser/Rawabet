 <div class="order_status   section_tap">
                    <h6 class="main_title">حالة الطلب</h6>
                    <div class="timeline">
                        @php
                            $steps = ProjectUtility::getProjectTrackStatus();
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
                                    @if($step['key'] === 'first_inspection_scheduled')
                                        <p>
                                            الموعد المحدد:
                                            {{ $project->firstInspection()?->date?->format('Y-m-d') ?? '---' }}
                                            @if($project->firstInspection()?->time)
                                                - {{ $project->firstInspection()->time }}
                                            @endif
                                        </p>
                                    @endif
                                    <div class="date">
                                        <img src="{{ asset('assets/images/customer/icons/culander.png') }}"
                                            alt="">
                                        @if($step['key'] === 'pending')
                                            <span>{{ $project->created_at?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'accepted_inspection')
                                            <span>{{ $project->firstInspection()?->created_at?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'first_inspection_scheduled')
                                            <span>{{ $project->firstInspection()?->date?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'first_inspection_completed')
                                            <span>{{ $project->firstInspection()?->updated_at?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'open_for_offers')
                                            <span>{{ $project->open_for_offers_date?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'in_progress')
                                            <span>{{ $project->accept_offer_date?->format('Y-m-d') ?? '---' }}</span>
                                        @elseif ($step['key'] === 'completed')
                                            <span>{{ $project->completed_at?->format('Y-m-d') ?? '---' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
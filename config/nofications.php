<?php

return [
    'types' => [
        'new_project_created' => [
            'title' => 'مشروع جديد',
            'description' => 'تم إنشاء مشروع جديد: :project.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3.5H21V21.5H3V3.5Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 9.5H21" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 21.5V9.5" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>',
            'class' => 'project'
        ],
        'offer_item_updated' => [
            'title' => 'تم تحديث مرحلة العمل',
            'description' => 'تم تحديث المرحلة ":stage" ضمن عرض المشروع :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                 <path d="M12 2L15 8H9L12 2Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                 <path d="M12 22V8" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                 <path d="M4 22H20" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>',
            'class' => 'project-stage'
        ],
        'offer_item_progress_updated' => [
            'title' => 'تحديث في نسبة إنجاز المرحلة',
            'description' => 'تم تحديث نسبة الإنجاز للمرحلة ":stage" في مشروع :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 18V6C3 4.89543 3.89543 4 5 4H11C12.1046 4 13 4.89543 13 6V18C13 19.1046 12.1046 20 11 20H5C3.89543 20 3 19.1046 3 18Z" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M21 15V9C21 7.89543 20.1046 7 19 7H17C15.8954 7 15 7.89543 15 9V15C15 16.1046 15.8954 17 17 17H19C20.1046 17 21 16.1046 21 15Z" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>',
            'class' => 'project-stage',
        ],
        'offer_item_request_payment' => [
            'title' => 'طلب دفع لمرحلة العمل',
            'description' => 'تم طلب دفعة للمرحلة ":stage" ضمن مشروع :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 1V23" stroke="#F59E0B" stroke-width="2" stroke-linecap="round"/>
        <path d="M5 5H19C20.1046 5 21 5.89543 21 7V17C21 18.1046 20.1046 19 19 19H5C3.89543 19 3 18.1046 3 17V7C3 5.89543 3.89543 5 5 5Z" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M9 9H15V15H9V9Z" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>',
            'class' => 'payment',
        ],
        'offer_item_paid' => [
            'title' => 'تم دفع مرحلة العمل',
            'description' => 'تم دفع المرحلة ":stage" في مشروع :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 8V16" stroke="#22C55E" stroke-width="2" stroke-linecap="round"/>
        <path d="M9 13H12C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7H11C9.89543 7 9 7.89543 9 9" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="12" cy="12" r="10" stroke="#22C55E" stroke-width="2"/>
    </svg>',
            'class' => 'payment',
        ],
        'admin_new_offer' => [
            'title' => 'عرض جديد ',
            'description' => 'تمت إضافة عرض جديد للمشروع :project.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#059669" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'project'
        ],
        'new_offer' => [
            'title' => 'عرض جديد ',
            'description' => 'تمت إضافة عرض جديد لمشرعك :project.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#059669" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'project'
        ],
        'inspection_rescheduled' => [
            'title' => 'تم تغيير موعد الاستشارة مع :consultant',
            'description' => 'تم تعديل موعد استشارتك ليكون يوم :day الساعة :time مع.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#FBBF24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#FBBF24" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'warning'
        ],
        'inspection_pending' => [
            'title' => 'الفحص معلق مع :consultant',
            'description' => 'الفحص الخاص بمشروعك حالته الآن معلقة.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#2563EB" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'pending'
        ],
        'inspection_completed' => [
            'title' => '  مكتمل الفحص مع :consultant',
            'description' => 'تم إتمام الفحص الخاص بمشروعك.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#10B981" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'completed'
        ],
        'inspection_canceled' => [
            'title' => ' الغي الفحص مع :consultant',
            'description' => 'تم إلغاء الفحص الخاص بمشروعك.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 9L9 15" stroke="#DC2626" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M9 9L15 15" stroke="#DC2626" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>',
            'class' => 'canceled'
        ],
        'customer_request_stage_inspection' => [
            'title' => 'طلب فحص لمرحلة عمل',
            'description' => 'قام العميل بطلب فحص للمرحلة ":stage" ضمن مشروع :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 13.6249 4.48022 15.1365 5.3045 16.3937L4 20L7.60629 18.6955C8.86352 19.5198 10.3751 20 12 20Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M9 12H15" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
        <path d="M12 9V15" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
    </svg>',
            'class' => 'inspection',
        ],
        'stage_inspection_completed' => [
            'title' => 'تم الانتهاء من فحص المرحلة',
            'description' => 'تم الانتهاء من فحص المرحلة ":stage" في مشروع :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 6L9 17L4 12" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="12" cy="12" r="10" stroke="#3B82F6" stroke-width="2"/>
    </svg>',
            'class' => 'inspection',
        ],
        'admin_project_approved' => [
            'title' => ':project تمت الموافقة على مشروع',
            'description' => 'قام المسؤول بقبول طلبك. يمكنك الآن متابعة الخطوات التالية من لوحة التحكم.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                            stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#059669" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>',
            'class' => 'success'
        ],
        'admin_project_rejected' => [
            'title' => ' :project تم رفض مشروع ',
            'description' => 'قام المسؤول برفض طلبك. يرجى مراجعة التفاصيل أو الاتصال بالدعم للمساعدة.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                            stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 9L9 15" stroke="#DC2626" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M9 9L15 15" stroke="#DC2626" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>',
            'class' => 'rejected'
        ],
        'admin_project_pending' => [
            'title' => 'مشروع :project قيد المراجعة',
            'description' => 'طلبك ما زال قيد المراجعة من قبل الإدارة. سيتم إشعارك عند اتخاذ القرار.',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12.5" r="10" stroke="#F59E0B" stroke-width="2"/>
                        <path d="M12 7.5V13.5L15 16.5" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                   </svg>',
            'class' => 'pending',
        ],
        'admin_project_require_complete' => [
            'title' => 'مطلوب استكمال بيانات مشروع :project',
            'description' => 'يرجى استكمال البيانات أو المتطلبات الناقصة لإتمام العملية.',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12.5" r="10" stroke="#DC2626" stroke-width="2"/>
                        <path d="M12 8.5V13.5" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="17.5" r="1" fill="#DC2626"/>
                   </svg>',
            'class' => 'require',
        ],
        'admin_project_in_progress' => [
            'title' => 'مشروع  :project قيد التنفيذ',
            'description' => 'تم بدء العمل على مشروعك، فريقنا يعمل على إنجازه.',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 13.5H20M12 4.5V20.5" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                   </svg>',
            'class' => 'progress',
        ],
        'admin_project_completed' => [
            'title' => 'اكتمل مشروع:project',
            'description' => 'تم الانتهاء من مشروعك بنجاح. شكراً لاستخدامك منصتنا.',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13.5L10 18.5L20 7.5" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                   </svg>',
            'class' => 'success',
        ],
        'admin_project_open_for_offers' => [
            'title' => 'مشروع :project مفتوح لتلقي العروض',
            'description' => 'مشروعك متاح الآن للمستقلين لتقديم عروضهم.',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3.5L2 9.5L12 15.5L22 9.5L12 3.5Z" stroke="#9333EA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 15.5L12 21.5L22 15.5" stroke="#9333EA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                   </svg>',
            'class' => 'open',
        ],
        'admin_project_first_inspection_scheduled' => [
            'title' => ' :project تم تحديد موعد الفحص الأول لمشروع ',
            'description' => 'تم جدولة الفحص الأول للمشروع، يرجى متابعة التحديثات.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#2563EB" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'scheduled',
        ],
        'admin_project_first_inspection_completed' => [
            'title' => ' تم إتمام الفحص الأول مشروع :project ',
            'description' => 'الفحص الأول للمشروع اكتمل بنجاح.',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#10B981" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'completed',
        ],
        'offer_require_update' => [
            'title' => 'العرض على مشروع :project يحتاج تعديل',
            'description' => 'العرض المقدم على مشروع :project يحتاج تعديل من قبلك. آخر تحديث: :updated_at',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12.5" r="10" stroke="#DC2626" stroke-width="2"/>
                        <path d="M12 8.5V13.5" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="17.5" r="1" fill="#DC2626"/>
                   </svg>',
            'class' => 'need-edit',
        ],
        'offer_pending' => [
            'title' => 'العرض على مشروع :project قيد المراجعة',
            'description' => 'تم تقديم العرض على مشروع :project وهو الآن قيد المراجعة. آخر تحديث: :updated_at',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 13.5H20M12 4.5V20.5" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                   </svg>',
            'class' => 'pending',
        ],
        'offer_approved' => [
            'title' => 'العرض على مشروع :project تم اعتماده',
            'description' => 'تم اعتماد العرض على مشروع :project بنجاح. آخر تحديث: :updated_at',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#10B981" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'approved',
        ],
        'offer_accepted' => [
            'title' => 'العرض على مشروع :project تم قبوله',
            'description' => 'تم قبول العرض على مشروع :project. آخر تحديث: :updated_at',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#10B981" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'accepted',
        ],
        'offer_declined' => [
            'title' => 'العرض على مشروع :project تم رفضه',
            'description' => 'تم رفض العرض على مشروع :project. آخر تحديث: :updated_at',
            'icon' => '<svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12.5" r="10" stroke="#DC2626" stroke-width="2"/>
                        <path d="M12 8.5V13.5" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="17.5" r="1" fill="#DC2626"/>
                   </svg>',
            'class' => 'cancelled',
        ],
        'offer_completed' => [
            'title' => 'العرض على مشروع :project مكتمل',
            'description' => 'تم إكمال العرض على مشروع :project. آخر تحديث: :updated_at',
            'icon' => '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 11.4763V12.3963C21.9988 14.5528 21.3005 16.651 20.0093 18.3782C18.7182 20.1053 16.9033 21.3688 14.8354 21.9802C12.7674 22.5917 10.5573 22.5182 8.53447 21.7709C6.51168 21.0236 4.78465 19.6424 3.61096 17.8334C2.43727 16.0244 1.87979 13.8844 2.02168 11.7327C2.16356 9.58091 2.99721 7.53268 4.39828 5.89342C5.79935 4.25417 7.69279 3.11173 9.79619 2.63649C11.8996 2.16126 14.1003 2.37869 16.07 3.25635"
                                stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 11.3984L12 14.3984L22 4.39844" stroke="#10B981" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>',
            'class' => 'completed',
        ],
        'project_report_added' => [
            'title' => 'تمت إضافة تقرير مشروع',
            'description' => 'تمت إضافة تقرير جديد للمشروع: :project.',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 4H20V20H4V4Z" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M4 8H20" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M8 4V8" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M8 12H16" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
        <path d="M8 16H14" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
    </svg>',
            'class' => 'report'
        ],
    ]
];

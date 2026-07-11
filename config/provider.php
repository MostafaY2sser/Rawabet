<?php
return [
    'files' => [
        [
            'name' => 'image_commercial_registration',
            'label' => 'صورة من السجل التجاري',
            'extensions' => ['jpeg', 'png', 'jpg', 'pdf'],
            'multiple' => false,
            'optional' => false,
        ],
        [
            'name' => 'zakat_income',
            'label' => 'شهادة الزكاة والدخل',
            'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
            'multiple' => false,
            'optional' => false,
        ],
        [
            'name' => 'chamber_certificate',
            'label' => 'شهادة الغرفة التجارية',
            'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
            'multiple' => false,
            'optional' => false,
        ],
        [
            'name' => 'saudization_certificate',
            'label' => 'شهادة التوظيف',
            'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
            'multiple' => false,
            'optional' => false,
        ],
        [
            'name' => 'social_insurance',
            'label' => 'شهادة التأمينات الاجتماعية',
            'extensions' => ['jpeg', 'png', 'jpg', 'pdf'],
            'multiple' => true,
            'optional' => false,
            'min' => 2,
        ],
        [
            'name' => 'national_address',
            'label' => 'العنوان الوطني',
            'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
            'multiple' => false,
            'optional' => false,
        ],
        [
            'name' => 'professional_licenses',
            'label' => 'الرخص المهنية',
            'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
            'multiple' => true,
            'optional' => false,
        ],
        [
            'name' => 'extra_attachments',
            'label' => 'مرفقات إضافية',
            'extensions' => ['jpeg', 'png', 'jpg', 'pdf', 'docx', 'doc', 'xls', 'xlsx'],
            'multiple' => false,
            'optional' => true,
        ],
    ],
];

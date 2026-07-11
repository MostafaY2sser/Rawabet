<?php

return [

    "viewable_files_for_provider"=>['curent_img'],
    'files' => [
    [
        'name' => 'title_deed',
        'label' => 'صك الملكية',
        'extensions' => ['jpeg', 'png', 'jpg', 'pdf', 'doc', 'docx'],
        'multiple' => false,
        'optional' => false,
    ],
    [
        'name' => 'curent_img',
        'label' => 'صور حالية للموقع/العقار',
        'extensions' => ['jpeg', 'png', 'jpg', 'pdf', 'doc', 'docx'],
        'multiple' => true,
        'optional' => false,
        'min' => 3,
    ],
    [
        'name' => 'building_permit',
        'label' => 'رخصة البناء',
        'extensions' => ['jpeg', 'png', 'jpg', 'pdf', 'doc', 'docx'],
        'multiple' => false,
        'optional' => true,
    ],
    [
        'name' => 'drawings',
        'label' => 'المخططات الهندسية',
        'extensions' => ['jpeg', 'png', 'jpg', 'pdf', 'doc', 'docx', 'dwg', 'dxf'],
        'multiple' => false,
        'optional' => true,
    ],
    [
        'name' => 'additional_documents',
        'label' => 'مستندات إضافية',
        'extensions' => ['jpeg', 'png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'],
        'multiple' => true,
        'optional' => true,
    ],
],

]

;
<?php

return [

    'column' => [

        'boolean' => [
            'false' => 'لا',
            'true' => 'نعم',
        ],

    ],

    'actions' => [

        'attach' => [
            'label' => 'إرفاق',
        ],

        'bulk_actions' => [
            'label' => 'الإجراءات المجمعة',
        ],

        'create' => [
            'label' => 'إنشاء جديد',
        ],

        'delete' => [
            'label' => 'حذف',
        ],

        'detach' => [
            'label' => 'فصل',
        ],

        'dissociate' => [
            'label' => 'إلغاء الربط',
        ],

        'edit' => [
            'label' => 'تعديل',
        ],

        'export' => [

            'label' => 'تصدير',

            'modal' => [

                'heading' => 'تصدير :label',

                'form' => [

                    'columns' => [

                        'label' => 'الأعمدة',

                        'form' => [

                            'is_enabled' => [
                                'label' => ':column مُفعّل',
                            ],

                            'label' => [
                                'label' => 'تسمية :column',
                            ],

                        ],

                    ],

                ],

                'actions' => [

                    'export' => [
                        'label' => 'تصدير',
                    ],

                ],

            ],

            'notifications' => [

                'completed' => [

                    'title' => 'اكتمل التصدير',

                    'body' => 'تم تصدير ملفك بنجاح ومتاح للتنزيل.',

                ],

                'max_rows' => [
                    'title' => 'التصدير كبير جداً',
                    'body' => 'لا يمكنك تصدير أكثر من صف واحد في وقت واحد.|لا يمكنك تصدير أكثر من :count صفوف في وقت واحد.',
                ],

                'started' => [
                    'title' => 'بدأ التصدير',
                    'body' => 'بدأ تصديرك وسيتم معالجة صف واحد في الخلفية.|بدأ تصديرك وسيتم معالجة :count صفوف في الخلفية.',
                ],

            ],

        ],

        'filter' => [
            'label' => 'تصفية',
        ],

        'group' => [
            'label' => 'تجميع',
        ],

        'import' => [

            'label' => 'استيراد',

            'modal' => [

                'heading' => 'استيراد :label',

                'form' => [

                    'file' => [

                        'label' => 'ملف',

                        'placeholder' => 'رفع ملف CSV',

                        'rules' => [
                            'duplicate_columns' => '{0} يجب ألا يحتوي الملف على أكثر من عمود واحد بعنوان مكرر.|{1,*} يجب ألا يحتوي الملف على أعمدة مكررة: :columns.',
                        ],

                    ],

                    'columns' => [
                        'label' => 'الأعمدة',
                        'placeholder' => 'حدد عموداً',
                    ],

                ],

                'actions' => [

                    'download_example' => [
                        'label' => 'تنزيل ملف CSV مثال',
                    ],

                    'import' => [
                        'label' => 'استيراد',
                    ],

                ],

            ],

            'notifications' => [

                'completed' => [

                    'title' => 'اكتمل الاستيراد',

                    'body' => 'تم استيراد سجل واحد بنجاح.|تم استيراد :count سجلات بنجاح.',

                ],

                'max_rows' => [
                    'title' => 'ملف الاستيراد كبير جداً',
                    'body' => 'لا يمكنك استيراد أكثر من صف واحد في وقت واحد.|لا يمكنك استيراد أكثر من :count صفوف في وقت واحد.',
                ],

                'started' => [
                    'title' => 'بدأ الاستيراد',
                    'body' => 'بدأ استيرادك وسيتم معالجة صف واحد في الخلفية.|بدأ استيرادك وسيتم معالجة :count صفوف في الخلفية.',
                ],

            ],

            'example_csv' => [

                'file_name' => ':importer-مثال',

            ],

            'failure_csv' => [

                'file_name' => 'استيراد-:import_id-:csv_name-فشل-:date',

                'error_header' => 'خطأ',

                'system_error' => 'خطأ في النظام، يرجى الاتصال بالدعم.',

            ],

        ],

        'open_bulk_actions' => [
            'label' => 'الإجراءات',
        ],

        'pin' => [
            'label' => 'تثبيت',
        ],

        'replicate' => [
            'label' => 'تكرار',
        ],

        'toggle_columns' => [
            'label' => 'إظهار/إخفاء الأعمدة',
        ],

        'unpin' => [
            'label' => 'إلغاء التثبيت',
        ],

        'view' => [
            'label' => 'عرض',
        ],

    ],

    'empty' => [

        'heading' => 'لا توجد :model',

        'description' => 'أنشئ :model للبدء.',

    ],

    'filters' => [

        'actions' => [

            'apply' => [
                'label' => 'تطبيق التصفية',
            ],

            'remove' => [
                'label' => 'إزالة',
            ],

            'remove_all' => [
                'label' => 'إزالة الكل',
                'tooltip' => 'إزالة الكل',
            ],

            'reset' => [
                'label' => 'إعادة تعيين',
            ],

        ],

        'heading' => 'التصفية',

        'indicator' => 'التصفية النشطة',

        'multi_select' => [
            'placeholder' => 'الكل',
        ],

        'select' => [
            'placeholder' => 'الكل',
        ],

        'trashed' => [

            'label' => 'السجلات المحذوفة',

            'only_trashed' => 'المحذوفة فقط',

            'with_trashed' => 'مع المحذوفة',

            'without_trashed' => 'بدون المحذوفة',

        ],

    ],

    'grouping' => [

        'fields' => [

            'aggregate' => [
                'label' => 'التجميع',
            ],

            'field' => [
                'label' => 'حقل التجميع',
            ],

            'direction' => [

                'label' => 'اتجاه التجميع',

                'options' => [
                    'asc' => 'تصاعدي',
                    'desc' => 'تنازلي',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'اسحب وأفلت السجلات لإعادة ترتيبها.',

    'selection_indicator' => [

        'selected_count' => 'تم تحديد سجل واحد|تم تحديد :count سجلات',

        'actions' => [

            'select_all' => [
                'label' => 'تحديد جميع الـ :count',
            ],

            'deselect_all' => [
                'label' => 'إلغاء تحديد الكل',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'الترتيب حسب',
            ],

            'direction' => [

                'label' => 'اتجاه الترتيب',

                'options' => [
                    'asc' => 'تصاعدي',
                    'desc' => 'تنازلي',
                ],

            ],

        ],

    ],

    'search' => [

        'label' => 'بحث',

        'placeholder' => 'بحث',

        'indicator' => 'بحث',

    ],

    'pagination' => [

        'label' => 'التنقل بين الصفحات',

        'overview' => '{1} عرض :first من :last من :total نتيجة|[2,*] عرض :first إلى :last من :total نتيجة',

        'fields' => [

            'records_per_page' => [

                'label' => 'لكل صفحة',

                'options' => [
                    'all' => 'الكل',
                ],

            ],

        ],

        'actions' => [

            'first' => [
                'label' => 'الأول',
            ],

            'go_to_page' => [
                'label' => 'انتقل إلى الصفحة :page',
            ],

            'last' => [
                'label' => 'الأخير',
            ],

            'next' => [
                'label' => 'التالي',
            ],

            'previous' => [
                'label' => 'السابق',
            ],

        ],

    ],

    'summaries' => [

        'average' => 'المتوسط',
        'count' => 'العدد',
        'max' => 'الأقصى',
        'min' => 'الأدنى',
        'sum' => 'المجموع',

    ],

];

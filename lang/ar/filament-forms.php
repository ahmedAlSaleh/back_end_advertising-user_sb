<?php

return [

    'fields' => [

        'key_value' => [

            'add_action' => [
                'label' => 'إضافة صف',
            ],

            'delete_action' => [
                'label' => 'حذف صف',
            ],

            'reorder_action' => [
                'label' => 'إعادة ترتيب الصف',
            ],

            'fields' => [

                'key' => [
                    'label' => 'المفتاح',
                ],

                'value' => [
                    'label' => 'القيمة',
                ],

            ],

        ],

        'markdown_editor' => [

            'toolbar_buttons' => [
                'attach_files' => 'إرفاق ملفات',
                'blockquote' => 'اقتباس',
                'bold' => 'عريض',
                'bullet_list' => 'قائمة نقطية',
                'code_block' => 'كتلة برمجية',
                'edit' => 'تعديل',
                'italic' => 'مائل',
                'link' => 'رابط',
                'ordered_list' => 'قائمة مرقمة',
                'preview' => 'معاينة',
                'strike' => 'يتوسطه خط',
                'table' => 'جدول',
                'redo' => 'إعادة',
                'undo' => 'تراجع',
                'heading' => 'عنوان',
            ],

        ],

        'repeater' => [

            'add_action' => [
                'label' => 'إضافة إلى :label',
            ],

            'delete_action' => [
                'label' => 'حذف',
            ],

            'reorder_action' => [
                'label' => 'نقل',
            ],

            'clone_action' => [
                'label' => 'نسخ',
            ],

            'collapse_action' => [
                'label' => 'طي',
            ],

            'collapsed' => 'محتوى مطوي',

            'expand_action' => [
                'label' => 'توسيع',
            ],

        ],

        'rich_editor' => [

            'dialogs' => [

                'link' => [

                    'actions' => [

                        'link' => 'رابط',

                        'unlink' => 'إزالة الرابط',

                    ],

                    'label' => 'الرابط',

                    'placeholder' => 'أدخل الرابط',

                ],

            ],

            'toolbar_buttons' => [
                'attach_files' => 'إرفاق ملفات',
                'blockquote' => 'اقتباس',
                'bold' => 'عريض',
                'bullet_list' => 'قائمة نقطية',
                'code_block' => 'كتلة برمجية',
                'h1' => 'عنوان',
                'h2' => 'عنوان فرعي',
                'h3' => 'عنوان فرعي فرعي',
                'italic' => 'مائل',
                'link' => 'رابط',
                'ordered_list' => 'قائمة مرقمة',
                'redo' => 'إعادة',
                'strike' => 'يتوسطه خط',
                'underline' => 'تحته خط',
                'undo' => 'تراجع',
            ],

        ],

        'select' => [

            'actions' => [

                'create_option' => [

                    'modal' => [

                        'heading' => 'إنشاء',

                        'actions' => [

                            'create' => [
                                'label' => 'إنشاء',
                            ],

                            'create_another' => [
                                'label' => 'إنشاء وإنشاء آخر',
                            ],

                        ],

                    ],

                ],

                'edit_option' => [

                    'modal' => [

                        'heading' => 'تعديل',

                        'actions' => [

                            'save' => [
                                'label' => 'حفظ',
                            ],

                        ],

                    ],

                ],

            ],

            'boolean' => [
                'true' => 'نعم',
                'false' => 'لا',
            ],

            'loading_message' => 'جاري التحميل...',

            'max_items_message' => 'يمكن تحديد عنصر واحد فقط.|يمكن تحديد :count عناصر فقط.',

            'no_search_results_message' => 'لا توجد نتائج تطابق بحثك.',

            'placeholder' => 'حدد خياراً',

            'searching_message' => 'جاري البحث...',

            'search_prompt' => 'ابدأ الكتابة للبحث...',

        ],

        'tags_input' => [
            'placeholder' => 'علامة جديدة',
        ],

        'text_input' => [

            'actions' => [

                'hide_password' => [
                    'label' => 'إخفاء كلمة المرور',
                ],

                'show_password' => [
                    'label' => 'إظهار كلمة المرور',
                ],

            ],

        ],

        'toggle_buttons' => [

            'boolean' => [
                'true' => 'نعم',
                'false' => 'لا',
            ],

        ],

        'wizard' => [

            'actions' => [

                'next_step' => [
                    'label' => 'التالي',
                ],

                'previous_step' => [
                    'label' => 'السابق',
                ],

            ],

        ],

        'file_upload' => [

            'editor' => [

                'actions' => [

                    'cancel' => [
                        'label' => 'إلغاء',
                    ],

                    'drag_crop' => [
                        'label' => 'وضع السحب "قص"',
                    ],

                    'drag_move' => [
                        'label' => 'وضع السحب "نقل"',
                    ],

                    'flip_horizontal' => [
                        'label' => 'قلب الصورة أفقياً',
                    ],

                    'flip_vertical' => [
                        'label' => 'قلب الصورة عمودياً',
                    ],

                    'move_down' => [
                        'label' => 'نقل الصورة للأسفل',
                    ],

                    'move_left' => [
                        'label' => 'نقل الصورة لليسار',
                    ],

                    'move_right' => [
                        'label' => 'نقل الصورة لليمين',
                    ],

                    'move_up' => [
                        'label' => 'نقل الصورة للأعلى',
                    ],

                    'reset' => [
                        'label' => 'إعادة تعيين',
                    ],

                    'rotate_left' => [
                        'label' => 'تدوير الصورة لليسار',
                    ],

                    'rotate_right' => [
                        'label' => 'تدوير الصورة لليمين',
                    ],

                    'set_aspect_ratio' => [
                        'label' => 'تعيين نسبة العرض إلى الارتفاع إلى :ratio',
                    ],

                    'save' => [
                        'label' => 'حفظ',
                    ],

                    'zoom_100' => [
                        'label' => 'تكبير الصورة إلى 100%',
                    ],

                    'zoom_in' => [
                        'label' => 'تكبير',
                    ],

                    'zoom_out' => [
                        'label' => 'تصغير',
                    ],

                ],

                'fields' => [

                    'height' => [
                        'label' => 'الارتفاع',
                        'unit' => 'بكسل',
                    ],

                    'rotation' => [
                        'label' => 'الدوران',
                        'unit' => 'درجة',
                    ],

                    'width' => [
                        'label' => 'العرض',
                        'unit' => 'بكسل',
                    ],

                    'x_position' => [
                        'label' => 'X',
                        'unit' => 'بكسل',
                    ],

                    'y_position' => [
                        'label' => 'Y',
                        'unit' => 'بكسل',
                    ],

                ],

                'aspect_ratios' => [

                    'label' => 'نسب العرض إلى الارتفاع',

                    'no_fixed' => [
                        'label' => 'حر',
                    ],

                ],

                'svg' => [

                    'messages' => [
                        'confirmation' => 'لا يُنصح بتعديل ملفات SVG لأنه قد يؤدي إلى فقدان الجودة عند التحجيم.\n هل أنت متأكد أنك تريد المتابعة؟',
                        'disabled' => 'تم تعطيل تعديل ملفات SVG لأنه قد يؤدي إلى فقدان الجودة عند التحجيم.',
                    ],

                ],

            ],

        ],

    ],

    'actions' => [

        'clear' => [
            'label' => 'مسح',
        ],

        'add' => [
            'label' => 'إضافة إلى :label',
        ],

        'add_between' => [
            'label' => 'إدراج',
        ],

        'collapse' => [
            'label' => 'طي',
        ],

        'collapse_all' => [
            'label' => 'طي الكل',
        ],

        'expand' => [
            'label' => 'توسيع',
        ],

        'expand_all' => [
            'label' => 'توسيع الكل',
        ],

        'move_down' => [
            'label' => 'نقل للأسفل',
        ],

        'move_up' => [
            'label' => 'نقل للأعلى',
        ],

        'reorder' => [
            'label' => 'إعادة ترتيب',
        ],

    ],

    'notifications' => [

        'max_items' => [
            'title' => 'تم الوصول للحد الأقصى',
            'body' => 'يمكن أن يكون لديك عنصر واحد فقط.|يمكن أن يكون لديك :count عناصر فقط.',
        ],

    ],

];

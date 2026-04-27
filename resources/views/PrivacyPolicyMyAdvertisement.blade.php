<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - سياسة الخصوصية</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .paper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px 0;
        }

        .language-switch {
            text-align: center;
            margin-bottom: 20px;
        }

        .language-switch button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .language-switch button:hover {
            background-color: #2980b9;
        }

        .language-switch button.active {
            background-color: #2980b9;
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        h2 {
            color: #34495e;
            margin-bottom: 15px;
            font-size: 1.5em;
            padding-right: 10px;
            padding-left: 10px;
        }

        .ar h2 {
            border-right: 4px solid #3498db;
        }

        .en h2 {
            border-left: 4px solid #3498db;
        }

        ul {
            list-style-type: none;
            padding-right: 20px;
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
            position: relative;
        }

        ul li:before {
            content: "•";
            color: #3498db;
            font-weight: bold;
            display: inline-block;
            width: 1em;
        }

        .ar ul li:before {
            margin-right: -1em;
        }

        .en ul li:before {
            margin-left: -1em;
        }

        .contact {
            background-color: #f1f8ff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #cce5ff;
        }

        .delete-guide {
            background-color: #fff3f3;
            padding: 15px;
            margin-top: 15px;
            border-radius: 6px;
            border: 1px solid #ffcdd2;
        }

        .button-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .button-link:hover {
            background-color: #c0392b;
        }

        .email {
            color: #3498db;
            text-decoration: none;
        }

        .email:hover {
            text-decoration: underline;
        }

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        .ar {
            direction: rtl;
            text-align: right;
        }

        .en {
            direction: ltr;
            text-align: left;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .paper {
                padding: 15px;
            }

            h1 {
                font-size: 1.5em;
            }

            h2 {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="language-switch">
            <button onclick="switchLanguage('ar')" id="ar-btn">العربية</button>
            <button onclick="switchLanguage('en')" id="en-btn">English</button>
        </div>

        <div class="paper">
            <!-- Arabic Content -->
            <div id="ar-content" class="content ar active">
                <h1>سياسة الخصوصية</h1>

                <div class="section">
                    <h2>مقدمة</h2>
                    <p>نحن نلتزم بحماية خصوصية مستخدمي تطبيقنا. تشرح هذه السياسة كيفية جمع واستخدام وحماية معلوماتك الشخصية.</p>
                </div>

                <div class="section">
                    <h2>المعلومات التي نجمعها</h2>
                    <p>نحن نجمع فقط المعلومات الضرورية لتشغيل التطبيق وتحسين تجربة المستخدم:</p>
                    <ul>
                        <li>البريد الإلكتروني</li>
                        <li>رقم الهاتف</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>استخدام المعلومات</h2>
                    <p>نستخدم معلوماتك لـ:</p>
                    <ul>
                        <li>تسهيل عملية تسجيل الدخول والتواصل</li>
                        <li>عرض العروض والمنتجات المناسبة</li>
                        <li>تحسين خدماتنا</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>أمن البيانات</h2>
                    <p>نحن نتخذ إجراءات أمنية صارمة لحماية معلوماتك:</p>
                    <ul>
                        <li>جميع البيانات مشفرة</li>
                        <li>نظام حماية متقدم للخوادم</li>
                        <li>مراجعة دورية لإجراءات الأمان</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>حذف الحساب</h2>
                    <p>عند طلب حذف حسابك:</p>
                    <ul>
                        <li>سيتم حذف جميع بياناتك بشكل نهائي</li>
                        <li>لا يمكن استرجاع البيانات بعد الحذف</li>
                    </ul>
                    <div class="delete-guide">
                        <p>لمعرفة كيفية حذف حسابك وفهم العملية بشكل كامل:</p>
                        <a href="{{ url('/delete/account') }}" class="button-link">دليل حذف الحساب</a>

                    </div>
                </div>

                <div class="section contact">
                    <h2>تواصل معنا</h2>
                    <p>إذا كان لديك أي استفسارات أو شكاوى، يرجى التواصل معنا:</p>
                    <p>البريد الإلكتروني: <a href="mailto:asmlahmd15@gmail.com" class="email">asmlahmd15@gmail.com</a></p>
                </div>
            </div>

            <!-- English Content -->
            <div id="en-content" class="content en">
                <h1>Privacy Policy</h1>

                <div class="section">
                    <h2>Introduction</h2>
                    <p>We are committed to protecting the privacy of our app users. This policy explains how we collect, use, and protect your personal information.</p>
                </div>

                <div class="section">
                    <h2>Information We Collect</h2>
                    <p>We only collect essential information necessary for app operation and user experience improvement:</p>
                    <ul>
                        <li>Email address</li>
                        <li>Phone number</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>Use of Information</h2>
                    <p>We use your information to:</p>
                    <ul>
                        <li>Facilitate login process and communication</li>
                        <li>Display relevant offers and products</li>
                        <li>Improve our services</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>Data Security</h2>
                    <p>We implement strict security measures to protect your information:</p>
                    <ul>
                        <li>All data is encrypted</li>
                        <li>Advanced server protection system</li>
                        <li>Regular security procedure reviews</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>Account Deletion</h2>
                    <p>When you request account deletion:</p>
                    <ul>
                        <li>All your data will be permanently deleted</li>
                        <li>Data cannot be recovered after deletion</li>
                    </ul>
                    <div class="delete-guide">
                        <p>To learn how to delete your account and understand the process fully:</p>
                        <a href="{{ url('/delete/account') }}" class="button-link">Account Deletion Guide</a>
                    </div>
                </div>

                <div class="section contact">
                    <h2>Contact Us</h2>
                    <p>If you have any questions or complaints, please contact us:</p>
                    <p>Email: <a href="mailto:asmlahmd15@gmail.com" class="email">asmlahmd15@gmail.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchLanguage(lang) {
            const arContent = document.getElementById('ar-content');
            const enContent = document.getElementById('en-content');
            const arBtn = document.getElementById('ar-btn');
            const enBtn = document.getElementById('en-btn');

            if (lang === 'ar') {
                arContent.classList.add('active');
                enContent.classList.remove('active');
                arBtn.classList.add('active');
                enBtn.classList.remove('active');
            } else {
                arContent.classList.remove('active');
                enContent.classList.add('active');
                arBtn.classList.remove('active');
                enBtn.classList.add('active');
            }
        }

        // Set initial active state
        document.getElementById('ar-btn').classList.add('active');
    </script>
</body>
</html>

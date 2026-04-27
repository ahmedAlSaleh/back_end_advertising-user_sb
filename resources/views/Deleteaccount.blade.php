<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Deletion Guide - دليل حذف البيانات</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .language-switch {
            text-align: center;
            margin-bottom: 30px;
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

        .content {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            color: #34495e;
            margin-bottom: 20px;
        }

        .image-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .image-box {
            max-width: 300px;
            text-align: center;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .image-box img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .warning {
            background-color: #ffebee;
            border-left: 4px solid #ff5252;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .ar {
            direction: rtl;
            text-align: right;
        }

        .en {
            direction: ltr;
            text-align: left;
        }

        .hidden {
            display: none;
        }

        .steps {
            margin: 20px 0;
            padding-left: 20px;
            list-style-position: inside;
        }

        .steps li {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .steps li:hover {
            background-color: #e0e0e0;
        }

        h3 {
            color: #2c3e50;
            margin: 20px 0;
            font-size: 1.2em;
        }

        .steps li {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="language-switch">
            <button onclick="switchLanguage('ar')">العربية</button>
            <button onclick="switchLanguage('en')">English</button>
        </div>

        <!-- Arabic Content -->
        <div id="ar-content" class="content ar">
            <h1>دليل حذف البيانات</h1>

            <div class="section">
                <h2>حذف الحساب</h2>
                <h3>خطوات حذف الحساب:</h3>
                <ol class="steps">
                    <li>افتح التطبيق واذهب إلى الصفحة الرئيسية</li>
                    <li>اضغط على أيقونة الإعدادات (Settings)</li>
                    <li>قم بالتمرير لأسفل حتى تجد خيار "حذف الحساب" (Delete Account)</li>
                    <li>اضغط على زر حذف الحساب</li>
                    <li>ستظهر رسالة تأكيد، اضغط على "نعم، حذف" (Yes, Delete) للتأكيد</li>
                </ol>

                <p>عند اختيار حذف حسابك، سيتم اتخاذ الإجراءات التالية:</p>
                <ul class="steps">
                    <li>حذف جميع بياناتك الشخصية بشكل نهائي</li>
                    <li>إزالة جميع المعلومات المرتبطة بحسابك</li>
                    <li>لا يمكن استعادة البيانات بعد الحذف</li>
                </ul>

                <div class="warning">
                    <strong>تنبيه هام:</strong> عملية حذف الحساب لا يمكن التراجع عنها. يرجى التأكد من حفظ أي معلومات مهمة قبل الحذف.
                </div>

                <div class="image-container">
                    <div class="image-box">
                        <img src="{{ asset('images/delete.png') }}"alt="خطوات حذف الحساب">
                        <p>شاشة تأكيد حذف الحساب</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>تسجيل الخروج</h2>
                <p>عند تسجيل الخروج من التطبيق:</p>
                <ul class="steps">
                    <li>يتم حفظ جميع بياناتك بأمان</li>
                    <li>يمكنك تسجيل الدخول مرة أخرى في أي وقت</li>
                    <li>لن يتم حذف أي من بياناتك</li>
                </ul>

                <div class="image-container">
                    <div class="image-box">
                        <img src="{{ asset('images/PrivacyPolicy.png') }}"alt="شاشة تسجيل الخروج">
                        <p>شاشة تأكيد تسجيل الخروج</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- English Content -->
        <div id="en-content" class="content en hidden">
            <h1>Data Deletion Guide</h1>

            <div class="section">
                <h2>Account Deletion</h2>
                <h3>How to Delete Your Account:</h3>
                <ol class="steps">
                    <li>Open the app and go to the Home page</li>
                    <li>Click on the Settings icon</li>
                    <li>Scroll down until you find "Delete Account" option</li>
                    <li>Click on the Delete Account button</li>
                    <li>A confirmation message will appear, click "Yes, Delete" to confirm</li>
                </ol>

                <p>When you choose to delete your account, the following actions will be taken:</p>
                <ul class="steps">
                    <li>Permanent deletion of all your personal data</li>
                    <li>Removal of all information associated with your account</li>
                    <li>Data cannot be recovered after deletion</li>
                </ul>

                <div class="warning">
                    <strong>Important Notice:</strong> Account deletion is irreversible. Please ensure you have saved any important information before proceeding.
                </div>

                <div class="image-container">
                    <div class="image-box">
                        <img src="{{ asset('images/delete.png') }}" alt="Account deletion steps">
                        <p>Account Deletion Confirmation Screen</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Logout</h2>
                <p>When you log out from the application:</p>
                <ul class="steps">
                    <li>All your data remains safely stored</li>
                    <li>You can log back in at any time</li>
                    <li>None of your data will be deleted</li>
                </ul>

                <div class="image-container">
                    <div class="image-box">
                        <img src="{{ asset('images/PrivacyPolicy.png') }}" alt="Logout screen">
                        <p>Logout Confirmation Screen</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       function switchLanguage(lang) {
    const arContent = document.getElementById('ar-content');
    const enContent = document.getElementById('en-content');

    if (lang === 'ar') {
        arContent.style.display = 'block'; // Show Arabic content
        enContent.style.display = 'none'; // Hide English content
    } else {
        arContent.style.display = 'none'; // Hide Arabic content
        enContent.style.display = 'block'; // Show English content
    }
}
    </script>
</body>
</html>

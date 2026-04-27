# دليل تشغيل السيرفر والمشروع

## 🚀 الخطوات الأساسية لتشغيل المشروع

### الخطوة 1: تشغيل السيرفر
```bash
php artisan serve
```

**النتيجة المتوقعة:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

**ملاحظة:** السيرفر سيعمل على المنفذ 8000

---

### الخطوة 2: الدخول إلى لوحة التحكم (Filament Dashboard)

افتح المتصفح واذهب إلى:
```
http://localhost:8000/admin
```

**بيانات تسجيل الدخول:**

**الحساب الأول:**
- البريد الإلكتروني: `farrell.toy@example.net`
- كلمة المرور: `password`

**الحساب الثاني:**
- البريد الإلكتروني: `susana.ferry@example.net`
- كلمة المرور: `password`

**الحساب الثالث:**
- البريد الإلكتروني: `tomasa40@example.org`
- كلمة المرور: `password`

---

### الخطوة 3: روابط مهمة

#### لوحة التحكم (Admin Panel):
```
http://localhost:8000/admin
```

#### API Base URL (للجوال):
```
http://localhost:8000/api
```

#### الصفحة الرئيسية:
```
http://localhost:8000
```

---

## 📱 اختبار APIs للجوال

### 1. اختبار بسيط (Get Categories):
```bash
curl http://localhost:8000/api/categories
```

أو افتح في المتصفح:
```
http://localhost:8000/api/categories
```

### 2. اختبار التسجيل (User Register):
```bash
curl -X POST http://localhost:8000/api/user/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "phone": "07701234567",
    "password": "password123"
  }'
```

### 3. اختبار تسجيل الدخول:
```bash
curl -X POST http://localhost:8000/api/user/login \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "07701234567",
    "password": "password123"
  }'
```

---

## 🔧 أوامر مساعدة قبل التشغيل

إذا واجهت أي مشاكل، قم بتشغيل هذه الأوامر أولاً:

### مسح الكاش:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### التحقق من قاعدة البيانات:
```bash
php artisan migrate:status
```

### إعادة إنشاء البيانات (إذا لزم الأمر):
```bash
php artisan migrate:fresh --seed
```

---

## 🌐 استخدام IP الخاص (للجوال على نفس الشبكة)

إذا كنت تريد اختبار من الجوال على نفس الشبكة:

### 1. احصل على IP الخاص بجهازك:
**Windows:**
```bash
ipconfig
```
ابحث عن IPv4 Address (مثال: 192.168.1.100)

### 2. شغل السيرفر على جميع العناوين:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### 3. استخدم IP في الجوال:
```
http://192.168.1.100:8000/api
```

---

## 📊 التحقق من أن كل شيء يعمل

### 1. افتح لوحة التحكم:
```
http://localhost:8000/admin
```
سجل دخول بإحدى الحسابات أعلاه

### 2. تحقق من البيانات:
- **Dashboard:** يجب أن ترى إحصائيات
- **Users:** يجب أن ترى 20 مستخدم
- **Traders:** يجب أن ترى 29 تاجر
- **Advertisements:** يجب أن ترى 80 إعلان
- **Categories:** يجب أن ترى 6 فئات

### 3. اختبر API:
افتح في المتصفح:
```
http://localhost:8000/api/categories
```

يجب أن ترى response بصيغة JSON يحتوي على الفئات

---

## ⚙️ إعدادات متقدمة (اختياري)

### تشغيل Queue Worker (للإشعارات والمهام):
```bash
php artisan queue:work
```

### تشغيل Scheduler (للمهام المجدولة):
```bash
php artisan schedule:work
```

---

## 🚨 حل المشاكل الشائعة

### المشكلة: "Port already in use"
**الحل:** غير المنفذ
```bash
php artisan serve --port=8001
```

### المشكلة: "Connection refused" من الجوال
**الحل:**
1. تأكد من أن السيرفر يعمل
2. تأكد من استخدام `--host=0.0.0.0`
3. تأكد من أن Firewall لا يحجب المنفذ 8000

### المشكلة: لا يمكن الدخول للوحة التحكم
**الحل:**
1. تأكد من أن السيرفر يعمل
2. امسح الكاش: `php artisan config:clear`
3. تأكد من الرابط: `http://localhost:8000/admin`

---

## 📱 إعدادات تطبيق الجوال

في تطبيق الجوال، استخدم:

### للتطوير على نفس الجهاز:
```
Base URL: http://localhost:8000/api
```

### للتطوير من جهاز آخر على نفس الشبكة:
```
Base URL: http://192.168.1.100:8000/api
```
(استبدل 192.168.1.100 بـ IP جهازك الفعلي)

### للإنتاج (Production):
```
Base URL: https://yourdomain.com/api
```

---

## ✅ قائمة التحقق

- [ ] السيرفر يعمل (`php artisan serve`)
- [ ] يمكن الوصول للوحة التحكم (`http://localhost:8000/admin`)
- [ ] يمكن تسجيل الدخول للوحة التحكم
- [ ] البيانات موجودة في لوحة التحكم
- [ ] API يعمل (`http://localhost:8000/api/categories`)
- [ ] تطبيق الجوال متصل بالـ API

---

## 🎯 الخطوات التالية

بعد تشغيل كل شيء:

1. **اختبر لوحة التحكم:**
   - استعرض البيانات
   - جرب إضافة/تعديل/حذف
   - راجع الإحصائيات

2. **اختبر الـ APIs:**
   - استخدم Postman
   - اختبر التسجيل والدخول
   - اختبر إنشاء إعلان
   - اختبر البحث

3. **اربط تطبيق الجوال:**
   - ضع Base URL في الإعدادات
   - اختبر التسجيل والدخول
   - اختبر جميع المميزات

---

**جاهز للانطلاق! 🚀**

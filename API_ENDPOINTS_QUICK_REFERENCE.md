# API Endpoints - Quick Reference

## 🔐 Authentication APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/user/register` | ❌ | تسجيل مستخدم جديد |
| POST | `/api/user/login` | ❌ | تسجيل دخول المستخدم |
| GET | `/api/user/logout` | ✅ | تسجيل خروج المستخدم |
| POST | `/api/trader/register` | ❌ | تسجيل تاجر جديد |
| POST | `/api/trader/login` | ❌ | تسجيل دخول التاجر |
| GET | `/api/trader/logout` | ✅ | تسجيل خروج التاجر |

---

## 👤 User Profile APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/user/get/profile` | ✅ | الحصول على بيانات المستخدم |
| POST | `/api/user/update/profile` | ✅ | تحديث بيانات المستخدم |

---

## 👨‍💼 Trader Profile APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/trader/get/profile` | ✅ | الحصول على بيانات التاجر |
| POST | `/api/trader/update/profile` | ✅ | تحديث بيانات التاجر |
| POST | `/api/trader/change/password` | ✅ | تغيير كلمة المرور |

---

## 📢 Advertisement APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/ads/create` | ✅ | إنشاء إعلان جديد |
| GET | `/api/ads/mine` | ✅ | الحصول على إعلانات التاجر |
| POST | `/api/ads/delete/{id}` | ✅ | حذف إعلان |
| POST | `/api/user/get_ads` | ✅ | الحصول على الإعلانات (مستخدم مسجل) |
| POST | `/api/user/guest/get_ads` | ❌ | الحصول على الإعلانات (زائر) |
| PUT | `/api/trader/ads/{id}/status` | ✅ | تحديث حالة الإعلان |
| GET | `/api/trader/ads/scheduled` | ✅ | الحصول على الإعلانات المجدولة |
| GET | `/api/trader/ads/expired` | ✅ | الحصول على الإعلانات المنتهية |
| POST | `/api/trader/ads/{id}/renew` | ✅ | تجديد إعلان |
| GET | `/api/ads/featured` | ❌ | الحصول على الإعلانات المميزة |
| GET | `/api/user/getStore_Ads/{id}` | ❌ | الحصول على إعلانات متجر معين |
| GET | `/api/user/getStore_pyAdv/{id}` | ❌ | الحصول على المتجر من خلال الإعلان |

---

## 📝 Post APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/posts/create` | ✅ | إنشاء منشور جديد |
| GET | `/api/posts/mine` | ✅ | الحصول على منشورات التاجر |
| POST | `/api/posts/delete/{id}` | ✅ | حذف منشور |
| GET | `/api/user/get_posts` | ❌ | الحصول على جميع المنشورات |
| POST | `/api/post/like/{id}` | ✅ | إعجاب بمنشور |
| POST | `/api/post/dislike/{id}` | ✅ | عدم إعجاب بمنشور |
| GET | `/api/user/getStore_Post/{id}` | ❌ | الحصول على منشورات متجر معين |

---

## 🏪 Store APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/user/getStore_byCat/{id}` | ✅ | الحصول على المتاجر حسب الفئة |
| GET | `/api/user/guest/getStore_byCat/{id}` | ❌ | الحصول على المتاجر حسب الفئة (زائر) |
| GET | `/api/user/show_store/{id}` | ✅ | عرض تفاصيل المتجر |
| GET | `/api/user/guest/show_store/{id}` | ❌ | عرض تفاصيل المتجر (زائر) |
| POST | `/api/user/search/store` | ✅ | البحث عن المتاجر |
| POST | `/api/user/guest/search/store` | ❌ | البحث عن المتاجر (زائر) |
| GET | `/api/trader/store/hours` | ✅ | الحصول على ساعات عمل المتجر |
| POST | `/api/trader/store/hours` | ✅ | تحديث ساعات عمل المتجر |

---

## 📂 Category APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/categories` | ❌ | الحصول على جميع الفئات والفئات الفرعية |

---

## ⭐ Favorite APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/user/add_to_favorite/{id}` | ✅ | إضافة/إزالة إعلان من المفضلة |
| GET | `/api/user/add_store_to_favorite/{id}` | ✅ | إضافة/إزالة متجر من المفضلة |
| GET | `/api/user/favoriteAdv` | ✅ | عرض الإعلانات المفضلة |
| GET | `/api/user/favoriteStores` | ✅ | عرض المتاجر المفضلة |

---

## 🚫 Block APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/user/block/store/{id}` | ✅ | حظر/إلغاء حظر متجر |
| GET | `/api/user/blocked/stores` | ✅ | الحصول على المتاجر المحظورة |

---

## ⭐ Rating APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/user/rate` | ✅ | تقييم متجر أو تاجر |
| GET | `/api/user/rate/{id}` | ❌ | الحصول على تقييمات متجر |

---

## 🔍 Search APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/user/search?q={query}` | ✅ | البحث العام |
| GET | `/api/user/guest/search?q={query}` | ❌ | البحث العام (زائر) |
| POST | `/api/search/advanced` | ❌ | البحث المتقدم |

---

## 💰 Wallet & Points APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/get/wallet` | ✅ | الحصول على المحفظة والنقاط |
| GET | `/api/get/point` | ✅ | الحصول على النقاط فقط |
| POST | `/api/RechargeByCode` | ✅ | شحن النقاط بالكود |

---

## 📊 Analytics APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/trader/analytics/overview` | ✅ | نظرة عامة على الإحصائيات |
| GET | `/api/trader/analytics/ads` | ✅ | إحصائيات الإعلانات |
| GET | `/api/trader/analytics/chart?period={period}` | ✅ | بيانات الرسم البياني |

---

## 🎯 Promotion APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/promotion-packages` | ❌ | الحصول على باقات الترويج |
| POST | `/api/trader/ads/{id}/promote` | ✅ | ترويج إعلان |

---

## 🚨 Report APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/reports/reasons` | ❌ | الحصول على أسباب الإبلاغ |
| POST | `/api/reports` | ✅ | إرسال بلاغ |
| GET | `/api/user/reports` | ✅ | الحصول على بلاغاتي |

---

## 🛠️ Support & Utility APIs

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/support` | ❌ | الحصول على معلومات الدعم |
| GET | `/api/version` | ❌ | الحصول على إصدار التطبيق |
| POST | `/api/update/version` | ✅ | تحديث إصدار التطبيق (Admin) |
| GET | `/api/cities` | ❌ | الحصول على قائمة المدن العراقية |

---

## Legend

- ✅ = Authentication Required
- ❌ = No Authentication Required
- `{id}` = Dynamic parameter (replace with actual ID)
- `{query}` = Search query string
- `{period}` = Time period (week/month/year)

---

## Total Endpoints: 78

### By Category:
- **Authentication:** 6 endpoints
- **User Profile:** 2 endpoints
- **Trader Profile:** 3 endpoints
- **Advertisements:** 12 endpoints
- **Posts:** 7 endpoints
- **Stores:** 8 endpoints
- **Categories:** 1 endpoint
- **Favorites:** 4 endpoints
- **Blocks:** 2 endpoints
- **Ratings:** 2 endpoints
- **Search:** 3 endpoints
- **Wallet & Points:** 3 endpoints
- **Analytics:** 3 endpoints
- **Promotions:** 2 endpoints
- **Reports:** 3 endpoints
- **Support & Utility:** 4 endpoints

### By Authentication:
- **Public (No Auth):** 28 endpoints
- **Protected (Auth Required):** 50 endpoints

---

**Last Updated:** December 10, 2024

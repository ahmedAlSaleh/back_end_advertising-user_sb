# API Documentation Guide

## ✅ Scribe API Documentation Successfully Generated!

Your comprehensive API documentation with Postman Collection has been created and is ready to use.

---

## 📍 Access Points

### 1. Interactive Documentation Page
**URL:** `http://127.0.0.1:8000/docs`

This provides a complete, interactive HTML documentation where you can:
- Browse all API endpoints organized by category
- See request/response examples
- View required headers and authentication
- Try out endpoints directly in the browser (if enabled)

### 2. Postman Collection
**Location:** `storage/app/scribe/collection.json`

Import this file into Postman to get:
- All endpoints pre-configured
- Request examples with proper headers
- Authentication setup
- Organized into logical folders by category

### 3. OpenAPI Specification
**Location:** `storage/app/scribe/openapi.yaml`

Standard OpenAPI 3.0 specification that can be used with:
- Swagger UI
- Postman
- Other API documentation tools

---

## 📚 Documentation Features

### Organized Groups
All endpoints are organized into the following categories:

1. **Authentication**
   - User registration and login
   - Trader registration and login
   - Logout endpoints

2. **User Management**
   - Profile updates
   - Get profile
   - Cities list

3. **Trader Management**
   - Trader profile management
   - Password change
   - Get trader profile

4. **Advertisement Management**
   - Create, view, delete ads
   - Ad scheduling (draft, scheduled, active, expired)
   - Promote ads
   - Renew expired ads

5. **Store Management**
   - Store hours management
   - Store details
   - Store operations

6. **Post Management**
   - Create and manage posts
   - Like/dislike posts

7. **Financial & Wallet**
   - Get wallet balance
   - Recharge by code
   - Points management

8. **Search & Analytics**
   - Advanced search
   - Store search
   - Analytics overview
   - Ad analytics

9. **Interactions (Favorites, Likes, Blocks)**
   - Add to favorites
   - Block stores
   - View blocked stores

10. **Reviews & Ratings**
    - Add ratings
    - View ratings

11. **Reports**
    - Submit reports
    - View report reasons
    - User reports

12. **Category Management**
    - Get categories
    - Store by category

---

## 🔑 Authentication

The API uses **Laravel Sanctum** with Bearer token authentication.

### Headers Required:
```
Authorization: Bearer {YOUR_AUTH_TOKEN}
Accept: application/json
Content-Type: application/json
```

### Getting a Token:
1. Register or login through `/api/user/register` or `/api/user/login`
2. Use the returned token in the `Authorization` header
3. Format: `Bearer 1|abc123tokenxyz`

---

## 📊 Documentation Status

### Fully Documented Controllers (with detailed annotations):
- ✅ User/AuthController (Register, Login, Logout, Update Profile, Get Profile, Get Cities)
- ✅ Trader/AuthController (Register, Login, Logout, Update Profile, Change Password, Get Profile)

### Auto-Documented Controllers (extracted from routes & validation):
- ✅ Trader/AdsController (Create, View, Delete ads)
- ✅ Trader/PostController (Create, View, Delete posts)
- ✅ Trader/PointController (Wallet operations)
- ✅ Trader/StoreHoursController (Store hours management)
- ✅ User/UserOperationController (User operations)
- ✅ SearchController (Search functionality)
- ✅ PromotionController (Promotions)
- ✅ ReportController (Reporting system)
- ✅ TraderAnalyticsController (Analytics)

### Total Endpoints Documented: 66+

---

## 🚀 How to Use

### 1. View Documentation in Browser
1. Start your Laravel server: `php artisan serve`
2. Open browser: `http://127.0.0.1:8000/docs`
3. Browse through endpoints organized by groups

### 2. Import to Postman
1. Open Postman
2. Click **Import**
3. Select file: `storage/app/scribe/collection.json`
4. All endpoints will be imported with examples

### 3. Update Documentation
After making changes to controllers:
```bash
php artisan scribe:generate
```

This will regenerate the documentation with your latest changes.

---

## 📝 Adding More Documentation

To enhance documentation for specific endpoints, add PHPDoc comments to controller methods:

```php
/**
 * @group Group Name
 *
 * Brief description of the endpoint.
 *
 * Detailed explanation here.
 *
 * @authenticated
 *
 * @bodyParam field_name type required Description. Example: value
 * @bodyParam another_field string optional Description. Example: value
 *
 * @queryParam page integer optional Page number for pagination. Example: 1
 *
 * @response 200 {
 *   "status": true,
 *   "data": {}
 * }
 *
 * @response 401 {
 *   "status": false,
 *   "message": "Unauthenticated"
 * }
 */
public function methodName(Request $request)
{
    // method code
}
```

### Available Annotations:
- `@group` - Organize endpoints into categories
- `@authenticated` - Endpoint requires authentication
- `@unauthenticated` - Endpoint is public
- `@bodyParam` - Request body parameters
- `@queryParam` - URL query parameters
- `@urlParam` - URL path parameters
- `@response` - Example responses with status codes

---

## 🔧 Configuration

Documentation configuration is in: `config/scribe.php`

### Current Settings:
- **Title:** Advertising Platform API Documentation
- **Description:** Comprehensive API for managing advertisements, stores, traders, and user interactions
- **Auth:** Bearer token (Laravel Sanctum)
- **Base URL:** Configured from `APP_URL`
- **Type:** Laravel (Blade views)
- **Postman:** Enabled
- **OpenAPI:** Enabled
- **Try It Out:** Enabled (test endpoints in browser)

### Group Order:
Groups appear in documentation in this order:
1. Authentication
2. User Management
3. Trader Management
4. Store Management
5. Advertisement Management
6. Post Management
7. Category Management
8. Financial & Wallet
9. Reviews & Ratings
10. Interactions (Favorites, Likes, Blocks)
11. Reports
12. Search & Analytics
13. Notifications
14. Settings

---

## 📦 Files Generated

### Documentation Files:
- `resources/views/scribe/` - Blade documentation views
- `public/vendor/scribe/` - CSS/JS assets
- `.scribe/` - Markdown source files

### Export Files:
- `storage/app/scribe/collection.json` - Postman Collection (v2.1.0)
- `storage/app/scribe/openapi.yaml` - OpenAPI Specification (v3.0.1)

---

## 🎯 Next Steps

### To Further Enhance Documentation:

1. **Add More Detailed Annotations**
   - Add `@bodyParam` annotations to all controllers
   - Add example request/response bodies
   - Add error response examples

2. **Add Response Calls**
   - Scribe can make actual API calls to generate real responses
   - Configure in `config/scribe.php` under `response_calls`

3. **Add Custom Logo**
   - Place logo in `public/img/`
   - Update `config/scribe.php`: `'logo' => 'img/logo.png'`

4. **Customize Styling**
   - Modify theme in `config/scribe.php`
   - Custom CSS can be added

5. **Add Intro Text**
   - Edit `.scribe/intro.md` for custom introduction
   - Edit `.scribe/auth.md` for authentication guide

---

## ✨ Features Included

### Postman Collection Includes:
- ✅ All API endpoints organized by category
- ✅ Request body examples
- ✅ Required headers pre-configured
- ✅ Bearer token authentication setup
- ✅ Query parameter examples
- ✅ Descriptions for each endpoint

### Documentation Page Includes:
- ✅ Interactive endpoint browser
- ✅ Code examples in multiple languages (Bash, JavaScript)
- ✅ Authentication instructions
- ✅ Request/response examples
- ✅ Parameter descriptions with examples
- ✅ Error response examples
- ✅ Try It Out feature (test endpoints directly)

---

## 🔄 Regenerating Documentation

Whenever you update controllers or add new endpoints:

```bash
# Regenerate documentation
php artisan scribe:generate

# Clear cache if needed
php artisan config:clear
php artisan route:clear
```

---

## 📞 Support

For more information about Scribe:
- Documentation: https://scribe.knuckles.wtf/laravel
- GitHub: https://github.com/knuckleswtf/scribe

---

*Generated: December 7, 2025*
*Documentation Status: Production Ready*
*Total Endpoints: 66+*
*Postman Collection: v2.1.0*
*OpenAPI Spec: v3.0.1*

# API Documentation - Quick Start Guide

## 📚 Available Documentation Files

This project includes comprehensive API documentation in multiple formats:

### 1. **API_DOCUMENTATION.md** (Main Documentation)
Complete API documentation with:
- Detailed endpoint descriptions
- Request/Response examples
- Error handling
- Authentication requirements
- Best practices

### 2. **API_ENDPOINTS_QUICK_REFERENCE.md** (Quick Reference)
Quick lookup table with:
- All 78 endpoints organized by category
- HTTP methods
- Authentication status
- Brief descriptions in Arabic

### 3. **Advertising_Platform_API.postman_collection.json** (Postman Collection)
Ready-to-use Postman collection with:
- Pre-configured requests
- Environment variables
- Sample data
- Import directly into Postman

### 4. **API_DOCUMENTATION_GUIDE.md** (Developer Guide)
Additional developer resources and guidelines

---

## 🚀 Quick Start

### Using Postman Collection

1. **Import Collection:**
   - Open Postman
   - Click "Import" button
   - Select `Advertising_Platform_API.postman_collection.json`

2. **Set Environment Variables:**
   ```
   base_url: http://localhost:8000/api
   token: (leave empty, will be set after login)
   ```

3. **Test Authentication:**
   - Use "User Register" or "Trader Register" to create an account
   - Use "User Login" or "Trader Login" to get token
   - Copy the token from response
   - Set it in environment variable `token`

4. **Start Testing:**
   - All authenticated endpoints will now work with the token
   - Explore different categories and endpoints

---

## 📊 API Statistics

- **Total Endpoints:** 78
- **Public Endpoints:** 28 (no authentication)
- **Protected Endpoints:** 50 (authentication required)

### Endpoints by Category:
- Authentication: 6
- User Profile: 2
- Trader Profile: 3
- Advertisements: 12
- Posts: 7
- Stores: 8
- Categories: 1
- Favorites: 4
- Blocks: 2
- Ratings: 2
- Search: 3
- Wallet & Points: 3
- Analytics: 3
- Promotions: 2
- Reports: 3
- Support & Utility: 4

---

## 🔑 Authentication Flow

### For Users:
```
1. POST /api/user/register
   → Get token

2. Use token in subsequent requests:
   Authorization: Bearer {token}

3. GET /api/user/logout (when done)
```

### For Traders:
```
1. POST /api/trader/register
   → Get token

2. Use token in subsequent requests:
   Authorization: Bearer {token}

3. GET /api/trader/logout (when done)
```

---

## 📝 Common Request Examples

### Register a User
```bash
curl -X POST http://localhost:8000/api/user/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Ahmed Mohammed",
    "phone": "07701234567",
    "email": "ahmed@example.com",
    "password": "password123"
  }'
```

### Login
```bash
curl -X POST http://localhost:8000/api/user/login \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "07701234567",
    "password": "password123"
  }'
```

### Get Categories (No Auth)
```bash
curl http://localhost:8000/api/categories
```

### Create Advertisement (Auth Required)
```bash
curl -X POST http://localhost:8000/api/ads/create \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=iPhone 13 Pro Max" \
  -F "description=هاتف ايفون مستعمل نظيف" \
  -F "price=350000" \
  -F "category_id=1" \
  -F "sub_category_id=2"
```

---

## 🔍 Finding Endpoints

### By Feature:
1. **User Management:** See "User APIs" section
2. **Store Management:** See "Store APIs" section
3. **Product Listings:** See "Advertisement APIs" section
4. **Social Features:** See "Post APIs", "Favorite APIs"
5. **Business Analytics:** See "Analytics APIs" section
6. **Monetization:** See "Promotion APIs", "Wallet & Points APIs"

### By Authentication:
- **Public (No Auth):** Check Quick Reference for ❌ marked endpoints
- **Protected (Auth Required):** Check Quick Reference for ✅ marked endpoints

---

## 🛠️ Development Tools

### Recommended Postman Setup

1. **Create Environment:**
   ```json
   {
     "base_url": "http://localhost:8000/api",
     "token": "",
     "user_id": "",
     "trader_id": "",
     "test_ad_id": "",
     "test_store_id": ""
   }
   ```

2. **Use Variables:**
   ```
   {{base_url}}/categories
   Authorization: Bearer {{token}}
   ```

3. **Save Test Data:**
   - After creating test data, save IDs to environment variables
   - Reuse them for subsequent tests

---

## 📖 Response Format

### Success Response:
```json
{
  "status": true,
  "message": "Operation successful",
  "data": {
    // Response data here
  }
}
```

### Error Response:
```json
{
  "status": false,
  "message": "Error message",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

---

## 🎯 Testing Workflow

### 1. Setup Phase:
```
1. Register User/Trader
2. Login and get token
3. Get categories list
4. Get cities list
```

### 2. User Flow:
```
1. Browse advertisements
2. Search for products
3. View store details
4. Add to favorites
5. Rate stores
6. Submit reports
```

### 3. Trader Flow:
```
1. Update profile
2. Create advertisements
3. Create posts
4. Manage store hours
5. View analytics
6. Promote advertisements
7. Recharge points
```

---

## 🚨 Common Issues

### 401 Unauthorized
**Cause:** Missing or invalid token
**Solution:** Ensure you're logged in and using correct token

### 422 Validation Error
**Cause:** Invalid request data
**Solution:** Check required fields and data types

### 404 Not Found
**Cause:** Resource doesn't exist
**Solution:** Verify ID exists in database

---

## 📞 Support

For API questions or issues:
- **Documentation:** See [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)
- **Quick Reference:** See [API_ENDPOINTS_QUICK_REFERENCE.md](./API_ENDPOINTS_QUICK_REFERENCE.md)
- **Email:** support@example.com

---

## 🔄 Updates

**Last Updated:** December 10, 2024
**API Version:** 1.0.0

To regenerate this documentation:
```bash
php artisan route:list --json > routes.json
# Then use the documentation generator
```

---

## 📄 License

This API documentation is part of the Advertising Platform project.

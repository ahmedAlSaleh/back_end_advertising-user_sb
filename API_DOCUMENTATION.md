# API Documentation - Advertising Platform

## Base URL
```
http://localhost:8000/api
```

## Authentication
Most endpoints require authentication using Laravel Sanctum. Include the bearer token in the Authorization header:
```
Authorization: Bearer {your_token_here}
```

---

## Table of Contents
1. [Authentication APIs](#authentication-apis)
2. [User APIs](#user-apis)
3. [Trader APIs](#trader-apis)
4. [Store APIs](#store-apis)
5. [Advertisement APIs](#advertisement-apis)
6. [Post APIs](#post-apis)
7. [Category APIs](#category-apis)
8. [Analytics APIs](#analytics-apis)
9. [Promotion APIs](#promotion-apis)
10. [Report APIs](#report-apis)
11. [Search APIs](#search-apis)
12. [Support & Version APIs](#support--version-apis)

---

## Authentication APIs

### 1. User Registration
**Endpoint:** `POST /api/user/register`
**Authentication:** Not Required

**Request Body:**
```json
{
  "name": "Ahmed Mohammed",
  "phone": "07701234567",
  "email": "ahmed@example.com",
  "password": "password123",
  "fcm_token": "fcm_token_here"
}
```

**Response (201):**
```json
{
  "status": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "Ahmed Mohammed",
      "phone": "07701234567",
      "email": "ahmed@example.com"
    },
    "token": "1|abc123tokenxyz"
  }
}
```

**Error Response (422):**
```json
{
  "status": false,
  "message": "Validation errors",
  "errors": {
    "phone": ["The phone has already been taken."]
  }
}
```

---

### 2. User Login
**Endpoint:** `POST /api/user/login`
**Authentication:** Not Required

**Request Body:**
```json
{
  "phone": "07701234567",
  "password": "password123",
  "fcm_token": "fcm_token_here"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Ahmed Mohammed",
      "phone": "07701234567",
      "email": "ahmed@example.com"
    },
    "token": "1|abc123tokenxyz"
  }
}
```

**Error Response (401):**
```json
{
  "status": false,
  "message": "Invalid credentials"
}
```

---

### 3. User Logout
**Endpoint:** `GET /api/user/logout`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Logged out successfully"
}
```

---

### 4. Trader Registration
**Endpoint:** `POST /api/trader/register`
**Authentication:** Not Required

**Request Body:**
```json
{
  "owner_contact_number": "07701234567",
  "password": "password123",
  "city": "بغداد",
  "whatsapp_number": "07701234567",
  "telegram_number": "@trader_username",
  "social_media_link": "https://facebook.com/mystore",
  "store_description": "متجر إلكترونيات متخصص في بيع الهواتف والأجهزة الذكية",
  "fcm_token": "fcm_token_here"
}
```

**Response (201):**
```json
{
  "status": true,
  "message": "Trader registered successfully",
  "data": {
    "trader": {
      "id": 1,
      "owner_contact_number": "07701234567",
      "city": "بغداد",
      "store": {
        "id": 1,
        "store_name": "Electronics Store",
        "store_owner_name": "Ahmed"
      }
    },
    "token": "1|abc123tokenxyz"
  }
}
```

---

### 5. Trader Login
**Endpoint:** `POST /api/trader/login`
**Authentication:** Not Required

**Request Body:**
```json
{
  "phone": "07701234567",
  "password": "password123",
  "fcm_token": "fcm_token_here"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Login successful",
  "data": {
    "trader": {
      "id": 1,
      "owner_contact_number": "07701234567",
      "city": "بغداد",
      "store": {
        "id": 1,
        "store_name": "Electronics Store"
      }
    },
    "token": "1|abc123tokenxyz"
  }
}
```

---

### 6. Trader Logout
**Endpoint:** `GET /api/trader/logout`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Logged out successfully"
}
```

---

## User APIs

### 1. Get User Profile
**Endpoint:** `GET /api/user/get/profile`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "id": 1,
    "name": "Ahmed Mohammed",
    "phone": "07701234567",
    "email": "ahmed@example.com",
    "created_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

---

### 2. Update User Profile
**Endpoint:** `POST /api/user/update/profile`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "name": "Ahmed Ali",
  "email": "ahmed.ali@example.com"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 1,
    "name": "Ahmed Ali",
    "phone": "07701234567",
    "email": "ahmed.ali@example.com"
  }
}
```

---

### 3. Get Advertisements (User)
**Endpoint:** `POST /api/user/get_ads`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "category_id": 1,
  "sub_category_id": 2,
  "city": "بغداد",
  "min_price": 10000,
  "max_price": 500000,
  "type": "normal",
  "page": 1,
  "per_page": 15
}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "iPhone 13 Pro Max",
        "description": "هاتف ايفون 13 برو ماكس مستعمل نظيف جداً",
        "price": 350000,
        "type": "normal",
        "feature_type": "premium",
        "is_active": true,
        "trader": {
          "id": 1,
          "city": "بغداد",
          "store": {
            "store_name": "متجر الإلكترونيات"
          }
        },
        "category": {
          "id": 1,
          "name": "الإلكترونيات"
        },
        "sub_category": {
          "id": 2,
          "name": "الهواتف الذكية"
        }
      }
    ],
    "per_page": 15,
    "total": 50
  }
}
```

---

### 4. Get Advertisements (Guest)
**Endpoint:** `POST /api/user/guest/get_ads`
**Authentication:** Not Required

**Request Body:** Same as authenticated version

**Response:** Same structure as authenticated version

---

### 5. Search
**Endpoint:** `GET /api/user/search?q={query}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `q`: Search query string

**Response (200):**
```json
{
  "status": true,
  "data": {
    "advertisements": [
      {
        "id": 1,
        "title": "iPhone 13 Pro Max",
        "price": 350000
      }
    ],
    "posts": [
      {
        "id": 1,
        "content": "أبحث عن ايفون 13",
        "user": {
          "name": "Ahmed"
        }
      }
    ],
    "stores": [
      {
        "id": 1,
        "store_name": "متجر الإلكترونيات"
      }
    ]
  }
}
```

---

### 6. Guest Search
**Endpoint:** `GET /api/user/guest/search?q={query}`
**Authentication:** Not Required

**Response:** Same structure as authenticated search

---

### 7. Get Stores by Category
**Endpoint:** `GET /api/user/getStore_byCat/{category_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "store_name": "متجر الإلكترونيات",
      "store_owner_name": "Ahmed",
      "trader": {
        "city": "بغداد",
        "whatsapp_number": "07701234567"
      },
      "categories": [
        {
          "id": 1,
          "name": "الإلكترونيات"
        }
      ]
    }
  ]
}
```

---

### 8. Get Stores by Category (Guest)
**Endpoint:** `GET /api/user/guest/getStore_byCat/{category_id}`
**Authentication:** Not Required

**Response:** Same structure as authenticated version

---

### 9. Show Store Details
**Endpoint:** `GET /api/user/show_store/{store_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "id": 1,
    "store_name": "متجر الإلكترونيات",
    "store_owner_name": "Ahmed",
    "trader": {
      "id": 1,
      "city": "بغداد",
      "whatsapp_number": "07701234567",
      "telegram_number": "@trader",
      "social_media_link": "https://facebook.com/store"
    },
    "categories": [
      {
        "id": 1,
        "name": "الإلكترونيات"
      }
    ],
    "advertisements_count": 25,
    "posts_count": 10,
    "average_rating": 4.5,
    "total_reviews": 15
  }
}
```

---

### 10. Show Store Details (Guest)
**Endpoint:** `GET /api/user/guest/show_store/{store_id}`
**Authentication:** Not Required

**Response:** Same structure as authenticated version

---

### 11. Search Store
**Endpoint:** `POST /api/user/search/store`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "store_name": "إلكترونيات",
  "city": "بغداد",
  "category_id": 1
}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "store_name": "متجر الإلكترونيات",
      "trader": {
        "city": "بغداد"
      }
    }
  ]
}
```

---

### 12. Search Store (Guest)
**Endpoint:** `POST /api/user/guest/search/store`
**Authentication:** Not Required

**Request/Response:** Same as authenticated version

---

### 13. Toggle Favorite Advertisement
**Endpoint:** `GET /api/user/add_to_favorite/{advertisement_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Advertisement added to favorites"
}
```

**Or:**
```json
{
  "status": true,
  "message": "Advertisement removed from favorites"
}
```

---

### 14. Toggle Store Favorite
**Endpoint:** `GET /api/user/add_store_to_favorite/{store_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Store added to favorites"
}
```

---

### 15. Get Favorite Advertisements
**Endpoint:** `GET /api/user/favoriteAdv`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "price": 350000,
      "trader": {
        "store": {
          "store_name": "متجر الإلكترونيات"
        }
      }
    }
  ]
}
```

---

### 16. Get Favorite Stores
**Endpoint:** `GET /api/user/favoriteStores`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "store_name": "متجر الإلكترونيات",
      "trader": {
        "city": "بغداد"
      }
    }
  ]
}
```

---

### 17. Toggle Store Block
**Endpoint:** `GET /api/user/block/store/{store_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Store blocked successfully"
}
```

**Or:**
```json
{
  "status": true,
  "message": "Store unblocked successfully"
}
```

---

### 18. Get Blocked Stores
**Endpoint:** `GET /api/user/blocked/stores`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "store_name": "متجر الإلكترونيات",
      "blocked_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

### 19. Rate Store/Trader
**Endpoint:** `POST /api/user/rate`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "rated_id": 1,
  "rated_type": "store",
  "rate": 5,
  "comment": "خدمة ممتازة وأسعار مناسبة"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Rating submitted successfully",
  "data": {
    "id": 1,
    "rate": 5,
    "comment": "خدمة ممتازة وأسعار مناسبة",
    "user": {
      "name": "Ahmed"
    }
  }
}
```

---

### 20. Get Store Ratings
**Endpoint:** `GET /api/user/rate/{store_id}`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": {
    "average_rating": 4.5,
    "total_ratings": 15,
    "ratings": [
      {
        "id": 1,
        "rate": 5,
        "comment": "خدمة ممتازة",
        "user": {
          "name": "Ahmed"
        },
        "created_at": "2024-01-01T00:00:00.000000Z"
      }
    ]
  }
}
```

---

### 21. Get Store Posts
**Endpoint:** `GET /api/user/getStore_Post/{store_id}`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "content": "لدينا عرض خاص على الهواتف الذكية",
      "trader": {
        "store": {
          "store_name": "متجر الإلكترونيات"
        }
      },
      "likes_count": 25,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

### 22. Get Store by Advertisement
**Endpoint:** `GET /api/user/getStore_pyAdv/{advertisement_id}`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": {
    "id": 1,
    "store_name": "متجر الإلكترونيات",
    "trader": {
      "city": "بغداد",
      "whatsapp_number": "07701234567"
    }
  }
}
```

---

### 23. Get Store Advertisements
**Endpoint:** `GET /api/user/getStore_Ads/{store_id}`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "price": 350000,
      "type": "normal",
      "feature_type": "premium",
      "is_active": true
    }
  ]
}
```

---

## Trader APIs

### 1. Get Trader Profile
**Endpoint:** `GET /api/trader/get/profile`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "id": 1,
    "owner_contact_number": "07701234567",
    "city": "بغداد",
    "whatsapp_number": "07701234567",
    "telegram_number": "@trader",
    "social_media_link": "https://facebook.com/store",
    "store_description": "متجر متخصص في الإلكترونيات",
    "store": {
      "id": 1,
      "store_name": "متجر الإلكترونيات",
      "store_owner_name": "Ahmed"
    },
    "wallet": {
      "balance": 50000,
      "points": 100
    }
  }
}
```

---

### 2. Update Trader Profile
**Endpoint:** `POST /api/trader/update/profile`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
city: بغداد
whatsapp_number: 07701234567
telegram_number: @trader_new
social_media_link: https://facebook.com/mystore
store_description: متجر متخصص في بيع الإلكترونيات والأجهزة الذكية
```

**Response (200):**
```json
{
  "status": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 1,
    "city": "بغداد",
    "whatsapp_number": "07701234567",
    "telegram_number": "@trader_new",
    "social_media_link": "https://facebook.com/mystore",
    "store_description": "متجر متخصص في بيع الإلكترونيات والأجهزة الذكية"
  }
}
```

---

### 3. Change Password
**Endpoint:** `POST /api/trader/change/password`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "current_password": "oldpassword123",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Password changed successfully"
}
```

**Error Response (400):**
```json
{
  "status": false,
  "message": "Current password is incorrect"
}
```

---

### 4. Get Wallet & Points
**Endpoint:** `GET /api/get/wallet`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "balance": 50000,
    "points": 100,
    "trader_id": 1
  }
}
```

---

### 5. Get Points Only
**Endpoint:** `GET /api/get/point`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "points": 100
  }
}
```

---

### 6. Recharge Points by Code
**Endpoint:** `POST /api/RechargeByCode`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "code": "ABC123XYZ456"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Points recharged successfully",
  "data": {
    "points_added": 50,
    "new_balance": 150,
    "recharge_code": {
      "code": "ABC123XYZ456",
      "point_number": 50
    }
  }
}
```

**Error Response (404):**
```json
{
  "status": false,
  "message": "Invalid or already used recharge code"
}
```

---

## Store APIs

### 1. Get Store Hours
**Endpoint:** `GET /api/trader/store/hours`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "day": "Sunday",
      "opens_at": "09:00",
      "closes_at": "21:00",
      "is_closed": false
    },
    {
      "id": 2,
      "day": "Monday",
      "opens_at": "09:00",
      "closes_at": "21:00",
      "is_closed": false
    },
    {
      "id": 3,
      "day": "Friday",
      "opens_at": null,
      "closes_at": null,
      "is_closed": true
    }
  ]
}
```

---

### 2. Update Store Hours
**Endpoint:** `POST /api/trader/store/hours`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "hours": [
    {
      "day": "Sunday",
      "opens_at": "09:00",
      "closes_at": "21:00",
      "is_closed": false
    },
    {
      "day": "Monday",
      "opens_at": "09:00",
      "closes_at": "21:00",
      "is_closed": false
    },
    {
      "day": "Friday",
      "is_closed": true
    }
  ]
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Store hours updated successfully",
  "data": [
    {
      "day": "Sunday",
      "opens_at": "09:00",
      "closes_at": "21:00",
      "is_closed": false
    }
  ]
}
```

---

## Advertisement APIs

### 1. Create Advertisement
**Endpoint:** `POST /api/ads/create`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
title: iPhone 13 Pro Max
description: هاتف ايفون 13 برو ماكس مستعمل نظيف جداً
price: 350000
category_id: 1
sub_category_id: 2
type: normal
images[]: [file1.jpg, file2.jpg]
```

**Response (201):**
```json
{
  "status": true,
  "message": "Advertisement created successfully",
  "data": {
    "id": 1,
    "title": "iPhone 13 Pro Max",
    "description": "هاتف ايفون 13 برو ماكس مستعمل نظيف جداً",
    "price": 350000,
    "type": "normal",
    "feature_type": "none",
    "is_active": true,
    "trader_id": 1,
    "category_id": 1,
    "sub_category_id": 2,
    "created_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

---

### 2. Get My Advertisements
**Endpoint:** `GET /api/ads/mine`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "price": 350000,
      "type": "normal",
      "feature_type": "premium",
      "is_active": true,
      "views_count": 150,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

### 3. Delete Advertisement
**Endpoint:** `POST /api/ads/delete/{advertisement_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Advertisement deleted successfully"
}
```

---

### 4. Update Advertisement Status
**Endpoint:** `PUT /api/trader/ads/{advertisement_id}/status`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "is_active": false
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Advertisement status updated",
  "data": {
    "id": 1,
    "is_active": false
  }
}
```

---

### 5. Get Scheduled Advertisements
**Endpoint:** `GET /api/trader/ads/scheduled`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "scheduled_for": "2024-12-15T00:00:00.000000Z",
      "is_active": false
    }
  ]
}
```

---

### 6. Get Expired Advertisements
**Endpoint:** `GET /api/trader/ads/expired`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "expired_at": "2024-11-01T00:00:00.000000Z",
      "is_active": false
    }
  ]
}
```

---

### 7. Renew Advertisement
**Endpoint:** `POST /api/trader/ads/{advertisement_id}/renew`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "duration_days": 30
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Advertisement renewed successfully",
  "data": {
    "id": 1,
    "expires_at": "2025-01-10T00:00:00.000000Z"
  }
}
```

---

### 8. Get Featured Advertisements
**Endpoint:** `GET /api/ads/featured`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "price": 350000,
      "feature_type": "premium",
      "promoted_until": "2024-12-20T00:00:00.000000Z",
      "trader": {
        "store": {
          "store_name": "متجر الإلكترونيات"
        }
      }
    }
  ]
}
```

---

## Post APIs

### 1. Create Post
**Endpoint:** `POST /api/posts/create`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
content: أبحث عن ايفون 13 برو ماكس بسعر مناسب
images[]: [file1.jpg, file2.jpg]
```

**Response (201):**
```json
{
  "status": true,
  "message": "Post created successfully",
  "data": {
    "id": 1,
    "content": "أبحث عن ايفون 13 برو ماكس بسعر مناسب",
    "trader_id": 1,
    "created_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

---

### 2. Get My Posts
**Endpoint:** `GET /api/posts/mine`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "content": "أبحث عن ايفون 13 برو ماكس بسعر مناسب",
      "likes_count": 15,
      "dislikes_count": 2,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

### 3. Get All Posts
**Endpoint:** `GET /api/user/get_posts`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "content": "أبحث عن ايفون 13 برو ماكس",
        "trader": {
          "store": {
            "store_name": "متجر الإلكترونيات"
          }
        },
        "likes_count": 15,
        "dislikes_count": 2,
        "created_at": "2024-01-01T00:00:00.000000Z"
      }
    ],
    "per_page": 15,
    "total": 100
  }
}
```

---

### 4. Delete Post
**Endpoint:** `POST /api/posts/delete/{post_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Post deleted successfully"
}
```

---

### 5. Like Post
**Endpoint:** `POST /api/post/like/{post_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Post liked successfully"
}
```

---

### 6. Dislike Post
**Endpoint:** `POST /api/post/dislike/{post_id}`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Post disliked successfully"
}
```

---

## Category APIs

### 1. Get All Categories
**Endpoint:** `GET /api/categories`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "name": "الإلكترونيات",
      "sub_categories": [
        {
          "id": 1,
          "name": "الهواتف الذكية",
          "category_id": 1
        },
        {
          "id": 2,
          "name": "أجهزة الكمبيوتر",
          "category_id": 1
        }
      ]
    },
    {
      "id": 2,
      "name": "الأثاث",
      "sub_categories": [
        {
          "id": 3,
          "name": "أثاث غرف النوم",
          "category_id": 2
        }
      ]
    }
  ]
}
```

---

## Analytics APIs

### 1. Get Analytics Overview
**Endpoint:** `GET /api/trader/analytics/overview`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "total_ads": 25,
    "active_ads": 20,
    "total_views": 1500,
    "total_favorites": 45,
    "total_posts": 10,
    "total_likes": 150,
    "wallet_balance": 50000,
    "wallet_points": 100
  }
}
```

---

### 2. Get Ads Analytics
**Endpoint:** `GET /api/trader/analytics/ads`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "iPhone 13 Pro Max",
      "views_count": 150,
      "favorites_count": 12,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

### 3. Get Chart Data
**Endpoint:** `GET /api/trader/analytics/chart?period=week`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `period`: `week`, `month`, or `year`

**Response (200):**
```json
{
  "status": true,
  "data": {
    "labels": ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
    "views": [50, 75, 100, 80, 120, 90, 150],
    "favorites": [5, 8, 12, 10, 15, 11, 18],
    "posts": [2, 3, 1, 4, 2, 3, 5]
  }
}
```

---

## Promotion APIs

### 1. Get Promotion Packages
**Endpoint:** `GET /api/promotion-packages`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "name": "باقة البرونز",
      "name_en": "Bronze Package",
      "duration_days": 7,
      "price": 10000,
      "features": "عرض مميز لمدة أسبوع",
      "features_en": "Featured listing for 1 week"
    },
    {
      "id": 2,
      "name": "باقة الفضة",
      "name_en": "Silver Package",
      "duration_days": 15,
      "price": 18000,
      "features": "عرض مميز لمدة أسبوعين",
      "features_en": "Featured listing for 2 weeks"
    },
    {
      "id": 3,
      "name": "باقة الذهب",
      "name_en": "Gold Package",
      "duration_days": 30,
      "price": 30000,
      "features": "عرض مميز لمدة شهر",
      "features_en": "Featured listing for 1 month"
    }
  ]
}
```

---

### 2. Promote Advertisement
**Endpoint:** `POST /api/trader/ads/{advertisement_id}/promote`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "package_id": 2
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Advertisement promoted successfully",
  "data": {
    "advertisement_id": 1,
    "package": {
      "id": 2,
      "name": "باقة الفضة",
      "duration_days": 15
    },
    "promoted_until": "2024-12-25T00:00:00.000000Z",
    "points_deducted": 18
  }
}
```

**Error Response (400):**
```json
{
  "status": false,
  "message": "Insufficient points"
}
```

---

## Report APIs

### 1. Get Report Reasons
**Endpoint:** `GET /api/reports/reasons`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "value": "spam",
      "label": "محتوى مزعج أو غير مرغوب",
      "label_en": "Spam or unwanted content"
    },
    {
      "value": "fraud",
      "label": "احتيال أو خداع",
      "label_en": "Fraud or scam"
    },
    {
      "value": "inappropriate",
      "label": "محتوى غير لائق",
      "label_en": "Inappropriate content"
    },
    {
      "value": "misleading",
      "label": "معلومات مضللة",
      "label_en": "Misleading information"
    },
    {
      "value": "offensive",
      "label": "محتوى مسيء",
      "label_en": "Offensive content"
    },
    {
      "value": "other",
      "label": "أخرى",
      "label_en": "Other"
    }
  ]
}
```

---

### 2. Submit Report
**Endpoint:** `POST /api/reports`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "reportable_type": "advertisement",
  "reportable_id": 1,
  "reason": "spam",
  "description": "هذا الإعلان يحتوي على معلومات مضللة"
}
```

**Valid `reportable_type` values:**
- `advertisement`
- `post`
- `store`
- `trader`

**Response (201):**
```json
{
  "status": true,
  "message": "Report submitted successfully",
  "data": {
    "id": 1,
    "reason": "spam",
    "description": "هذا الإعلان يحتوي على معلومات مضللة",
    "status": "pending",
    "created_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

---

### 3. Get My Reports
**Endpoint:** `GET /api/user/reports`
**Authentication:** Required

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": true,
  "data": [
    {
      "id": 1,
      "reportable_type": "advertisement",
      "reportable_id": 1,
      "reason": "spam",
      "description": "هذا الإعلان يحتوي على معلومات مضللة",
      "status": "pending",
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

---

## Search APIs

### 1. Advanced Search
**Endpoint:** `POST /api/search/advanced`
**Authentication:** Not Required

**Request Body:**
```json
{
  "query": "ايفون",
  "category_id": 1,
  "sub_category_id": 2,
  "city": "بغداد",
  "min_price": 100000,
  "max_price": 500000,
  "type": "normal",
  "feature_type": "premium",
  "sort_by": "price",
  "sort_order": "asc",
  "page": 1,
  "per_page": 20
}
```

**Response (200):**
```json
{
  "status": true,
  "data": {
    "advertisements": {
      "current_page": 1,
      "data": [
        {
          "id": 1,
          "title": "iPhone 13 Pro Max",
          "price": 350000,
          "trader": {
            "city": "بغداد",
            "store": {
              "store_name": "متجر الإلكترونيات"
            }
          }
        }
      ],
      "total": 15
    },
    "stores": [
      {
        "id": 1,
        "store_name": "متجر الإلكترونيات"
      }
    ],
    "posts": [
      {
        "id": 1,
        "content": "أبحث عن ايفون 13"
      }
    ]
  }
}
```

---

## Support & Version APIs

### 1. Get Support Information
**Endpoint:** `GET /api/support`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": {
    "phone": "07701234567",
    "email": "support@example.com",
    "whatsapp": "07701234567",
    "telegram": "@support",
    "working_hours": "السبت - الخميس: 9:00 صباحاً - 9:00 مساءً"
  }
}
```

---

### 2. Get App Version
**Endpoint:** `GET /api/version`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": {
    "version": "1.0.0",
    "build_number": 1,
    "force_update": false,
    "update_url": "https://play.google.com/store/apps/details?id=com.example.app"
  }
}
```

---

### 3. Update App Version (Admin)
**Endpoint:** `POST /api/update/version`
**Authentication:** Required (Admin)

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "version": "1.1.0",
  "build_number": 2,
  "force_update": true,
  "update_url": "https://play.google.com/store/apps/details?id=com.example.app"
}
```

**Response (200):**
```json
{
  "status": true,
  "message": "Version updated successfully"
}
```

---

### 4. Get Cities
**Endpoint:** `GET /api/cities`
**Authentication:** Not Required

**Response (200):**
```json
{
  "status": true,
  "data": [
    "بغداد",
    "البصرة",
    "أربيل",
    "النجف",
    "كربلاء",
    "الموصل",
    "السليمانية",
    "ديالى",
    "الأنبار",
    "ذي قار",
    "بابل",
    "كركوك",
    "واسط",
    "دهوك"
  ]
}
```

---

## Error Responses

### Common Error Codes

**401 Unauthorized:**
```json
{
  "status": false,
  "message": "Unauthenticated"
}
```

**403 Forbidden:**
```json
{
  "status": false,
  "message": "You are not authorized to perform this action"
}
```

**404 Not Found:**
```json
{
  "status": false,
  "message": "Resource not found"
}
```

**422 Validation Error:**
```json
{
  "status": false,
  "message": "Validation errors",
  "errors": {
    "field_name": [
      "Error message 1",
      "Error message 2"
    ]
  }
}
```

**500 Server Error:**
```json
{
  "status": false,
  "message": "Internal server error"
}
```

---

## Rate Limiting

API requests are rate-limited to prevent abuse:
- **Guest requests:** 60 requests per minute
- **Authenticated requests:** 120 requests per minute

When rate limit is exceeded:
```json
{
  "status": false,
  "message": "Too many requests. Please try again later."
}
```

---

## Best Practices

1. **Always include proper headers:**
   - `Content-Type: application/json` for JSON requests
   - `Content-Type: multipart/form-data` for file uploads
   - `Authorization: Bearer {token}` for authenticated requests

2. **Handle errors gracefully:**
   - Check the `status` field in responses
   - Display appropriate error messages to users

3. **Implement pagination:**
   - Use `page` and `per_page` parameters for large datasets
   - Default `per_page` is usually 15

4. **Store tokens securely:**
   - Never expose API tokens in client-side code
   - Implement token refresh mechanisms

5. **Optimize requests:**
   - Cache frequently accessed data
   - Use appropriate HTTP methods (GET, POST, PUT, DELETE)

---

## Postman Collection

Import this base configuration into Postman:

**Environment Variables:**
```json
{
  "base_url": "http://localhost:8000/api",
  "token": "",
  "user_id": "",
  "trader_id": ""
}
```

**Example Request:**
```
GET {{base_url}}/categories
Authorization: Bearer {{token}}
```

---

## Contact & Support

For API support or questions:
- **Email:** support@example.com
- **Phone:** 07701234567
- **Documentation:** [API_DOCUMENTATION_GUIDE.md](./API_DOCUMENTATION_GUIDE.md)

---

**Last Updated:** December 10, 2024
**API Version:** 1.0.0

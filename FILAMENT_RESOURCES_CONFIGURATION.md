# Filament Admin Panel - Resources Configuration

## Complete Resource Organization

### 📊 Dashboard (Home)
**Widgets:**
- StatsOverview (Total users, traders, stores, ads, reports)
- RegistrationsChart (Monthly registration trend)
- RecentActivity (Latest registrations and activities)

---

### 👥 Users Management

#### 1. UserResource
- **Icon:** `heroicon-o-users`
- **Navigation Group:** "Users"
- **Navigation Label:** "Users"
- **Navigation Sort:** 1
- **Table Columns:** name, email, phone, created_at
- **Filters:** created_at (date range)
- **Search:** name, email, phone
- **Actions:** View, Edit, Delete

#### 2. TraderResource
- **Icon:** `heroicon-o-user-group`
- **Navigation Group:** "Users"
- **Navigation Label:** "Traders"
- **Navigation Sort:** 2
- **Table Columns:** owner_contact_number, city, store.store_name, created_at
- **Filters:** city, created_at
- **Search:** owner_contact_number, whatsapp_number
- **Relations:** wallet, advertisements, posts

#### 3. AdminResource
- **Icon:** `heroicon-o-shield-check`
- **Navigation Group:** "Users"
- **Navigation Label:** "Admins"
- **Navigation Sort:** 3
- **Table Columns:** name, email, created_at
- **Filters:** created_at
- **Search:** name, email

---

### 🏪 Stores Management

#### 4. StoreResource
- **Icon:** `heroicon-o-building-storefront`
- **Navigation Group:** "Stores"
- **Navigation Label:** "Stores"
- **Navigation Sort:** 1
- **Table Columns:** store_name, store_owner_name, store_number, category, created_at
- **Filters:** category_id, created_at
- **Search:** store_name, store_owner_name, store_number
- **Relations:** hours, traders, subCategories

#### 5. StoreHoursResource
- **Icon:** `heroicon-o-clock`
- **Navigation Group:** "Stores"
- **Navigation Label:** "Store Hours"
- **Navigation Sort:** 2
- **Table Columns:** store.store_name, day, is_closed, opens_at, closes_at
- **Filters:** store_id, day, is_closed
- **Search:** store.store_name

---

### 📢 Advertisements

#### 6. AdvertisementResource
- **Icon:** `heroicon-o-megaphone`
- **Navigation Group:** "Advertisements"
- **Navigation Label:** "Advertisements"
- **Navigation Sort:** 1
- **Table Columns:** title, trader.store.store_name, type, status, is_featured, scheduled_at, expires_at, created_at
- **Filters:** status (draft, scheduled, active, expired, paused), type, is_featured, scheduled_at, expires_at
- **Search:** title, description
- **Badge:** status (color-coded)
- **Widgets:** AdvertisementStats

#### 7. PromotionPackageResource
- **Icon:** `heroicon-o-star`
- **Navigation Group:** "Advertisements"
- **Navigation Label:** "Promotion Packages"
- **Navigation Sort:** 2
- **Table Columns:** name, duration_days, price_points, is_active
- **Filters:** is_active
- **Search:** name

#### 8. PromotionResource
- **Icon:** `heroicon-o-fire`
- **Navigation Group:** "Advertisements"
- **Navigation Label:** "Active Promotions"
- **Navigation Sort:** 3
- **Table Columns:** advertisement.title, package.name, started_at, expires_at, points_paid
- **Filters:** package_id, started_at, expires_at
- **Widgets:** PromotionStats

---

### 📝 Posts

#### 9. PostResource
- **Icon:** `heroicon-o-document-text`
- **Navigation Group:** "Posts"
- **Navigation Label:** "Posts"
- **Navigation Sort:** 1
- **Table Columns:** title, trader.store.store_name, created_at
- **Filters:** trader_id, created_at
- **Search:** title, description

---

### 🗂️ Categories

#### 10. CategoryResource
- **Icon:** `heroicon-o-folder`
- **Navigation Group:** "Categories"
- **Navigation Label:** "Categories"
- **Navigation Sort:** 1
- **Table Columns:** name, image, created_at
- **Search:** name

#### 11. SubCategoryResource
- **Icon:** `heroicon-o-folder-open`
- **Navigation Group:** "Categories"
- **Navigation Label:** "Sub Categories"
- **Navigation Sort:** 2
- **Table Columns:** name, image, created_at
- **Search:** name

#### 12. SubCategoriesStoreResource
- **Icon:** `heroicon-o-link`
- **Navigation Group:** "Categories"
- **Navigation Label:** "Store-SubCategory Links"
- **Navigation Sort:** 3
- **Table Columns:** store.store_name, subCategory.name

---

### 💰 Financial

#### 13. WalletResource
- **Icon:** `heroicon-o-wallet`
- **Navigation Group:** "Financial"
- **Navigation Label:** "Wallets"
- **Navigation Sort:** 1
- **Table Columns:** trader.store.store_name, current_balance, created_at
- **Filters:** created_at
- **Search:** trader.owner_contact_number

#### 14. RechargeCodeResource
- **Icon:** `heroicon-o-ticket`
- **Navigation Group:** "Financial"
- **Navigation Label:** "Recharge Codes"
- **Navigation Sort:** 2
- **Table Columns:** code, points, is_used, used_by_trader_id, created_at
- **Filters:** is_used, created_at
- **Search:** code

#### 15. RechargeOperationResource
- **Icon:** `heroicon-o-banknotes`
- **Navigation Group:** "Financial"
- **Navigation Label:** "Recharge History"
- **Navigation Sort:** 3
- **Table Columns:** trader.store.store_name, code, points, created_at
- **Filters:** trader_id, created_at
- **Search:** code

---

### 🚩 Reports

#### 16. ReportResource
- **Icon:** `heroicon-o-flag`
- **Navigation Group:** "Reports"
- **Navigation Label:** "Reports"
- **Navigation Badge:** Pending count
- **Navigation Sort:** 1
- **Table Columns:** reportable_type, reportable_id, reporter_type, reporter_id, reason, status, created_at
- **Filters:** reportable_type, reason, status
- **Search:** description
- **Actions:** Quick Resolve, Quick Dismiss
- **Widgets:** ReportStats

---

### ⭐ Reviews & Ratings

#### 17. ReviewResource
- **Icon:** `heroicon-o-chat-bubble-left-right`
- **Navigation Group:** "Reviews & Ratings"
- **Navigation Label:** "Reviews"
- **Navigation Sort:** 1
- **Table Columns:** reviewable_type, reviewable_id, user.name, comment, created_at
- **Filters:** reviewable_type, created_at
- **Search:** comment

#### 18. RateResource
- **Icon:** `heroicon-o-star`
- **Navigation Group:** "Reviews & Ratings"
- **Navigation Label:** "Ratings"
- **Navigation Sort:** 2
- **Table Columns:** rated_type, rated_id, user.name, rate, comment, created_at
- **Filters:** rated_type, rate, created_at
- **Search:** comment

---

### ❤️ Interactions

#### 19. FavoriteResource
- **Icon:** `heroicon-o-heart`
- **Navigation Group:** "Interactions"
- **Navigation Label:** "Favorites"
- **Navigation Sort:** 1
- **Table Columns:** user.name, favorite_type, favorite_id, created_at
- **Filters:** favorite_type, created_at
- **Search:** user.name

#### 20. LikeResource
- **Icon:** `heroicon-o-hand-thumb-up`
- **Navigation Group:** "Interactions"
- **Navigation Label:** "Likes"
- **Navigation Sort:** 2
- **Table Columns:** likeable_type, likeable_id, user.name/trader.store.name, is_dislike, created_at
- **Filters:** likeable_type, is_dislike, created_at

#### 21. BlockResource
- **Icon:** `heroicon-o-no-symbol`
- **Navigation Group:** "Interactions"
- **Navigation Label:** "Blocks"
- **Navigation Sort:** 3
- **Table Columns:** user.name, blocked_type, blocked_id, created_at
- **Filters:** blocked_type, created_at
- **Search:** user.name

---

### 📊 Analytics

#### 22. ViewResource
- **Icon:** `heroicon-o-eye`
- **Navigation Group:** "Analytics"
- **Navigation Label:** "Views"
- **Navigation Sort:** 1
- **Table Columns:** viewable_type, viewable_id, user.name, ip_address, created_at
- **Filters:** viewable_type, created_at
- **Widgets:** ViewStatsOverview, MostViewedItems

#### 23. SearchLogResource
- **Icon:** `heroicon-o-magnifying-glass`
- **Navigation Group:** "Analytics"
- **Navigation Label:** "Search Logs"
- **Navigation Sort:** 2
- **Table Columns:** keyword, category, sub_category, city, results_count, created_at
- **Filters:** created_at, category_id, city
- **Search:** keyword
- **Widgets:** SearchStatsOverview, PopularSearches

---

### ⚙️ Settings

#### 24. SettingResource
- **Icon:** `heroicon-o-cog-6-tooth`
- **Navigation Group:** "Settings"
- **Navigation Label:** "Settings"
- **Navigation Sort:** 1
- **Table Columns:** key, value, updated_at
- **Search:** key, value

#### 25. AddressResource
- **Icon:** `heroicon-o-map-pin`
- **Navigation Group:** "Settings"
- **Navigation Label:** "Addresses"
- **Navigation Sort:** 2
- **Table Columns:** addressable_type, addressable_id, address, city, country
- **Filters:** addressable_type, city, country
- **Search:** address, city

#### 26. ImageResource
- **Icon:** `heroicon-o-photo`
- **Navigation Group:** "Settings"
- **Navigation Label:** "Images"
- **Navigation Sort:** 3
- **Table Columns:** related_type, related_id, url, created_at
- **Filters:** related_type, created_at

#### 27. NotificationResource
- **Icon:** `heroicon-o-bell`
- **Navigation Group:** "Settings"
- **Navigation Label:** "Notifications"
- **Navigation Sort:** 4
- **Table Columns:** type, notifiable_type, notifiable_id, data, read_at, created_at
- **Filters:** type, read_at, created_at

---

## Navigation Groups Order

1. **Dashboard** (no group - home)
2. **Users** (Users, Traders, Admins)
3. **Stores** (Stores, Store Hours)
4. **Advertisements** (Ads, Promotion Packages, Active Promotions)
5. **Posts**
6. **Categories** (Categories, Sub Categories, Links)
7. **Financial** (Wallets, Recharge Codes, Recharge History)
8. **Reports**
9. **Reviews & Ratings** (Reviews, Ratings)
10. **Interactions** (Favorites, Likes, Blocks)
11. **Analytics** (Views, Search Logs)
12. **Settings** (Settings, Addresses, Images, Notifications)

---

## Missing Features to Add

### Each Resource Needs:
1. ✅ Proper icon
2. ✅ Navigation group
3. ✅ Navigation label
4. ✅ Navigation sort order
5. ✅ Table columns configuration
6. ✅ Filters
7. ✅ Search fields
8. ✅ Actions (Edit, Delete, View)
9. ⬜ Bulk actions
10. ⬜ Export capability

### Global Improvements:
1. ⬜ Arabic translations for all labels
2. ⬜ Consistent date/time formatting
3. ⬜ Consistent badge colors
4. ⬜ Consistent status indicators
5. ⬜ Relationship badges
6. ⬜ Quick actions in tables
7. ⬜ Global search configuration

---

## Priority Updates

### High Priority (User-facing):
1. **AdvertisementResource** - Complete with all filters and status badges
2. **UserResource** - Add filters and search
3. **TraderResource** - Add filters and relations
4. **StoreResource** - Add filters and relations
5. **ReportResource** - Add quick actions

### Medium Priority (Admin tools):
6. **PromotionPackageResource** - Complete configuration
7. **WalletResource** - Add filters
8. **SearchLogResource** - Add analytics widgets
9. **ViewResource** - Add analytics widgets

### Low Priority (Technical):
10. **ImageResource** - Basic configuration
11. **AddressResource** - Basic configuration
12. **NotificationResource** - Complete CRUD

---

## Dashboard Configuration

**File:** `app/Filament/Pages/Dashboard.php`

**Widgets (in order):**
1. StatsOverview (8 key metrics)
2. RegistrationsChart (Monthly trend)
3. RecentAdvertisements (Latest 5)
4. RecentReports (Latest 5 pending)

**Widget Width:**
- StatsOverview: Full width
- RegistrationsChart: Full width
- RecentAdvertisements: Half width
- RecentReports: Half width

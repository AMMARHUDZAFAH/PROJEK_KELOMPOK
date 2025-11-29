# 🧪 E-Commerce Testing Guide

## ✅ Quick Test Checklist

### 1️⃣ User Registration & Login
- [ ] Go to http://localhost:8000/register
- [ ] Create new account with test email
- [ ] Login with new credentials
- [ ] Verify navbar shows username and cart badge (0 items)

**Test Credentials:**
```
Admin: admin@example.com / password
User: user@example.com / password
Or create new test accounts
```

---

## 🛍️ User Shopping Flow (Full End-to-End)

### Step 1: Browse Products
- [ ] Click "📦 Produk" in navbar
- [ ] View all 10+ sample products
- [ ] Filter by category (Elektronik, Aksesoris, etc.)
- [ ] Search for a product (e.g., "Laptop")

### Step 2: View Product Details
- [ ] Click on "Laptop Gaming ASUS ROG" or any product
- [ ] See product details, price, stock, category, description
- [ ] Verify "Produk habis" badge shows if out of stock
- [ ] See related products section

### Step 3: Add to Cart
- [ ] Click "Tambah ke Keranjang"
- [ ] Enter quantity (e.g., 2)
- [ ] Click add button
- [ ] See success message
- [ ] Verify navbar cart badge updates to show count

### Step 4: View & Manage Cart
- [ ] Click cart badge or "🛒 Keranjang" in navbar
- [ ] See all items with:
  - [ ] Product image
  - [ ] Product name
  - [ ] Unit price
  - [ ] Quantity with ± buttons
  - [ ] Subtotal per item
  - [ ] Running total in sidebar
- [ ] Update quantity using +/- buttons
- [ ] Remove individual items
- [ ] Verify prices recalculate
- [ ] See "Lanjut ke Checkout" button

### Step 5: Checkout Process
- [ ] Click "Lanjut ke Checkout"
- [ ] See order summary in sidebar
- [ ] Fill shipping form:
  - [ ] Enter phone number
  - [ ] Enter full address
- [ ] Click "Buat Pesanan"
- [ ] See order confirmation page with:
  - [ ] ✅ Success message
  - [ ] Order number
  - [ ] Order details
  - [ ] Items list with prices
  - [ ] Payment instructions (BCA transfer)

### Step 6: Track Order
- [ ] Click "Lihat Pesanan" or go to Orders page
- [ ] See order in list with:
  - [ ] Order number
  - [ ] Date
  - [ ] Total price
  - [ ] Number of items
  - [ ] Address preview
  - [ ] Status badge
- [ ] Click "Lihat Detail"
- [ ] See full order details:
  - [ ] Order header with status
  - [ ] Customer info
  - [ ] Complete items table
  - [ ] Shipping address
  - [ ] Payment summary
  - [ ] Sticky sidebar with totals

### Step 7: User Profile
- [ ] Click username dropdown → "👤 Profil Saya"
- [ ] See profile information:
  - [ ] Name, email
  - [ ] Account type (Pelanggan)
  - [ ] Total orders count
  - [ ] Total spending
- [ ] See recent orders list
- [ ] Click "✏️ Edit Profil"
- [ ] Update name or email
- [ ] Save and verify changes

---

## 👨‍💼 Admin Functions (Full End-to-End)

### Dashboard
- [ ] Login as admin: admin@example.com / password
- [ ] Click "👨‍💼 Admin Dashboard" or go to /admin/dashboard
- [ ] See sales metrics:
  - [ ] 💰 Total Revenue (sum of completed orders)
  - [ ] ✅ Completed Orders count
  - [ ] ⏳ Pending Orders count
  - [ ] 📦 Total Products
- [ ] See recent orders table with status updates
- [ ] See product list
- [ ] See order status breakdown charts

### Manage Products
- [ ] Click "🛠️ Kelola Produk" in dropdown
- [ ] See all products with stock levels
- [ ] Create new product:
  - [ ] Fill name, description, price
  - [ ] Select category
  - [ ] Enter stock quantity
  - [ ] Upload image
  - [ ] Save and verify it appears in list
- [ ] Edit existing product
- [ ] Delete product (verify stock count updates)

### Manage Orders
- [ ] Click "📋 Kelola Pesanan" in dropdown
- [ ] See list of all customer orders with:
  - [ ] Order ID
  - [ ] Customer name/email
  - [ ] Total price
  - [ ] Status badge (color-coded)
  - [ ] Date/time
- [ ] Click on order to view details
- [ ] Update order status:
  - [ ] Change from pending → paid
  - [ ] Change from paid → processing
  - [ ] Change from processing → shipped
  - [ ] Change from shipped → completed
  - [ ] Verify changes reflected in list
- [ ] Check status labels in Indonesian:
  - [ ] ⏳ Menunggu Pembayaran (pending)
  - [ ] ✅ Dibayar (paid)
  - [ ] 🔄 Sedang Diproses (processing)
  - [ ] 🚚 Dikirim (shipped)
  - [ ] ✨ Selesai (completed)

### Manage Categories
- [ ] Click "🗂️ Kelola Kategori"
- [ ] See existing categories
- [ ] Create new category
- [ ] Edit category name
- [ ] Delete category (verify products still work)

### Manage Users
- [ ] Click "👤 Kelola Pengguna"
- [ ] See all registered users
- [ ] View user details
- [ ] Edit user information
- [ ] Delete user (soft delete)
- [ ] Restore deleted user (if available)

---

## 🔐 Authentication Tests

### Login Tests
- [ ] Successful login redirects to home/dashboard
- [ ] Failed login shows error message
- [ ] Email not registered shows error
- [ ] Wrong password shows error
- [ ] Logout works and redirects to login

### Registration Tests
- [ ] New registration creates account
- [ ] Email already used shows error
- [ ] Password validation works (required, min 8)
- [ ] Empty fields show validation errors
- [ ] After registration, can login with credentials

### Authorization Tests
- [ ] Regular user cannot access /admin routes
- [ ] Admin cannot see user routes they shouldn't
- [ ] User can only see their own orders
- [ ] User can only modify their own cart
- [ ] Unauthenticated user cannot access protected routes

---

## 🛒 Cart Functionality Tests

### Add to Cart
- [ ] Stock validation: Can't add more than available stock
- [ ] Multiple products can be in cart
- [ ] Same product added again updates quantity
- [ ] Cart persists after page refresh

### Update Cart
- [ ] Quantity can be increased with + button
- [ ] Quantity can be decreased with - button
- [ ] Cannot go below 1 item
- [ ] Cannot add more than available stock

### Remove from Cart
- [ ] Remove button removes item from cart
- [ ] Cart count updates
- [ ] Prices recalculate

### Clear Cart
- [ ] Clear button removes all items
- [ ] Cart count resets to 0
- [ ] Cart total resets to 0

---

## 💰 Order Processing Tests

### Stock Management
- [ ] Product stock decreases after order completes
- [ ] Cannot checkout with 0 stock
- [ ] Stock shown correctly on product page

### Order Creation
- [ ] Order created with current date/time
- [ ] Order total calculated correctly
- [ ] Order items snapshot product price at purchase
- [ ] Order status starts as "pending"
- [ ] Cart is cleared after checkout

### Order Tracking
- [ ] User sees only their orders
- [ ] Admin sees all orders
- [ ] Order detail shows all purchased items
- [ ] Order shows shipping address used at checkout
- [ ] Order shows correct total price

---

## 💻 UI/UX Tests

### Responsive Design
- [ ] Test on mobile (320px)
- [ ] Test on tablet (768px)
- [ ] Test on desktop (1024px+)
- [ ] Navigation works on all sizes
- [ ] Tables and forms are readable

### Navigation
- [ ] Navbar links work correctly
- [ ] Dropdown menus function
- [ ] Cart badge shows correct count
- [ ] Status badges display correct colors
- [ ] Breadcrumbs navigate correctly

### Forms
- [ ] Form validation shows error messages
- [ ] Success messages appear after actions
- [ ] Form inputs pre-fill when editing
- [ ] File uploads work for product images

---

## 🧮 Data Integrity Tests

### Price Calculations
- [ ] Subtotal = price × quantity
- [ ] Order total = sum of all subtotals
- [ ] No rounding errors in totals
- [ ] Free shipping applied correctly

### Stock Management
- [ ] Stock decreases exactly by order quantity
- [ ] Cannot oversell (order blocked if insufficient stock)
- [ ] Stock shown accurately on all pages

### Relationships
- [ ] User has many orders
- [ ] Order has many items
- [ ] Product visible on all related orders
- [ ] Category displays all related products

---

## 🐛 Error Handling Tests

### Validation
- [ ] Empty cart cannot checkout
- [ ] Missing address/phone shows error
- [ ] Invalid email format rejected
- [ ] Non-numeric quantities rejected

### Edge Cases
- [ ] Cannot access other user's orders
- [ ] Cannot delete non-existent product
- [ ] Cannot checkout without authentication
- [ ] Cannot modify quantity beyond stock

---

## 📊 Admin Dashboard Tests

### Metrics Accuracy
- [ ] Total revenue = sum of completed orders
- [ ] Completed count = exact number of completed orders
- [ ] Pending count = exact number of pending orders
- [ ] Product count = total products in system

### Charts & Graphs
- [ ] Status breakdown chart shows correct percentages
- [ ] Recent orders list shows latest 5 orders
- [ ] Revenue graph displays data correctly

---

## 🚀 Performance Tests

### Load Times
- [ ] Product listing loads quickly (<2s)
- [ ] Cart page responds instantly
- [ ] Admin dashboard loads in reasonable time
- [ ] Images load without lag

### Database
- [ ] Queries use relationships efficiently
- [ ] Pagination works (15 items per page)
- [ ] Search/filter doesn't timeout

---

## ✨ Sample Test Data

**Pre-seeded Data Available:**
- 5 Users (admin + 4 regular users)
- 5 Categories (Elektronik, Aksesoris, Software, Perlengkapan, Gadget)
- 10 Products (various prices and stock levels)
- 15 Sample Orders (various statuses)

**Test Accounts:**
- Admin: `admin@example.com` / `password`
- User: `user@example.com` / `password`
- Additional users: `fulan@example.com`, `fulanah@example.com`, etc.

---

## 📝 Testing Notes

- Run `php artisan db:seed` to repopulate test data
- Check database with: `php artisan tinker`
- Monitor logs: `storage/logs/laravel.log`
- Clear cache if seeing stale data: `php artisan cache:clear`
- Reset migrations: `php artisan migrate:refresh --seed`

---

## 🎯 Final Sign-Off

✅ All tests passed: Ready for production
❌ Issues found: Document and report in ISSUES.md

**Tested By:** [Your Name]  
**Date:** November 29, 2024  
**Version:** 1.0.0

# 🚀 ElectroHub - Quick Start Guide

Get your e-commerce platform running in minutes!

## ⚡ 5-Minute Setup

### 1. Install Dependencies
```bash
cd PROJEK_KELOMPOK
composer install
npm install
```

### 2. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
```bash
# Create database in MySQL
# mysql> CREATE DATABASE electrohub;

# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed
```

### 4. Setup Storage
```bash
php artisan storage:link
```

### 5. Start Development Server
```bash
# Terminal 1: Laravel server
php artisan serve --port=8000

# Terminal 2: Asset compilation (optional for CSS)
npm run dev
```

6. **Open in Browser:** http://localhost:8000

---

## 🔑 Default Credentials

| Role  | Email                | Password |
|-------|----------------------|----------|
| Admin | admin@example.com    | password |
| User  | user@example.com     | password |

---

## 📱 First Steps

### As a Customer
1. Go to **Products** page
2. Click any product to view details
3. Click **"Tambah ke Keranjang"** (Add to Cart)
4. Click cart icon → **"Lanjut ke Checkout"**
5. Fill shipping info → Create order
6. View your order in **"📋 Pesanan Saya"**

### As an Admin
1. Click username → **"👨‍💼 Admin Dashboard"**
2. View sales metrics and recent orders
3. Click **"📋 Kelola Pesanan"** to manage orders
4. Update order status (pending → paid → processing → shipped → completed)
5. Click **"🛠️ Kelola Produk"** to manage inventory

---

## 🎨 Key Features

✅ **Complete Shopping Flow**
- Browse products by category
- Add items to cart
- Secure checkout with address entry
- Order confirmation with payment instructions

✅ **Order Management**
- User order history with status tracking
- Admin dashboard with sales analytics
- Real-time status updates
- Order detail view with items breakdown

✅ **Admin Tools**
- Product CRUD with image upload
- Category management
- User management
- Sales dashboard with revenue metrics
- Order status workflow

✅ **Professional UI**
- Responsive Bootstrap 5 design
- Emoji icons for better UX
- Status badges with color coding
- Mobile-friendly navigation

---

## 📂 Project Structure

```
resources/
├── views/
│   ├── cart/index.blade.php              ← Shopping cart
│   ├── checkout/show.blade.php           ← Checkout form
│   ├── orders/                           ← Order tracking
│   ├── admin/orders/                     ← Admin order management
│   ├── admin/dashboard.blade.php         ← Sales dashboard
│   ├── profile/show.blade.php            ← User profile
│   └── products/show.blade.php           ← Product detail

app/Http/Controllers/
├── CartController.php                    ← Cart operations
├── CheckoutController.php                ← Checkout flow
├── OrderController.php                   ← Orders (user & admin)
├── ProfileController.php                 ← User profile
└── AdminDashboardController.php          ← Admin dashboard

app/Models/
├── Cart.php                              ← Shopping cart model
├── CartItem.php                          ← Cart item model
├── Order.php                             ← Order model
└── OrderItem.php                         ← Order item model
```

---

## 🛣️ Important Routes

### Customer Routes
```
GET  /products                 Browse products
GET  /products/{id}           Product detail
GET  /cart                    Shopping cart
POST /cart/add/{product}      Add to cart
POST /checkout/process        Create order
GET  /orders                  View my orders
GET  /orders/{id}             Order detail
GET  /profile                 User profile
```

### Admin Routes
```
GET  /admin/dashboard         Sales dashboard
GET  /admin/products          Manage products
GET  /admin/orders            Manage all orders
GET  /admin/orders/{id}       Order detail
POST /admin/orders/{id}/status Update order status
```

---

## 💾 Database Tables

**Key Tables Created:**
- `carts` - Shopping carts for users
- `cart_items` - Products in shopping carts
- `orders` - Customer orders
- `order_items` - Products in orders
- `products` - Product catalog
- `categories` - Product categories
- `users` - User accounts

---

## 🧪 Quick Testing

### Test Adding a Product to Cart
1. Login as: `user@example.com` / `password`
2. Go to Products
3. Click "Laptop Gaming ASUS ROG"
4. Click "Tambah ke Keranjang"
5. Enter quantity: 2
6. Verify cart badge shows "2"

### Test Checkout
1. Click cart icon
2. Click "Lanjut ke Checkout"
3. Enter phone: `081234567890`
4. Enter address: `Jln. Contoh 123, Jakarta`
5. Click "Buat Pesanan"
6. See order confirmation

### Test Admin Order Management
1. Login as: `admin@example.com` / `password`
2. Click Admin Dashboard
3. Click "📋 Kelola Pesanan"
4. Click on any order
5. Change status: `pending` → `paid`
6. Click "💾 Simpan Status"
7. Return to list - verify status updated

---

## 🔧 Common Tasks

### Add New Product
```
Admin Dashboard → 🛠️ Kelola Produk → Tambah Produk
- Fill form with name, description, price, category, stock, image
- Click Save
```

### Create New Category
```
Admin Dashboard → 🗂️ Kelola Kategori → Create
- Enter category name
- Click Save
```

### Track Order as Customer
```
User Dashboard → 📋 Pesanan Saya
- Click order to see details
- See current status and shipping info
```

### Update Order Status as Admin
```
Admin Dashboard → 📋 Kelola Pesanan → Click Order
- Select new status from dropdown
- Click 💾 Simpan Status
- Status updates immediately
```

---

## ⚙️ Configuration

### Environment Variables (.env)
```
APP_NAME=ElectroHub
APP_URL=http://localhost:8000
DB_HOST=127.0.0.1
DB_DATABASE=electrohub
DB_USERNAME=root
DB_PASSWORD=
```

### Database Connection
```bash
# If using different MySQL settings
php artisan config:clear
# Then update .env with your database credentials
php artisan migrate
```

---

## 🐛 Troubleshooting

### "Database connection failed"
```bash
# Check MySQL is running
# Update .env with correct credentials
# Run: php artisan migrate
```

### "Images not showing"
```bash
php artisan storage:link
```

### "404 Not Found"
```bash
# Routes not registered - check routes/web.php
php artisan route:list
```

### "Cart not working"
```bash
# Clear cache
php artisan cache:clear
# Check auth middleware in routes
```

---

## 📊 Sample Data

After running `php artisan db:seed`:

**Products:** 10 sample electronics products
**Categories:** 5 categories (Elektronik, Aksesoris, Software, Perlengkapan, Gadget)
**Users:** 5 test accounts
**Orders:** 15 sample orders with various statuses

---

## 🚀 Next Steps

1. ✅ Complete the Quick Start setup above
2. ✅ Login with provided credentials
3. ✅ Test shopping flow (browse → add → checkout)
4. ✅ Test admin features (manage products & orders)
5. ✅ Run tests from `TESTING_GUIDE.md`
6. ✅ Customize colors and branding
7. ✅ Add payment gateway integration
8. ✅ Deploy to production

---

## 📚 More Documentation

- **Full Setup:** See `ECOMMERCE_README.md`
- **Testing:** See `TESTING_GUIDE.md`
- **API Routes:** Run `php artisan route:list`

---

## 💡 Tips

- **Admin account required?** Create one: `php artisan db:seed --class=AdminUserSeeder`
- **Reset database?** Run: `php artisan migrate:refresh --seed`
- **View logs?** Check: `storage/logs/laravel.log`
- **Debug mode?** Set `APP_DEBUG=true` in `.env`

---

## ✨ You're Ready!

Your ElectroHub e-commerce platform is now running. Start selling! 🎉

**Questions?** Check the docs or run:
```bash
php artisan tinker
```

---

**Version:** 1.0.0  
**Last Updated:** November 29, 2024  
**Status:** ✅ Production Ready

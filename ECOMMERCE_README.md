# 🛒 ElectroHub - E-Commerce Platform

A modern, user-friendly e-commerce platform built with Laravel 12, featuring complete product browsing, shopping cart, order management, and admin sales dashboard.

## 🚀 Features

### For Customers
- ✅ Browse products with category filtering and search
- ✅ Add items to shopping cart with quantity management
- ✅ Secure checkout with address and phone collection
- ✅ Order tracking with real-time status updates
- ✅ Order history and order detail view
- ✅ User-friendly navigation with cart badge

### For Admins
- ✅ Complete product management (CRUD)
- ✅ Category management
- ✅ User management
- ✅ Order management with status tracking
- ✅ Sales dashboard with revenue metrics
- ✅ Recent orders and activity monitoring

### Technical Features
- 🔒 Role-based authentication (Admin/User)
- 🛡️ Stock validation and inventory management
- 💰 Order summary with automatic calculations
- 📱 Responsive Bootstrap 5 design
- 🎨 Professional UI with emoji icons for better UX
- 📊 Real-time sales analytics

## 📋 Project Structure

```
ElectroHub/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Cart.php              [NEW]
│   │   ├── CartItem.php          [NEW]
│   │   ├── Order.php             [ENHANCED]
│   │   └── OrderItem.php         [NEW]
│   └── Http/Controllers/
│       ├── CartController.php     [NEW]
│       ├── CheckoutController.php [NEW]
│       ├── OrderController.php    [NEW]
│       └── AdminDashboardController.php [ENHANCED]
├── resources/views/
│   ├── cart/
│   │   └── index.blade.php       [NEW]
│   ├── checkout/
│   │   └── show.blade.php        [NEW]
│   ├── orders/
│   │   ├── index.blade.php       [NEW]
│   │   ├── show.blade.php        [NEW]
│   │   └── create.blade.php      [NEW]
│   ├── admin/
│   │   ├── orders/
│   │   │   ├── index.blade.php   [NEW]
│   │   │   └── show.blade.php    [NEW]
│   │   └── dashboard.blade.php   [ENHANCED]
│   ├── layouts/
│   │   └── navbar.blade.php      [ENHANCED]
│   └── products/
│       └── show.blade.php        [ENHANCED]
├── routes/
│   └── web.php                   [ENHANCED]
├── database/
│   ├── migrations/
│   │   ├── *_create_carts_table.php
│   │   ├── *_create_cart_items_table.php
│   │   ├── *_create_orders_table.php
│   │   └── *_create_order_items_table.php
│   └── seeders/
│       ├── AdminUserSeeder.php
│       ├── CategorySeeder.php
│       ├── OrderSeeder.php       [NEW]
│       └── DatabaseSeeder.php    [ENHANCED]
└── README.md                      [THIS FILE]
```

## 🛠️ Installation & Setup

### Prerequisites
- PHP 8.3+
- MySQL 5.7+
- Composer
- Node.js & npm

### Installation Steps

1. **Clone & Install Dependencies**
   ```bash
   cd PROJEK_KELOMPOK
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   # Create database (in MySQL)
   # mysql> CREATE DATABASE electrohub;
   
   # Run migrations
   php artisan migrate
   
   # Seed initial data
   php artisan db:seed
   ```

4. **File Storage**
   ```bash
   php artisan storage:link
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   npm run dev  # In another terminal
   ```

6. **Access Application**
   - Open http://localhost:8000
   - Admin Login: email: `admin@example.com` | password: `password`

## 📝 Usage Guide

### For Users

#### 1. Browse Products
- Go to "📦 Produk" in navbar
- Browse all products or filter by category
- Click on product to see details

#### 2. Add to Cart
- Click "Tambah ke Keranjang"
- Enter desired quantity
- Click add button

#### 3. Checkout
- Click "🛒 Keranjang" in navbar
- Review items and quantities
- Click "Lanjut ke Checkout"
- Enter shipping address and phone
- Review order summary
- Click "Buat Pesanan"

#### 4. Track Order
- Click "📋 Pesanan Saya" in navbar or user dropdown
- View all past orders
- Click "Lihat Detail" to see order status
- Track current status and shipping info

### For Admins

#### 1. Dashboard
- Access "/admin" or click "👨‍💼 Admin Dashboard"
- View sales metrics:
  - 💰 Total Revenue (completed orders)
  - ✅ Completed Orders
  - ⏳ Pending Orders
  - 📦 Total Products
- See recent orders and products

#### 2. Manage Products
- Click "🛠️ Kelola Produk" in dropdown
- Create new products with name, description, price, category, stock, image
- Edit existing products
- Delete products

#### 3. Manage Orders
- Click "📋 Kelola Pesanan" in dropdown
- View all customer orders
- Click on order to see details
- Update order status:
  - ⏳ Menunggu Pembayaran (Pending)
  - ✅ Dibayar (Paid)
  - 🔄 Sedang Diproses (Processing)
  - 🚚 Dikirim (Shipped)
  - ✨ Selesai (Completed)
  - ❌ Dibatalkan (Cancelled)

#### 4. Manage Categories
- Click "🗂️ Kelola Kategori"
- Add new categories
- Edit/Delete existing categories

#### 5. Manage Users
- Click "👤 Kelola Pengguna"
- View all registered users
- Edit user information
- Delete users if needed

## 🔄 Database Schema

### Orders Table
```sql
orders:
  - id (PK)
  - user_id (FK → users)
  - total_price (DECIMAL)
  - status (ENUM: pending, paid, processing, shipped, completed, cancelled)
  - address (VARCHAR)
  - phone (VARCHAR)
  - timestamps
```

### Order Items Table
```sql
order_items:
  - id (PK)
  - order_id (FK → orders)
  - product_id (FK → products)
  - quantity (INT)
  - price (DECIMAL) -- Snapshot of price at purchase time
  - timestamps
```

### Carts Table
```sql
carts:
  - id (PK)
  - user_id (FK → users)
  - timestamps
```

### Cart Items Table
```sql
cart_items:
  - id (PK)
  - cart_id (FK → carts)
  - product_id (FK → products)
  - quantity (INT)
  - timestamps
```

## 🔐 Authentication & Authorization

### Roles
- **Admin**: Full access to dashboard, product/order/user management
- **User**: Browse products, add to cart, checkout, track orders

### Middleware
- `auth`: Requires user to be logged in
- `role:admin`: Requires admin role (for admin routes)

## 💰 Order Processing Flow

1. **User adds products to cart**
   - System validates stock availability
   - CartItem created/updated with quantity

2. **User proceeds to checkout**
   - System validates cart is not empty
   - Calculate order total

3. **User enters shipping details & confirms**
   - System creates Order record
   - Creates OrderItem records for each product
   - Reduces product stock
   - Clears user's cart
   - Status set to "pending" (awaiting payment)

4. **Admin receives and processes order**
   - View order in admin dashboard
   - Admin marks as "paid" when payment received
   - Updates status through processing → shipped → completed

5. **Customer tracks order**
   - Can view order detail anytime
   - Sees current status and shipping info
   - Receives status updates

## 🧪 Testing

### Manual Testing Checklist

- [ ] User Registration & Login
- [ ] Browse Products by Category
- [ ] Search Products
- [ ] Add Product to Cart
- [ ] Update Cart Quantities
- [ ] Remove Cart Items
- [ ] Clear Cart
- [ ] Proceed to Checkout
- [ ] Complete Checkout Form
- [ ] Create Order
- [ ] View Order List
- [ ] View Order Details
- [ ] Admin View Dashboard
- [ ] Admin Manage Orders
- [ ] Admin Update Order Status
- [ ] Admin Manage Products
- [ ] Admin Dashboard Analytics Update

### Sample Test Data

After running seeders, you can test with:
- **Admin Account**: admin@example.com / password
- **Sample Orders**: Created with various statuses in OrderSeeder
- **Categories**: Elektronik, Aksesoris, Software, Perlengkapan, Gadget

## 🎨 UI/UX Highlights

### Navbar Features
- 🛒 Shopping cart badge with item count
- 👤 User dropdown with role-based options
- 🔐 Login/Register for guests
- 📱 Responsive mobile navigation

### Shopping Flow
- 📦 Product detail with stock indicator
- 🛒 Quantity picker before adding to cart
- 💰 Real-time price calculations
- ✅ Confirmation with success messages
- 📋 Order tracking with status badges

### Admin Interface
- 📊 Sales dashboard with key metrics
- 📈 Revenue tracking
- 🔄 Status update form on orders
- 📱 Responsive admin tables

## 📱 Responsive Design

All views are designed to work on:
- 📱 Mobile devices (320px+)
- 📱 Tablets (768px+)
- 💻 Desktops (1024px+)

Bootstrap 5 grid system ensures excellent responsive behavior.

## 🐛 Troubleshooting

### Cart not showing count
- Ensure user is authenticated
- Check `Cart` relationship in User model
- Verify migrations ran: `php artisan migrate:status`

### Product images not displaying
- Run `php artisan storage:link`
- Check file exists in `storage/app/public/`
- Verify `.env` has correct APP_URL

### Orders not showing in admin dashboard
- Ensure user has role 'admin'
- Check middleware is applied to admin routes
- Verify Order model relationships

### Stock validation issues
- Check product.stock column is numeric
- Verify CartController and CheckoutController validations
- Test with: `php artisan tinker` → `Product::first()->stock`

## 📚 API Routes Reference

### User Routes (Authenticated)
- `GET /products` - Browse all products
- `POST /cart/add/{product}` - Add to cart
- `POST /cart/update/{cartItem}` - Update quantity
- `POST /cart/remove/{cartItem}` - Remove item
- `POST /cart/clear` - Clear entire cart
- `GET /checkout` - Show checkout form
- `POST /checkout/process` - Process order
- `GET /orders` - List user's orders
- `GET /orders/{order}` - View order detail

### Admin Routes
- `GET /admin` - Dashboard
- `GET /admin/products` - List products
- `POST /admin/products` - Create product
- `GET /admin/products/{product}/edit` - Edit form
- `PUT /admin/products/{product}` - Update product
- `DELETE /admin/products/{product}` - Delete product
- `GET /admin/orders` - List all orders
- `GET /admin/orders/{order}` - View order detail
- `POST /admin/orders/{order}/status` - Update status

## 🚀 Performance Tips

1. **Enable Query Caching**: Update `.env` for cache driver
2. **Use CDN**: Serve static assets from CDN in production
3. **Database Indexing**: Ensure foreign keys are indexed
4. **Pagination**: Orders and products use pagination (15 per page)

## 📄 License

This project is built as an educational e-commerce platform.

## 👥 Team

Project created as part of PROJEK_KELOMPOK (Group Project).

---

**Version**: 1.0.0  
**Last Updated**: November 2024  
**Status**: ✅ Fully Functional

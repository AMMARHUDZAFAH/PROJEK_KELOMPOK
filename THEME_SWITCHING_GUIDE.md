# 🌓 Theme Switching - Lokasi Kode & Penjelasan

## 📍 LOKASI KODE YANG MENGUBAH WARNA

### 1️⃣ **JavaScript: Theme Toggle Logic**
📁 **File:** `public/js/custom.js` (Lines 136-165)

**Apa yang dilakukan:**
- Mendengarkan klik pada tombol toggle (#modeToggle)
- Menambahatau menghapus class `day-mode` pada element `<body>`
- Menyimpan preferensi ke localStorage dengan key `'mode'` (value: `'day'` atau `'night'`)
- Mengubah ikon dari 🌙 (malam) menjadi 🌞 (siang)

**Kode:**
```javascript
const toggleBtn = document.getElementById('modeToggle');

if(toggleBtn) {
    toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('day-mode');
        
        if (document.body.classList.contains('day-mode')) {
            // Mode siang aktif
            localStorage.setItem('mode','day');
        } else {
            // Mode malam aktif
            localStorage.setItem('mode','night');
        }
    });
}
```

**Cara Kerja:**
- Ketika tombol diklik → `day-mode` class toggle on/off pada `<body>`
- Jika `<body>` memiliki class `day-mode` → CSS menggunakan selector `body.day-mode`
- Jika `<body>` TIDAK memiliki class `day-mode` → CSS menggunakan selector `body:not(.day-mode)`

---

### 2️⃣ **Global CSS: Color Rules**
📁 **File:** `public/css/custom.css` (Lines 500-550)

**Apa yang dilakukan:**
- Mendefinisikan warna teks untuk `.text-black` dan `.text-white` di kedua mode
- Menggunakan selector `body.day-mode` dan `body:not(.day-mode)` untuk membedakan mode

**Kode (Day Mode):**
```css
body.day-mode .text-black {
    color: #000 !important;          /* Teks hitam di siang */
}

body.day-mode .text-white {
    color: #000 !important;          /* Override .text-white menjadi hitam */
}
```

**Kode (Night Mode):**
```css
body:not(.day-mode) .text-white {
    color: rgba(255,255,255,0.95) !important;  /* Teks putih di malam */
}

body:not(.day-mode) .text-white-50 {
    color: rgba(255,255,255,0.7) !important;
}
```

---

### 3️⃣ **Tabel Admin: View-Scoped CSS**
📁 **Files:**
- `resources/views/admin/products/index.blade.php` (Lines 55-70)
- `resources/views/admin/users/index.blade.php` (Lines 54-80)
- `resources/views/admin/categories/index.blade.php` (Lines 88-115)
- `resources/views/admin/orders/index.blade.php` (Lines 60-85)

**Apa yang dilakukan:**
- Meng-override warna latar belakang dan teks table saat theme berubah
- Menggunakan `!important` agar CSS override Bootstrap defaults
- Mendukung KEDUA sistem: `.day-mode` custom system DAN `data-bs-theme` Bootstrap system

**Kode Contoh (dari products/index.blade.php):**
```css
/* CUSTOM SYSTEM - Night Mode (body tanpa class day-mode) */
body:not(.day-mode) .table.text-white tbody td {
    background-color: rgba(20,20,30,0.8) !important;  /* Latar belakang gelap */
    color: #fff !important;                            /* Teks putih */
}

/* CUSTOM SYSTEM - Day Mode (body dengan class day-mode) */
body.day-mode .table.text-white td {
    background-color: #fff !important;                 /* Latar belakang putih */
    color: #212529 !important;                         /* Teks hitam */
}

/* BOOTSTRAP SYSTEM - Dark Mode (html dengan data-bs-theme="dark") */
html[data-bs-theme="dark"] .table.text-white tbody td {
    background-color: rgba(20,20,30,0.8) !important;
    color: #fff !important;
}

/* BOOTSTRAP SYSTEM - Light Mode (html dengan data-bs-theme="light") */
html[data-bs-theme="light"] .table.text-white td {
    background-color: #fff !important;
    color: #212529 !important;
}
```

---

## 🔄 URUTAN PERUBAHAN WARNA (Flow)

```
1. User Klik Tombol Toggle (#modeToggle)
   ↓
2. JavaScript Toggle `day-mode` Class pada <body>
   ↓
3. Browser Deteksi Perubahan Class
   ↓
4. CSS Selector Berubah:
   - MALAM: body:not(.day-mode) → Warna PUTIH
   - SIANG: body.day-mode → Warna HITAM
   ↓
5. Semua Element dengan Class `.text-black` / `.text-white`
   Mengikuti CSS Rules Baru
   ↓
6. localStorage Simpan Preferensi untuk Next Visit
```

---

## 🎯 CSS Specificity (Prioritas)

**Urutan dari yang PALING KUAT:**

1. **Inline `style=""` (PALING KUAT)**
   ```html
   <td style="color: red">Teks Merah</td>  <!-- Paling kuat -->
   ```

2. **CSS dengan `!important`**
   ```css
   color: red !important;  /* Sangat kuat */
   ```

3. **ID Selector**
   ```css
   #myTable td { color: red; }
   ```

4. **Class Selector (Sama kuat, tergantung urutan)**
   ```css
   body.day-mode .text-white { color: black; }
   body:not(.day-mode) .text-white { color: white; }
   ```

5. **Element Selector (PALING LEMAH)**
   ```css
   td { color: red; }
   ```

**KENAPA PAKAI `!important`?**
- Karena `.text-white` dari Bootstrap juga pakai `!important`
- Agar CSS kita override Bootstrap tanpa masalah
- Prioritas: Custom CSS `!important` > Bootstrap `.text-white` `!important`
  (karena urutan load, file custom.css dimuat SETELAH Bootstrap CSS)

---

## 🧪 Cara Testing

### Test 1: Cek Perubahan Class pada Inspector
```javascript
// Buka Browser DevTools (F12)
// Klik Inspect Element
// Perhatikan <body> tag

// Siang Mode (ada class):
<body class="day-mode">

// Malam Mode (tidak ada class):
<body>
```

### Test 2: Cek localStorage
```javascript
// Buka Console (F12 → Console tab)
// Ketik:
localStorage.getItem('mode')

// Output:
// "day"   → Mode siang
// "night" → Mode malam
```

### Test 3: Cek CSS yang Berlaku
```javascript
// Buka Console (F12 → Console tab)
// Ketik:
const td = document.querySelector('table td');
const color = window.getComputedStyle(td).color;
console.log(color);

// Output:
// rgb(255, 255, 255)  → Warna putih (malam)
// rgb(33, 37, 41)     → Warna hitam (siang)
```

---

## ⚙️ Jika Ingin Mengubah Warna

### Mengubah Warna Malam (Night Mode - Putih)
📁 **File:** `public/css/custom.css` (Line ~525)

Cari:
```css
body:not(.day-mode) .text-white {
    color: rgba(255,255,255,0.95) !important;  ← UBAH DI SINI
}
```

Ubah ke warna lain, misal:
```css
body:not(.day-mode) .text-white {
    color: #cccccc !important;  /* Putih lebih terang */
}
```

### Mengubah Warna Siang (Day Mode - Hitam)
📁 **File:** `public/css/custom.css` (Line ~508)

Cari:
```css
body.day-mode .text-black {
    color: #000 !important;  ← UBAH DI SINI
}
```

Ubah ke warna lain, misal:
```css
body.day-mode .text-black {
    color: #333333 !important;  /* Hitam lebih terang */
}
```

### Mengubah Warna di Table Malam
📁 **File:** `resources/views/admin/products/index.blade.php` (Line ~63)

Cari:
```css
body:not(.day-mode) .table.text-white tbody td {
    background-color: rgba(20,20,30,0.8) !important;  ← LATAR BELAKANG
    color: #fff !important;  ← WARNA TEKS
}
```

---

## 📋 Checklist CSS Rules (HARUS ADA)

- ✅ `body.day-mode` selector untuk mode siang
- ✅ `body:not(.day-mode)` selector untuk mode malam
- ✅ `html[data-bs-theme="light"]` selector untuk Bootstrap light mode
- ✅ `html[data-bs-theme="dark"]` selector untuk Bootstrap dark mode
- ✅ Semua rules dengan `!important` untuk override Bootstrap
- ✅ Kombinasi rules untuk `.text-black` + `.text-white`
- ✅ View-scoped CSS untuk table background + text color

---

## 🎓 Kesimpulan

**Sistem Switching Bekerja Dengan Mekanisme:**

1. **JavaScript** → Toggle class `day-mode` pada `<body>`
2. **CSS Selector** → Mendeteksi ada/tidaknya class via `body.day-mode` atau `body:not(.day-mode)`
3. **Color Rules** → Apply warna berbeda berdasarkan selector
4. **localStorage** → Ingat preferensi user saat refresh halaman

**Saat User Klik Tombol Toggle:**
- Semua element dengan `.text-white` berubah dari putih → hitam (atau sebaliknya)
- Tabel background berubah otomatis
- Icon button berubah dari 🌙 → 🌞 (atau sebaliknya)
- Preferensi disimpan ke browser memory

**Kalau Ada Masalah:**
1. Pastikan CSS punya `!important`
2. Pastikan selector `body.day-mode` atau `body:not(.day-mode)` benar
3. Clear browser cache (Ctrl+Shift+Delete)
4. Clear Laravel view cache (`php artisan view:clear`)
5. Inspect element (F12) dan cek computed styles

---

**Terakhir Diupdate:** `php artisan view:clear` ✅

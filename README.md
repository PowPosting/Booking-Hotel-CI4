# 🏨 Hotel Booking System

Sistem manajemen hotel modern yang dibangun menggunakan CodeIgniter 4, menyediakan fitur lengkap untuk pemesanan kamar hotel dengan antarmuka yang user-friendly dan sistem administrasi yang komprehensif.

## ✨ Fitur Utama

### 🔐 Sistem Autentikasi
- **Login & Register** dengan validasi regex (minimal 6 karakter, kombinasi huruf & angka)
- **Session Management** untuk keamanan pengguna
- **Password Security** dengan hashing yang aman

### 🏠 Manajemen Kamar
- **3 Tipe Kamar**: Standard, Deluxe, Suite
- **Gallery Images** dengan carousel untuk setiap kamar
- **Room Details** dengan modal informasi lengkap  
- **Price Display** tanpa animasi zoom yang mengganggu
- **Availability Check** berdasarkan tanggal

### 🛒 Sistem Keranjang
- **Add to Cart** dengan validasi form lengkap
- **Guest Information** input (nama, email, telepon)
- **Date Selection** check-in & check-out
- **Real-time Validation** untuk mencegah error

### 📋 Terms & Conditions  
- **Modal Lengkap** dengan 8 bagian komprehensif:
  - Ketentuan Pemesanan
  - Kebijakan Pembayaran  
  - Check-in & Check-out
  - Kebijakan Pembatalan
  - Fasilitas Hotel
  - Peraturan Hotel
  - Kontak & Bantuan
  - Force Majeure
- **Interactive Accept** dengan checkbox otomatis

### 🔔 Sistem Notifikasi
- **Real-time Notifications** untuk status booking
- **Detailed View** saat klik notifikasi
- **Status Tracking**: pending, confirmed, paid, cancelled
- **Visual Indicators** dengan warna dan icon
- **All Notifications Modal** untuk melihat riwayat lengkap

### ⚙️ Admin Dashboard (No Session Required)
- **Direct Access** tanpa perlu login
- **Booking Management** - lihat & update status
- **Room Management** - kelola ketersediaan kamar
- **User Management** - data pengguna
- **Payment Status** - tracking pembayaran

## 🛠️ Teknologi yang Digunakan

- **Backend**: CodeIgniter 4
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Database**: MySQL
- **Icons**: Font Awesome
- **UI Components**: Bootstrap Modal, Carousel, Cards
- **Validation**: Client & Server-side validation

## 📱 Responsive Design

- ✅ **Mobile Friendly** - Optimized untuk semua device
- ✅ **Tablet Support** - Layout adaptif
- ✅ **Desktop Experience** - Full featured interface

## 🚀 Instalasi

### Prerequisites
- PHP 7.4 atau lebih tinggi
- MySQL 5.7+
- Composer
- Web server (Apache/Nginx) atau Laragon

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd Hotel
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Database Setup**
   ```sql
   CREATE DATABASE hotel_booking;
   ```
   Import file SQL yang disediakan atau setup table manual.

4. **Environment Configuration**
   ```bash
   cp env .env
   ```
   Edit `.env` file:
   ```
   database.default.hostname = localhost
   database.default.database = hotel_booking
   database.default.username = your_username
   database.default.password = your_password
   ```

5. **Run Application**
   ```bash
   php spark serve
   ```
   Akses: `http://localhost:8080`

## 📊 Database Structure

### Tables Utama:
- **users** - Data pengguna
- **rooms** - Informasi kamar  
- **bookings** - Data pemesanan
- **cart_items** - Keranjang sementara

## 🎯 Usage

### Untuk Pengguna:
1. **Register/Login** dengan akun baru
2. **Browse Rooms** - lihat tipe kamar tersedia
3. **Select Dates** - pilih tanggal check-in/out
4. **Add to Cart** - masukkan data tamu
5. **Review Booking** - cek detail pemesanan
6. **Payment** - lakukan pembayaran
7. **Track Status** - pantau via notifikasi

### Untuk Admin:
1. **Akses Dashboard**: `/admin/dashboard`
2. **Manage Bookings**: Update status & payment
3. **Manage Rooms**: Set availability & pricing  
4. **View Reports**: Monitor hotel performance

## 🔧 Configuration

### Room Types Setup:
```php
// app/Views/partials/rooms.php
$rooms = [
    'standard' => [
        'name' => 'Kamar Standard',
        'price' => 800000,
        'image' => 'images/Kamarstandar.jpg'
    ],
    // ... more rooms
];
```

### Notification Settings:
```php
// app/Controllers/Booking.php
protected function getBookingStatusInfo($bookingStatus, $paymentStatus) {
    // Custom status logic
}
```

## 🐛 Troubleshooting

### Common Issues:

1. **Cart tidak berfungsi**:
   - Pastikan user sudah login
   - Check console untuk JavaScript errors
   - Verify cart route di `routes.php`

2. **Image tidak muncul**:
   - Pastikan folder `public/images/` ada
   - Check file permissions
   - Verify image paths di code

3. **Database connection error**:
   - Check `.env` database configuration
   - Ensure MySQL service running
   - Verify database exists

## 📈 Future Enhancements

- [ ] **Payment Gateway Integration** (Midtrans, Xendit)
- [ ] **Email Notifications** untuk booking confirmation
- [ ] **SMS Gateway** untuk update status
- [ ] **Multi-language Support** (EN/ID)
- [ ] **Advanced Reporting** dengan charts
- [ ] **Room Service Integration**
- [ ] **Mobile App** dengan API

## 👨‍💻 Development

### Code Structure:
```
app/
├── Controllers/
│   ├── Auth.php          # Authentication
│   ├── Home.php          # Main pages
│   ├── Booking.php       # Booking management
│   ├── Cart.php          # Shopping cart
│   └── Admin.php         # Admin functions
├── Models/
│   ├── UserModel.php     # User data
│   ├── RoomModel.php     # Room data
│   ├── BookingModel.php  # Booking data
│   └── CartModel.php     # Cart data
└── Views/
    ├── partials/         # Reusable components
    ├── admin/           # Admin interface
    └── auth/            # Login/register
```

### Styling Guidelines:
- **Bootstrap 5** untuk layout
- **Custom CSS** di setiap view file
- **Font Awesome** untuk icons
- **Consistent Color Scheme**: Primary (#4a6cfa), Success, Warning, Danger

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Contact & Support

- **Developer**: Hotel Booking Team
- **Email**: support@hotelbooking.com
- **GitHub**: [Repository Link]
- **Documentation**: [Wiki Link]

---

## 🎉 Acknowledgments

- **CodeIgniter 4** framework
- **Bootstrap** untuk UI components  
- **Font Awesome** untuk iconography
- **Contributors** yang telah membantu development

---

**⭐ Jika project ini membantu, jangan lupa beri star di GitHub!**

**🚀 Happy Coding & Happy Booking!**

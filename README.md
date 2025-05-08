<p align="center"><strong>Jobsy - Sistem penjualan dan penyewaan alat camping</strong></p>

<div align="center">

![logo_unsulbar](public/image.png)



<b>Nursadila</b><br>
<b>D0222049</b><br>
<b>Framework Web Based</b><br>
<b>2025</b>
</div>

---


## Fitur dan Role

### Pelanggan
- **Registrasi & Login**: Pelanggan dapat membuat akun, login, dan reset password.
- **Pencarian Produk**: Pelanggan dapat mencari dan melihat daftar produk camping.
- **Penyewaan & Pembelian**: Pelanggan dapat membeli atau menyewa alat camping, mengisi formulir penyewaan, dan melakukan pembayaran.
- **Riwayat Transaksi**: Pelanggan dapat melihat riwayat pembelian dan penyewaan alat camping.
- **Ulasan**: Pelanggan dapat memberi rating dan komentar pada produk yang dibeli atau disewa.
- **Pesan Toko**: Pelanggan dapat mengirimkan pesan ke pemilik toko terkait produk atau informasi lainnya.

### Pemilik Toko
- **Manajemen Produk**: Pemilik toko dapat menambah, mengedit, atau menghapus produk yang dijual atau disewakan.
- **Manajemen Toko**: Pemilik toko dapat mengelola profil toko, termasuk foto toko, alamat, dan informasi rekening.
- **Transaksi**: Pemilik toko dapat melihat dan mengelola transaksi yang dilakukan oleh pelanggan.
- **Pemberitahuan Pesan**: Pemilik toko dapat membalas pesan yang dikirim oleh pelanggan.

### Admin
- **Manajemen Pengguna**: Admin dapat mengelola pengguna (pelanggan dan pemilik toko), termasuk blokir akun atau reset password.
- **Manajemen Toko**: Admin dapat melihat dan mengelola semua toko yang terdaftar.
- **Manajemen Produk**: Admin dapat memverifikasi produk yang ada, dan menghapus produk yang melanggar kebijakan.
- **Monitoring Transaksi**: Admin dapat memantau transaksi yang terjadi di seluruh sistem.

---
# Sistem Penjualan dan Penyewaan Alat Camping

Sistem ini mengelola penjualan dan penyewaan alat camping dengan beberapa role pengguna: pelanggan, pemilik toko, dan admin usaha rental mobil. Berikut adalah struktur database dan relasi antar tabel yang digunakan dalam aplikasi ini.

## Struktur Tabel

### 1. Tabel `user`
Tabel ini menyimpan data pengguna (pelanggan, pemilik toko, dan admin).

| Field         | Tipe Data           | Keterangan                                                   |
| ------------- | ------------------- | ------------------------------------------------------------ |
| `id`          | BIGINT(20) UNSIGNED  | Primary Key, Auto Increment                                  |
| `name`        | VARCHAR(255)         | Nama lengkap pengguna                                        |
| `email`       | VARCHAR(255)         | Email pengguna, harus unik                                   |
| `password`    | VARCHAR(255)         | Password yang di-hash                                         |
| `phone`       | VARCHAR(20)          | Nomor telepon pengguna                                       |
| `role`        | ENUM                 | Role pengguna: `pelanggan`, `pemilik`, `admin`               |
| `created_at`  | TIMESTAMP            | Timestamp pembuatan                                           |
| `updated_at`  | TIMESTAMP            | Timestamp pembaruan                                           |

### 2. Tabel `toko`
Tabel ini menyimpan data toko yang dimiliki oleh pengguna dengan role `pemilik`.

| Field         | Tipe Data           | Keterangan                                                   |
| ------------- | ------------------- | ------------------------------------------------------------ |
| `id`          | BIGINT(20) UNSIGNED  | Primary Key, Auto Increment                                  |
| `user_id`     | BIGINT(20) UNSIGNED  | Foreign Key (`user.id`), ID pemilik toko                    |
| `nama_toko`   | VARCHAR(100)         | Nama toko                                                    |
| `alamat`      | TEXT                 | Alamat toko                                                  |
| `kontak`      | VARCHAR(100)         | Kontak (WA atau HP)                                          |
| `rekening`    | VARCHAR(100)         | Nomor rekening toko                                          |
| `jenis_toko`  | ENUM                 | Jenis toko: `penjualan`, `penyewaan`                         |
| `foto_toko`   | VARCHAR(255)         | Path ke foto toko (opsional)                                 |
| `created_at`  | TIMESTAMP            | Timestamp pembuatan                                           |

### 3. Tabel `produk`
Tabel ini menyimpan data produk yang dijual atau disewakan oleh toko.

| Field         | Tipe Data           | Keterangan                                                   |
| ------------- | ------------------- | ------------------------------------------------------------ |
| `id`          | BIGINT(20) UNSIGNED  | Primary Key, Auto Increment                                  |
| `toko_id`     | BIGINT(20) UNSIGNED  | Foreign Key (`toko.id`), ID toko                             |
| `nama_produk` | VARCHAR(150)         | Nama produk                                                  |
| `deskripsi`   | TEXT                 | Deskripsi produk                                             |
| `harga`       | DECIMAL(10,2)        | Harga satuan produk                                          |
| `stok`        | INT                  | Jumlah stok produk tersedia                                  |
| `jenis_produk`| ENUM                 | Jenis produk: `penjualan`, `penyewaan`                       |
| `foto`        | VARCHAR(255)         | Path ke foto produk                                          |
| `created_at`  | TIMESTAMP            | Timestamp pembuatan                                           |

### 4. Tabel `transaksi`
Tabel ini menyimpan data transaksi pembelian atau penyewaan yang dilakukan oleh pelanggan.

| Field              | Tipe Data           | Keterangan                                                   |
| ------------------ | ------------------- | ------------------------------------------------------------ |
| `id`               | BIGINT(20) UNSIGNED  | Primary Key, Auto Increment                                  |
| `user_id`          | BIGINT(20) UNSIGNED  | Foreign Key (`user.id`), ID pelanggan                       |
| `toko_id`          | BIGINT(20) UNSIGNED  | Foreign Key (`toko.id`), ID toko                             |
| `total_harga`      | DECIMAL(10,2)        | Total harga transaksi                                        |
| `status`           | ENUM                 | Status transaksi: `pending`, `dibayar`, `gagal`              |
| `metode_pembayaran`| VARCHAR(50)          | Metode pembayaran (BRIVA, QRIS, dsb)                         |
| `bukti_pembayaran` | VARCHAR(255)         | Path ke file bukti pembayaran (opsional)                     |
| `jenis_transaksi`  | ENUM                 | Jenis transaksi: `pembelian`, `penyewaan`                    |
| `created_at`       | TIMESTAMP            | Timestamp pembuatan                                           |

### 5. Tabel `detail_transaksi`
Tabel ini menyimpan data detail dari setiap transaksi, termasuk produk yang dibeli atau disewa.

| Field              | Tipe Data           | Keterangan                                                   |
| ------------------ | ------------------- | ------------------------------------------------------------ |
| `id`               | BIGINT(20) UNSIGNED  | Primary Key, Auto Increment                                  |
| `transaksi_id`     | BIGINT(20) UNSIGNED  | Foreign Key (`transaksi.id`), ID transaksi                   |
| `produk_id`        | BIGINT(20) UNSIGNED  | Foreign Key (`produk.id`), ID produk                         |
| `jumlah`           | INT                  | Jumlah produk yang dibeli atau disewa                        |
| `harga_satuan`     | DECIMAL(10,2)        | Harga satuan produk pada saat transaksi                      |
| `tanggal_mulai`    | DATE                 | Tanggal mulai sewa (jika sewa)                               |
| `tanggal_selesai`  | DATE                 | Tanggal selesai sewa (jika sewa)                             |
| `created_at`       | TIMESTAMP            | Timestamp pembuatan                                           |

### 6. Tabel `pesan`
Tabel ini menyimpan data pesan antara pengguna (pemilik toko dan pelanggan).

| Field              | Tipe Data           | Keterangan                                                   |
| ------------------ | ------------------- | ------------------------------------------------------------ |
| `id`               | BIGINT(20) UNSIGNED  | Primary Key, Auto Increment                                  |
| `dari_user`        | BIGINT(20) UNSIGNED  | Foreign Key (`user.id`), Pengirim pesan                     |
| `ke_user`          | BIGINT(20) UNSIGNED  | Foreign Key (`user.id`), Penerima pesan                     |
| `isi_pesan`        | TEXT                 | Isi pesan yang dikirim                                       |
| `created_at`       | TIMESTAMP            | Timestamp pengiriman pesan                                    |

## 🔗 Relasi Antar Tabel

| Tabel Asal       | Tabel Tujuan        | Foreign Key         | Jenis Relasi   | Keterangan                                                                 |
|------------------|---------------------|---------------------|----------------|----------------------------------------------------------------------------|
| users            | toko                | toko.user_id        | One to One     | Satu user (pemilik) hanya memiliki satu toko                              |
| toko             | produk              | produk.toko_id      | One to Many    | Satu toko dapat memiliki banyak produk                                     |
| users            | transaksi           | transaksi.user_id   | One to Many    | Satu pelanggan dapat melakukan banyak transaksi                            |
| toko             | transaksi           | transaksi.toko_id   | One to Many    | Satu toko dapat memiliki banyak transaksi                                  |
| transaksi        | detail_transaksi    | detail_transaksi.transaksi_id | One to Many    | Satu transaksi memiliki banyak detail produk                               |
| produk           | detail_transaksi    | detail_transaksi.produk_id    | One to Many    | Satu produk dapat muncul di banyak detail transaksi                        |
| users            | pesan               | pesan.dari_user / pesan.ke_user | One to Many    | Satu user bisa mengirim dan menerima banyak pesan                          |

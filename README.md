# Sistem Analisis Kerusakan Bangunan & Neural Network

Website berbasis PHP dan MariaDB yang dibuat untuk mengelola data kerusakan bangunan serta melakukan perhitungan menggunakan metode Neural Network sederhana.

Project ini merupakan implementasi tugas mata kuliah yang menggabungkan konsep Database, Pemrograman Web, dan Artificial Intelligence (AI).

---

## Deskripsi Proyek

Project terdiri dari dua modul utama, yaitu:

### Sistem Kerusakan Bangunan

Modul yang digunakan untuk mengelola data kerusakan bangunan berdasarkan parameter A, B, C, D, dan E, serta melakukan normalisasi data menggunakan View pada MariaDB.

### Sistem Neural Network

Modul yang digunakan untuk melakukan perhitungan Neural Network sederhana berdasarkan bobot parameter yang telah ditentukan.

---

## Fitur Utama

### Sistem Kerusakan Bangunan

* Menambahkan data kerusakan bangunan
* Menyimpan data ke database MariaDB
* Menampilkan seluruh data yang tersimpan
* Melakukan normalisasi data menggunakan View

### Sistem Neural Network

* Menambahkan data parameter
* Menentukan bobot setiap parameter
* Menghitung nilai net input
* Menerapkan fungsi aktivasi
* Menampilkan hasil klasifikasi

---

## Teknologi yang Digunakan

| Teknologi | Fungsi                   |
| --------- | ------------------------ |
| PHP       | Backend                  |
| HTML5     | Struktur halaman         |
| CSS3      | Tampilan antarmuka       |
| MariaDB   | Database                 |
| Laragon   | Local development server |

---

## Struktur Folder

```text
project/
│
├── assets/
├── kerusakan_bangunan/
├── nn_kerusakan/
├── database.sql
└── index.php
```

---

## Database

Project ini menggunakan MariaDB dengan dua database utama.

### 1. db_kerusakan_bangunan

Database yang digunakan untuk menyimpan data kerusakan bangunan dan hasil normalisasi.

#### Struktur Database

Tabel:

* data_kerusakan

View:

* view_normalisasi

---

### 2. db_neural_network

Database yang digunakan untuk proses perhitungan Neural Network.

#### Struktur Database

Tabel:

* kerusakan
* parameter

View:

* view_hasil_nn

---

## Alur Sistem

### Sistem Kerusakan Bangunan

1. Pengguna menginput data kerusakan bangunan beserta nilai parameternya
2. Sistem memvalidasi data yang dimasukkan
3. Data disimpan ke database MariaDB
4. Sistem melakukan proses normalisasi
5. Sistem menampilkan data yang telah tersimpan

---

### Sistem Neural Network

1. Pengguna menginput data parameter yang akan diproses
2. Pengguna menentukan bobot untuk setiap parameter
3. Sistem menghitung nilai net input berdasarkan bobot yang diberikan
4. Sistem menerapkan fungsi aktivasi
5. Sistem menghasilkan output klasifikasi

---

## Cara Menjalankan Project

### 1. Download atau Clone Repository

```bash
git clone https://github.com/username/nama-repository.git
```

Atau download file ZIP.

### 2. Pindahkan Folder Project

Salin folder project ke:

```text
C:\laragon\www\
```

### 3. Jalankan Laragon

Aktifkan:

* Apache
* MariaDB

### 4. Import Database

Buka phpMyAdmin melalui Laragon, lalu import file `database.sql`.

### 5. Jalankan Aplikasi

Buka browser:

```
http://localhost/nama_project/
```

atau

```
http://nama_project.test
```

---

## Tujuan Pembuatan

Project ini dibuat untuk:

* Mengimplementasikan konsep database menggunakan MariaDB
* Mengimplementasikan pemrograman web menggunakan PHP
* Mengimplementasikan normalisasi data menggunakan View
* Mengimplementasikan Neural Network sederhana
* Memenuhi tugas mata kuliah

---

## Pengembang

Siti Alfinahur Salsabila
Teknik Informatika
UIN Maulana Malik Ibrahim Malang

---

## Lisensi

Project ini dibuat untuk keperluan pembelajaran dan akademik.

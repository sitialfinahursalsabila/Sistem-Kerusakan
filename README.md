**Alur Input-Proses-Output (kedua modul sama pola-nya):**
`index.php` (Input) → `aksi_insert.php` (validasi & simpan) → `proses.php`
(Proses, hitung & tampilkan rumus step-by-step) → `record.php` (Output, semua
data + hasil akhir dari VIEW).

**Catatan implementasi:**
- Hasil akhir normalisasi/NN yang ditampilkan **selalu diambil dari VIEW**,
  bukan dihitung ulang manual di setiap file PHP, supaya `proses.php` dan
  `record.php` selalu konsisten satu sumber data.
- `kerusakan_bangunan/aksi_insert.php` masih pakai `mysqli_query` biasa
  (rawan SQL injection), sedangkan `nn_kerusakan/` sudah pakai prepared
  statement (`mysqli_prepare`) — sebaiknya modul Soal 2 disamakan.

---

## 4. Struktur Database

### 4.1 `db_kerusakan_bangunan` (modul `kerusakan_bangunan/`)

```sql
CREATE DATABASE IF NOT EXISTS db_kerusakan_bangunan;
USE db_kerusakan_bangunan;

CREATE TABLE data_kerusakan (
    id_data VARCHAR(5)  NOT NULL PRIMARY KEY,   -- D1, D2, ... D5
    A       INT          NOT NULL,
    B       INT          NOT NULL,
    C       INT          NOT NULL,
    D       INT          NOT NULL,
    E       INT          NOT NULL
);

INSERT INTO data_kerusakan (id_data, A, B, C, D, E) VALUES
('D1', 3, 3, 3, 2, 3),
('D2', 3, 3, 3, 3, 2),
('D3', 2, 2, 2, 3, 2),
('D4', 2, 1, 2, 2, 3),
('D5', 1, 2, 2, 2, 3);

-- VIEW: seluruh nilai parameter sudah ternormalisasi (Persamaan 1)
CREATE VIEW view_normalisasi AS
SELECT
    id_data,
    A / (SELECT SQRT(SUM(A*A)) FROM data_kerusakan) AS A,
    B / (SELECT SQRT(SUM(B*B)) FROM data_kerusakan) AS B,
    C / (SELECT SQRT(SUM(C*C)) FROM data_kerusakan) AS C,
    D / (SELECT SQRT(SUM(D*D)) FROM data_kerusakan) AS D,
    E / (SELECT SQRT(SUM(E*E)) FROM data_kerusakan) AS E
FROM data_kerusakan;
```

**ERD ringkas:** 1 tabel (`data_kerusakan`) + 1 view (`view_normalisasi`,
struktur kolom identik, isi sudah ternormalisasi).

### 4.2 `db_neural_network` (modul `nn_kerusakan/`)

```sql
CREATE DATABASE IF NOT EXISTS db_neural_network;
USE db_neural_network;

-- Tabel 1: bobot parameter
CREATE TABLE parameter (
    kode_parameter  VARCHAR(5)     NOT NULL PRIMARY KEY,  -- 'A','B','C','D','E'
    nama_parameter  VARCHAR(50)    DEFAULT NULL,
    nilai_bobot     DECIMAL(5,2)   NOT NULL
);

INSERT INTO parameter (kode_parameter, nama_parameter, nilai_bobot) VALUES
('A', 'Parameter A', 3.0),
('B', 'Parameter B', 2.5),
('C', 'Parameter C', 2.0),
('D', 'Parameter D', 1.5),
('E', 'Parameter E', 1.0);

-- Tabel 2: data kerusakan + target
CREATE TABLE kerusakan (
    kode_data VARCHAR(5)  NOT NULL PRIMARY KEY,  -- D1..D5
    param_A   INT NOT NULL,
    param_B   INT NOT NULL,
    param_C   INT NOT NULL,
    param_D   INT NOT NULL,
    param_E   INT NOT NULL,
    target    INT NOT NULL
);

INSERT INTO kerusakan (kode_data, param_A, param_B, param_C, param_D, param_E, target) VALUES
('D1', 3, 3, 2, 3, 3, 3),
('D2', 3, 3, 3, 2, 3, 3),
('D3', 2, 2, 3, 2, 2, 2),
('D4', 1, 2, 2, 3, 2, 2),
('D5', 2, 2, 2, 3, 2, 2);

-- VIEW: proses NN lengkap (net input -> aktivasi -> output)
CREATE VIEW view_hasil_nn AS
SELECT
    k.kode_data,
    nt.net_input,
    CASE WHEN nt.net_input >= 1 THEN 'YA' ELSE 'TIDAK' END AS aktivasi,
    CASE WHEN nt.net_input >= 1 THEN 1 ELSE 0 END         AS output_nn
FROM kerusakan k
JOIN (
    SELECT
        k2.kode_data,
        (k2.param_A * pa.nilai_bobot +
         k2.param_B * pb.nilai_bobot +
         k2.param_C * pc.nilai_bobot +
         k2.param_D * pd.nilai_bobot +
         k2.param_E * pe.nilai_bobot) AS net_input
    FROM kerusakan k2
    JOIN parameter pa ON pa.kode_parameter = 'A'
    JOIN parameter pb ON pb.kode_parameter = 'B'
    JOIN parameter pc ON pc.kode_parameter = 'C'
    JOIN parameter pd ON pd.kode_parameter = 'D'
    JOIN parameter pe ON pe.kode_parameter = 'E'
) nt ON nt.kode_data = k.kode_data;
```

> ⚠️ Cek ulang urutan A-B-C-D-E Tabel 2 di lembar soal asli kamu sebelum
> insert seed data di atas — beberapa kombinasi nilai D2–D5 bisa beda urutan
> kolom dari yang tertulis di soal.

**ERD ringkas:** `parameter` ↔ `kerusakan` terhubung secara logis lewat VIEW
`view_hasil_nn` (bukan foreign key formal — bobot dipakai bersama oleh semua
baris `kerusakan` lewat join `kode_parameter`).

---

## 5. Cara Menjalankan (Laragon)

1. Import kedua skema SQL di atas lewat phpMyAdmin/HeidiSQL.
2. Letakkan folder `sistem_Kerusakan/` di `C:\laragon\www\`.
3. Buka `http://localhost/sistem_Kerusakan/` → pilih Soal 2 atau Soal 3.
4. Sesuaikan `koneksi.php` di masing-masing modul dengan user/password MySQL
   Laragon kamu (default `root` / tanpa password).

---

## 6. Catatan Pengembangan Lanjutan
- Samakan validasi input `kerusakan_bangunan/aksi_insert.php` ke prepared
  statement seperti di modul `nn_kerusakan/`.
- `nama_parameter` tidak diisi lewat form (form hanya kirim `nilai_bobot`) —
  isi manual lewat seed data, atau tambahkan field-nya ke form kalau mau
  dinamis.

---

## 7. Daftar Pustaka

1. Almais, A. T. W., Susilo, A., Naba, A., Sarosa, M., Crysdian, C.,
   Wicaksono, H., Tazi, I., Hariyadi, M. A., Muslim, M. A., Basid, P. M. N. S.
   A., Arif, Y. M., Purwanto, M. S., Parwatiningtyas, D., & Supriyono, S.
   (2023). Principal Component Analysis-Based Data Clustering for Labeling
   of Level Damage Sector in Post-Natural Disasters. *IEEE Access*.
   https://doi.org/10.1109/ACCESS.2023.3275852
2. Almais, A. T. W., Susilo, A., Naba, A., Tazi, I., dkk. (2024). SDDS:
   Damage Level Determination System for Post-Natural Disaster Sector Based
   on Building Characteristics. *The 18th IMT-GT International Conference on
   Mathematics, Statistics and their Applications*, Sciendo, 23–28.
   https://doi.org/10.2478/9788367405713-005

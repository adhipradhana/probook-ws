# :expressionless: Tugas 2 IF3110 Pengembangan Aplikasi Berbasis Web

### :file_folder: Basis Data

Basis data dari aplikasi yang kami buat terdiri dari 3, yakni Basis data aplikasi pro-book, Basis data webservice bank yang mengatur transaksi, dan Basis data webservice buku untuk mengakses data-data buku dari Google Books API

#### :blue_book: Basis Data Pro-book

* ActiveTokens :key:

Tabel ini berfungsi untuk menyimpan token dari user yang telah login. Berbeda dengan probook versi sebelumnya, pada token basis data versi ini juga menyimpan user-agent, ip address, serta flag google login, untuk menandakan apakah akun tersebut masuk melalui akun google atau tidak.

| Field                   | Type          |
|:-----------------------:|:-------------:|
| user_id                 | int(11)       |
| token                   | varchar(300)  |
| user_agent              | varchar(300)  |
| ip_address              | varchar(20)   |
| expiration_timestamp    | bigint(20)    |
| google_login            | tinyint(1)    |

* Orders :clipboard:

Tabel ini berfungsi untuk menyimpan order/pesanan yang telah berhasil.

| Field           | Type        |
|:---------------:|:-----------:|
| id              | int(11)     |
| user_id         | int(11)     |
| is_review       | tinyint(1)  |
| book_id         | varchar(50) |
| amount          | int(11)     |
| order_timestamp | bigint(20)  |

* Reviews :page_with_curl:

Tabel ini berfungsi untuk menyimpan review seorang user terhadap buku yang dijual di probook. 

| Field    | Type         |
|:--------:|:------------:|
| id       | int(11)      |
| rating   | float        |
| comment  | varchar(500) |
| book_id  | varchar(50)  |
| username | varchar(300) |
| user_id  | int(11)      |

* Users :hear_no_evil:

Tabel ini berfungsi untuk menyimpan user-user yang telah terdaftar.

| Field       | Type         |
|:-----------:|:------------:|
| id          | int(11)      |
| name        | varchar(255) |
| username    | varchar(255) |
| email       | varchar(255) |
| password    | varchar(255) |
| address     | varchar(255) |
| phonenumber | varchar(255) |
| cardnumber  | varchar(16)  |

#### :bank: Basis Data Webservice Bank

* Accounts :credit_card:

Tabel ini berfungsi untuk menyimpan akun-akun bank yang telah terdaftar beserta detail-detailnya seperti saldo, kode totp, dll.

| Field      | Type         |
|:----------:|:------------:|
| id         | int(11)      |
| cardNumber | varchar(16)  |
| name       | varchar(255) |
| balance    | bigint(20)   |
| totpSecret | varchar(52)  |
| createdAt  | datetime     |
| updatedAt  | datetime     |

* Merchants :goberserk:

Tabel ini berfungsi untuk menyimpan akun bank milik merchant-merchant, salah satunya adalah akun dari probook.

| Field     | Type         |
|:---------:|:------------:|
| id        | int(11)      |
| accountId | int(11)      |
| name      | varchar(255) |
| apiKey    | varchar(24)  |
| createdAt | datetime     |
| updatedAt | datetime     |

* Transactions :money_with_wings:

Tabel ini berfungsi untuk menyimpan transaksi yang telah berhasil ditangani oleh bank service, beserta detail dari transaksi tersebut.

| Field      | Type     |
|:----------:|:--------:|
| id         | int(11)  |
| senderId   | int(11)  |
| receiverId | int(11)  |
| amount     | float    |
| timeStamp  | datetime |
| createdAt  | datetime |
| updatedAt  | datetime |

#### :book: Basis Data Webservice Book

* Books :books:

Tabel ini untuk menyimpan buku yang dijual oleh probook. Berbeda dengan probook sebelumnya, id yang disimpan pada tabel ini adalah tabel buku yang ada di google books API. Rating juga disimpan di tabel ini.

| Field        | Type         |
|:------------:|:------------:|
| id           | varchar(50)  |
| rating       | decimal(5,1) |
| price        | int(10)      |
| rating_count | int(5)       |

* Sales :chart_with_upwards_trend:

Tabel ini udah menyimpan total penjualan pada masing-masing genre, untuk kemudian menjadi pertimbangan dalam rekomendasi buku yang diberikan oleh probook.

| Field       | Type         |
|:-----------:|:------------:|
| id          | varchar(100) |
| genre       | varchar(50)  |
| total_sales | int(10)      |

### :computer: Shared Session 

Respresentational State Transfer atau REST adalah sebuah konsep dalam melakukan shared session / state transfer pada web yang bersifat stateless. Sering kali REST diimplementasikan diatas HTTP. Konsep yang terdapat dalam REST meliputi resource, server untuk menampung resource tersebut, client yang akan melakukan request pada server, interaksi antara client dan server berupa request dan response, serta representasi, yakni dokumen yang berisi status terhadap resource yang bersangkutan.

:boom: Prinsip-prinsip yang perlu diketahui pada REST antara lain:

* State dari sebuah resource harus tersembunyi dan diketahui hanya oleh internal dari server
* Server tidak mengetahui status dari client
* Request dari client mengandung semua informasi yang diperlukan untuk diproses server
* Session state disimpan pada client side
* Resource dapat memiliki beberapa bentuk respresentation
* Response mengindikasikan cacheability (bisa dan perlu dicached atau tidak)
* Client dapat melakukan fetching terhadap sebagian code server jika dibutuhkan (Opsional)

### :cookie: Mekanisme Pembangkitan Token dan Expiry Time

User melakukan input username dan password pada saat login/register. Kemudian, user akan mendapatkan token yang telah dibangkitkan. Token ini berguna untuk menentukan resource mana yang bisa di akses oleh user, karena hanya sebagian resources saja yang dapat diakses oleh user tersebut. Contohnya adalah seorang user hanya dapat melihat history transaksi milik dia sendiri. fetch resources (Hanya sebagian resources saja yang boleh diakses user, misalnya, hanya user A yang boleh lihat status penjualan barangnya) Dalam hal ini, kami memakai fungsi bawaan bin2hex yang akan men-generate token alfanumerik random. Selain itu, konsep token ini membantu dalam state handling, dimana user mendapat token, sehingga server tidak perlu menanyakan ulang username dan password pengguna. Namun, user tidak akan selamanya mendapat token. Hal ini disebut dengan expire time

Expire time pada probook kami selama 60000, tidak terlalu lama, dan tidak terlalu sebentar, namun cukup untuk meng-cover second call apabila terjadi error pada first call. Apabila aplikasi ini mulai digunakan untuk session yang lebih lama, expire time bisa diperbesar cukup dengan mengganti settingan cookie expire time pada file .ethes.

### :microscope: Kelebihan dan Kekurangan Arsitektur Microservice

#### :heavy_plus_sign: Kelebihan 

* **Batasan Modul yang Kuat**

   Microservice memperkuat struktur modular yang sangat penting bagi tim yang sangat besar. Menurut Martin Fowler ini adalah key benefit yang juga aneh jika dikatakan kelebihan, karena tidak ada alasan apapun mengapa microservice memiliki struktur modular yang lebih kuat daripada monolithic. Dalam arsitektur monolithic pada umumnya, sangatlah mudah bagi developer untuk melewati batas. Umumnya digunakan untuk mencari jalan pintas dalam mengimplementasikan fitur dengan lebih cepat. Akan tetapi berakhir pada merusak struktur modular yang berimplikasi pada penurunan produktifitas Tim. Sepengalaman kami ketika membangun monolithic application, kami mengalami kesulitan dalam mereview banyaknya kode-kode yang terkumpul di satu project repository. Sehingga terkadang Spaghetti Code terapprove dan masuk kedalam sistem. Hal ini tidak lagi kami temukan ketika migrasi ke microservice, dikarenakan tiap service sangat kecil dan hanya menghandle satu domain.

* **Deployment yang Independen**

   Service yang sederhana lebih mudah dideploy dan digunakan. Karena mereka berdiri sendiri, kecil kemungkinan kegagalan sistem terjadi saat salah satu service mengalami kesalahan. Selain itu sepengalaman kami sebelum migrasi ke microservice, applikasi yang kami kembangkan memiliki lebih dari 600 integration test dengan terdiri dari hampir 1000 assertion. Jumlah durasi test sekitar 42.55 minutes. Test ini tidak dapat dilakukan secara parallel dikarenakan adanya batasan I/O HIT ke database yang tinggi. Ini menyebabkan development time menjadi lambat, karena harus menunggu integration test selesai. Padahal hanya menambahkan atau mengupdate satu fitur baru pada salah satu domain. Belum lagi lamanya waktu menunggu migrasi database, waktu eksekusi seeding dan automated deployment. Sehingga waktu yang diperlukan untuk 1 process deployment hampir 1 jam. Hal tersebut diatas tidak lagi ditemukan sepanjang perjalanan kami migrasi ke microservice. Lamanya deployment tiap service hanya memakan waktu kurang dari 5 menit. Kita hanya perlu mengetest pada service yang mengalami perubahan saja.

* **Memungkinkan Keberagaman Stack Teknologi**

   Dengan microservice, kita dapat mencampur dan menggunakan beragam bahasa pemrograman, framework, dan teknologi penyimpanan database yang digunakan. Dalam project kami, ada fitur yang mengimplementasikan SOAP pada JAVA dan REST pada NodeJS.

#### :heavy_minus_sign: Kekurangan

* **Distribusi**

   Sistem terdistribusi (distributed system) lebih sulit diprogram, karena Remote Call lamban dan selalu memiliki resiko terjadinya kegagalan.

* **Eventual Consistency**

   Mengelola consistency yang kuat sangatlah sulit pada sistem terdistribusi, berarti setiap orang harus memanage untuk mendapatkan eventual consistency.

* **Operational Complexity**

   Anda membutuhkan tim operasional yang berpengalaman untuk memanage banyaknya system, yang akan dedeploy ulang secara berkala.

### Pembagian Tugas
"Gaji buta dilarang dalam tugas ini. Bila tak mengerti, luangkan waktu belajar lebih banyak. Bila belum juga mengerti, belajarlah bersama-sama kelompokmu. Bila Anda sekelompok bingung, bertanyalah (bukan menyontek) ke teman seangkatanmu. Bila seangkatan bingung, bertanyalah pada asisten manapun."

*Harap semua anggota kelompok mengerjakan SOAP dan REST API kedua-duanya*. Tuliskan pembagian tugas seperti berikut ini.

REST :
1. Validasi nomor kartu : 13516137
2. Pembayaran : 13516095
3. Validasi merchant key : 13516095

SOAP :
1. Mencari buku : 13516035 
2. Mendapatkan detail buku : 13516095
3. Mengganti rating buku : 13516137 
4. Mendapatkan rekomendasi buku : 13516035
5. Pembelian buku : 13516035 

Perubahan Web app :
1. Tampilan Hasil Search : 13516137
2. Implementasi Search :  13516137
2. Halaman Book Details : 13516095
3. Halaman Review : 13516035
4. Pop-up TOTP : 13516095
5. Penggantian token dengan validasi server side, user agent, dan IP : 13516095 
6. Perubahan database : 13516035 13516095 13516137

Bonus :
1. Pembangkitan token HTOP/TOTP : 13516095
2. Validasi token : 13516137
3. Pembuatan QR Code : 13516035
4. Google Login : 13516095
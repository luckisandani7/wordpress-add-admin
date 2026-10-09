```DESKRIPSI UMUM```

Goat Creator adalah skrip PHP mandiri yang berfungsi untuk menambahkan akun
administrator baru ke dalam situs web berbasis WordPress langsung melalui
peramban (browser). Skrip ini memuat dependensi WordPress, memproses input form,
menghasilkan kata sandi acak yang aman, dan meregistrasikan user dengan hak
akses administrator.

PENJELASAN FUNGSI DAN STRUKTUR KODE


1. LOGIKA UTAMA & FUNGSI PHP

- require_once('wp-load.php');
  Memuat inti dasar (core environment) WordPress. Hal ini memungkinkan skrip
  untuk memanggil fungsi-fungsi bawaan WordPress seperti pembuatan user,
  pengecekan basis data, dan pengelolaan peran (role).

- function generate_clean_password($length = 12)
  Fungsi khusus untuk membuat kata sandi acak sepanjang 12 karakter. Karakter
  yang digunakan hanya terdiri dari huruf kecil (a-z), huruf besar (A-Z), dan
  angka (0-9) tanpa simbol. Menggunakan fungsi random_int() untuk menghasilkan
  acak kriptografis yang aman.

- sanitize_user($_POST['username']) & sanitize_email($_POST['email'])
  Fungsi pembersihan bawaan WordPress untuk memastikan input nama pengguna dan
  alamat email bebas dari karakter berbahaya (XSS atau injeksi).

- username_exists($newusername) & email_exists($newemail)
  Memeriksa ke dalam basis data WordPress apakah nama pengguna atau alamat email
  yang diinputkan sudah pernah terdaftar sebelumnya.

- wp_create_user($newusername, $newpassword, $newemail)
  Fungsi bawaan WordPress untuk memasukkan entri user baru ke dalam tabel
  wp_users di basis data.

- $wp_user_object = new WP_User($user_id);
- $wp_user_object->set_role('administrator');
  Mengambil objek user yang baru saja dibuat berdasarkan ID-nya, lalu mengubah
  tingkat hak akses (role) user tersebut menjadi 'administrator'.

- is_wp_error($user_id) & $user_id->get_error_message()
  Menagkap pesan kesalahan yang dihasilkan oleh sistem WordPress jika proses
  pembuatan user mengalami kegagalan.

2. TAMPILAN DAN ANTARMUKA (HTML/CSS)

- Variable CSS (--bg-color, --card-bg, --accent-red, dll)
  Mengatur skema warna tema gelap dan merah (Dark Red) secara terpusat untuk
  memudahkan penyesuaian gaya visual.

- CSS Layouting (Flexbox & Responsive Container)
  Menata letak form agar berada di tengah layar secara otomatis serta responsif
  saat diakses melalui perangkat seluler maupun komputer.

- Form HTML (POST Method)
  Menyediakan bidang input untuk username dan email. Ketika tombol "B00M!"
  ditekan, data dikirimkan menggunakan metode POST ke skrip itu sendiri.

- Kode SVG Inline (Logo GitHub)
  Menampilkan ikon vektor GitHub secara langsung di bagian footer tanpa
  memerlukan dependensi gambar dari luar.

CARA PENGGUNAAN

1. Unggah berkas ini ke direktori utama (root directory) WordPress.
2. Akses berkas melalui browser (contoh: domain.com/goat-creator.php).
3. Masukkan Username dan Email, lalu tekan tombol B00M!.
4. Simpan kata sandi yang muncul pada layar.
5. Hapus berkas ini dari server setelah selesai digunakan demi keamanan.

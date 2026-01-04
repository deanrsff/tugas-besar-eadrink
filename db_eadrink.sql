CREATE TABLE user (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(225) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE admin (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(225) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE produk (
    id_produk INT(11) NOT NULL AUTO_INCREMENT,
    nama_produk VARCHAR(200) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    ketersediaan_stok ENUM('habis','tersedia') DEFAULT 'tersedia',
    gambar VARCHAR(225) NOT NULL,
    deskripsi TEXT NOT NULL,
    PRIMARY KEY (id_produk)
);

CREATE TABLE pesanan (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_user INT(11) NOT NULL,
    nama_pemesan VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    metode_pembayaran ENUM('COD','Transfer') NOT NULL,
    total_harga INT NOT NULL,
    status ENUM('menunggu','dikirim','selesai','dibatalkan') 
           DEFAULT 'menunggu',
    tanggal_pesanan DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES user(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE review (
  id_review INT(11) AUTO_INCREMENT PRIMARY KEY,
  id_user INT(11) NOT NULL,
  nama_user VARCHAR(100) NOT NULL,
  kota VARCHAR(100) NOT NULL,
  komentar TEXT NOT NULL,
  rating INT(11) NOT NULL,
);


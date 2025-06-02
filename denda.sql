-- Buat tabel denda
CREATE TABLE IF NOT EXISTS denda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_peminjaman INT,
    jumlah_hari_telat INT,
    jumlah_denda DECIMAL(10,2),
    status_pembayaran ENUM('belum_dibayar', 'sudah_dibayar') DEFAULT 'belum_dibayar',
    tanggal_pembayaran DATE NULL,
    FOREIGN KEY (id_peminjaman) REFERENCES peminjaman(id)
);

-- Buat tabel pengaturan denda
CREATE TABLE IF NOT EXISTS pengaturan_denda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    denda_per_hari DECIMAL(10,2) DEFAULT 3000.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default pengaturan denda
INSERT INTO pengaturan_denda (denda_per_hari) VALUES (3000.00); 
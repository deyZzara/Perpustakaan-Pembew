ALTER TABLE users
ADD COLUMN nama_lengkap VARCHAR(100) AFTER role,
ADD COLUMN email VARCHAR(100) AFTER nama_lengkap,
ADD COLUMN no_telp VARCHAR(20) AFTER email,
ADD COLUMN status_registrasi ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' AFTER is_banned; 
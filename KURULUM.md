# Kurulum Kılavuzu (XAMPP)

## 1. XAMPP İndir ve Kur

[https://www.apachefriends.org](https://www.apachefriends.org) adresinden indir, kurulumu tamamla.

## 2. Projeyi Doğru Klasöre Koy

Repoyu klonla ya da ZIP olarak çek, klasörü şuraya taşı:

```
C:\xampp\htdocs\portfolio\
```

## 3. Apache ve MySQL'i Başlat

XAMPP Control Panel'i aç → **Apache** ve **MySQL** satırlarında **Start**'a bas.

## 4. Veritabanını Oluştur

Tarayıcıda aç:

```
http://localhost/phpmyadmin
```

- Sol üstten **New** → Veritabanı adı: `portfolio_db` → **Create**
- Üst menüden **Import** sekmesi → **Choose File** → projedeki `database.sql` → **Go**

## 5. Siteyi Aç

```
http://localhost/portfolio/
```

Admin paneli → `http://localhost/portfolio/admin/`  
Kullanıcı adı: `admin` | Şifre: `Admin123!`

---

### Sorun Giderme

| Sorun | Çözüm |
|-------|-------|
| Veritabanı bağlanamıyor | `includes/db.php` içinde `DB_PASS` boş olmalı (XAMPP varsayılanı şifresizdir) |
| Sayfa açılmıyor | XAMPP'ta Apache'nin **Start** olduğundan emin ol, port çakışması varsa 8080'e al |
| SQL import hatası | phpmyadmin'de `portfolio_db` seçili olduğundan emin ol, sonra Import yap |

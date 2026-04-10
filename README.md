# 🌯 Tavuk Döner Endeksi (TDE) v2.0

Türkiye'nin reel enflasyonunu ve satın alma gücündeki değişimi, en yaygın sokak lezzeti olan **Tavuk Döner** üzerinden takip eden interaktif bir veri analitiği dashboard'u.

[![GökBörü](https://img.shields.io/badge/Project-GökBörü-orange?style=for-the-badge)](https://furkan.gokboru.net.tr)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Furkan_Mıklar-blue?style=for-the-badge&logo=linkedin)](https://www.linkedin.com/in/furkanmkl/)
[![GitHub Pages](https://img.shields.io/badge/Live-Demo-green?style=for-the-badge&logo=github)](https://furkanmkl.github.io/doner-endeksi/)

---

## 📊 Neyi Takip Ediyoruz?
Resmî rakamların ötesinde, halkın temel tüketim alışkanlıklarını baz alarak gerçek ekonomik tabloyu görselleştiriyoruz. 
- **Dolar Bazlı Değer:** Dönerin küresel para birimi karşısındaki konumu.
- **Asgari Ücret Gücü:** Bir asgari ücretli ayda kaç adet döner yiyebilir?
- **Altın Rasyosu:** 1 gram altın kaç döner ediyor? (Gerçek değer saklama testi).
- **200 TL'nin Erimesi:** En büyük banknotun zaman içindeki fiziksel kaybı.

## 🚀 Teknik Özellikler
- **Frontend:** HTML5, CSS3 (Custom Dark Theme), Vanilla JavaScript.
- **Veri Görselleştirme:** [Chart.js](https://www.chartjs.org/) (Multi-axis & Logarithmic scales).
- **Veri Yönetimi:** Merkezi `data.json` yapısı ile hızlı ve kolay güncelleme.
- **Hata Yönetimi:** Geçmişteki `NaN` ve `undefined` hesaplama hataları v2.0 ile giderildi.

## 📂 Dosya Yapısı
```text
├── index.html          # Dashboard ana kodları ve Fetch API
├── data.json           # Tarihsel fiyat ve kur veritabanı
└── assets/             # Görsel materyaller ve ekran görüntüleri

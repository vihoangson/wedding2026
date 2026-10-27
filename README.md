<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


Nên làm trước (thiết thực)
Duyệt lời chúc ngay trên dashboard. Hiện lời chúc tạo ra với active: false, nhưng dashboard không có nút duyệt nên phải sửa tay file JSON. Thêm nút Duyệt/Ẩn/Xoá là xong.
Tạo link mời hàng loạt và xuất Excel. Dán danh sách tên khách, hệ thống tạo link cho từng người. Kèm nút "Copy tin nhắn Zalo" có sẵn lời mời và link.
Theo dõi khách đã mở thiệp. Ghi lại lần đầu và số lần mỗi token được mở. Dashboard sẽ biết ai chưa xem thiệp để nhắc lại.
Chống gửi RSVP trùng. Hiện một khách bấm gửi 3 lần thì có 3 bản ghi. Nên gắn RSVP theo token: khách gửi lại thì cập nhật bản cũ, có thể kèm thông báo "Bạn đã xác nhận lúc…".
Thêm sự kiện vào lịch điện thoại. Nút "Thêm vào Google Calendar / iPhone" (file .ics) để khách không quên ngày cưới.
Tăng trải nghiệm khách
Nhạc nền có nút bật/tắt. Trình duyệt chặn tự phát nhạc, nên nhạc chỉ bắt đầu khi khách chạm lần đầu.
Màn hình mở thiệp. Khi vào trang, khách thấy một phong bì đóng; chạm vào thì phong bì mở ra để lộ thiệp. Thao tác chạm này cũng dùng để bật nhạc luôn.
Phân nhóm khách, ví dụ "Nhà trai / Nhà gái / Bạn bè". Mỗi nhóm có thể thấy giờ hoặc địa điểm khác nhau, chẳng hạn lễ gia tiên chỉ hiện cho người nhà.
Lịch trình trong ngày cưới: đón khách, làm lễ, khai tiệc, mỗi mốc có giờ cụ thể.
Ảnh xem trước khi chia sẻ link (Open Graph). Khi gửi link qua Zalo hoặc Messenger sẽ hiện ảnh cưới và dòng "Kính mời Anh A", thay vì khung trống như hiện tại.
Sau ngày cưới
Khách tải ảnh chụp tại tiệc lên, qua mã QR đặt trên bàn tiệc. Ảnh lưu vào S3 (đã có sẵn cấu hình), sau đó hiển thị ở /memorize.
Thiệp cảm ơn gửi riêng từng khách: sau ngày cưới, cùng link đó chuyển sang trang cảm ơn kèm album.
Sổ ghi tiền mừng trong dashboard, chỉ admin xem: ghi lại ai mừng bao nhiêu để sau này đáp lễ.
Quản trị và kỹ thuật
Thống kê theo thời gian thực: số khách dự kiến, ước tính số bàn (ví dụ 10 người/bàn), danh sách khách chưa phản hồi.
Thông báo Telegram hoặc Zalo mỗi khi có RSVP hay lời chúc mới.
Chuyển dữ liệu từ JSON sang SQLite. Việc này tránh mất dữ liệu khi nhiều người gửi cùng lúc, và dễ làm các tính năng 3, 4, 14 hơn.
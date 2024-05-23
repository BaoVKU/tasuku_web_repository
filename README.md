# Cài đặt server 

- Tải và cài đặt XAMPP
- Import cơ sở dữ liệu từ file *laravel.sql*
- Mở *Cmd* và gõ `ipconfig` lấy đỉa chỉ ip (IPv4) trong LAN của máy tính

![image](https://github.com/BaoVKU/tasuku_web_repository/assets/164776548/0c67ac78-17b5-4574-8c75-fe6474dbee0e)

- Tạo tên miền với host là IPv4 vừa kiểm tra được và port bất kì VD: *192.168.1.9:7749*
- Bật IDE
- Vào file *.env*, thêm host và tên miền vào mục *SANCTUM_STATEFUL_DOMAINS*

![image](https://github.com/BaoVKU/tasuku_web_repository/assets/164776548/171abad4-ae43-4770-859c-e89d3235a89f)

- Thêm host và tên miền tương tự vào hàm sprinf() trong file *app\config\sanctum.php*

![image](https://github.com/BaoVKU/tasuku_web_repository/assets/164776548/a5b3d31f-a0e5-4bd8-a5ad-87bb654cd97c)

- Chạy lệnh cài đặt môi trường
  
`npm install`

`composer install`

- Bật 2 terminal song song
- Terminal thứ nhất chạy:

`npm run dev`

- Terminal thứ hai chạy:

`php artisan serve --host 192.168.1.9 --port 7749`

`--host` và `--port` phụ thuộc vào IP vừa kiểm tra được và port bất kì

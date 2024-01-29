# Deploy

## Đăng nhập vào server dùng ssh

- Đăng nhập
<!-- 
@Rcv! Le Vu : 192.168.55.61 root/it58.levu
@Rcv! Tran Dat : 192.168.55.62 root/it59.trandat
 -->
```sh
# Yêu cầu truy cập trước.
ssh root@192.168.55.61
# Nhập mật khẩu rồi enter để truy cập.
it58.levu
```

## Tải vim

```sh
 yum install vim
 ```

## Tải apache

```sh
# Tải apache
sudo yum install httpd
# Chạy apache
sudo systemctl start httpd
# Kiểm tra trạng thái apache
sudo systemctl status httpd
# Lấy host rồi truy cập để check. <Mở tab ẩn danh>
hostname -I
# Dừng apache.
sudo systemctl stop httpd
# Dừng và chạy apache lại lần nữa
sudo systemctl restart httpd
# Chạy lại apache nhưng không dropping connections
sudo systemctl reload httpd
# Mặc định apache sẽ tự động chạy. muốn dừng nó thì chạy câu lệnh dưới.
sudo systemctl disable httpd
# Mở lại mặc định chạy cho apache
sudo systemctl enable httpd
```

## Tải php v8.x.x

- [Làm theo đường link này](https://www.websitevidya.com/how-to-install-php-8-on-centos-7-rhel-8/)

```sh

# Step 1 – Enable PHP Repository
sudo yum install -y https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm

sudo yum install -y https://rpms.remirepo.net/enterprise/remi-release-7.rpm

# Step 2 – Enable remi-8.2 PHP Module
sudo yum -y install yum-utils
sudo yum-config-manager --disable 'remi-php*'
sudo yum-config-manager --enable remi-php82

# Step 3 – Install PHP 8 on Apache and Nginx
## Install PHP 8 on Apache
sudo yum install php php-cli php-common
# Restart lại apache sau khi tải xong PHP
sudo systemctl restart httpd
```

## Tải MySql Server

```sh
# Cài mysql.
sudo yum install mysql-server
# Chạy mysql
sudo service mysqld start
# Dừng mysql
sudo service mysqld stop
# Chạy lại mysql
sudo service mysqld restart
```

- Cách sửa khi lỗi như sau: `How to Fix MySQL Error: Access Denied for User 'root'@'localhost'`

```sh
# Step 1: Open the my.cnf file. This may be stored in:
# /etc/my.cnf
# /etc/mysql/my.cnf
vim /etc/my.cnf

# Step 2: Thêm nội dung vào
[mysqld]
skip-grant-tables
# Step 3: Chạy lại mysql
sudo service mysqld restart
```

## Tải git

```sh
sudo yum install git
```

## Tải composer

```sh
curl  -k -sS https://getcomposer.org/installer | php

sudo mv composer.phar /usr/local/bin/composer

composer -V

```

## Xử lý lỗi không chạy được bất kỳ routes nào khác route mặc định

- Phải cập nhập lại `/etc/httpd/conf/httpd.conf`

```sh
<VirtualHost *:80>
        ServerName intern_it57.com
        DocumentRoot /var/www/intern_it57/public
       <Directory /var/www/intern_it57/public>
            AllowOverride All
        </Directory>
</VirtualHost>
```

## Xử lý lỗi khi kết nối database

> Lỗi thế này: **SQLSTATE[HY000] [2002] Permission denied**

```sh
# Check SELinux context
ls -Z /var/www/intern_it57

# Allow HTTPD to connect to the network (replace with the actual web server user)
setsebool -P httpd_can_network_connect on
```

## Xử lý lỗi không có quyền mở file và ghi file laravel.log

```sh
# Cấp quyền
sudo chmod -R 777 /var/www/intern_it57/storage
# Chạy lại apache
sudo systemctl restart httpd
```

## Đổi http qua https

- Thiết lập cho ip
  - [How To Create an SSL Certificate on Apache for CentOS 7](https://www.digitalocean.com/community/tutorials/how-to-create-an-ssl-certificate-on-apache-for-centos-7)
  - > Chú ý cập nhập lại document root, và DirectoryName
- Thiết lập khi có domain.
  - [Let's Encrypt](https://letsencrypt.org/vi/docs/)
  - [How To Secure Apache with Let's Encrypt on CentOS 7](https://www.digitalocean.com/community/tutorials/how-to-secure-apache-with-let-s-encrypt-on-centos-7)  

## Tham khảo

- [How To Install PHP 8 on CentOS 7 | RHEL 8 – 5 Simple Steps](https://www.websitevidya.com/how-to-install-php-8-on-centos-7-rhel-8/)
- [How to Install PHP 8 on CentOS/RHEL 8/7](https://www.tecmint.com/install-php-8-on-centos/)
- [Cài đặt laravel Framework trên CentOs VPS](https://viblo.asia/p/cai-dat-laravel-framework-tren-centos-vps-mrDkMMjPkzL)
- [How To Install the Apache Web Server on CentOS 7](https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-centos-7)
- [How to Fix MySQL Error: Access Denied for User ‘root’@’localhost’](https://www.databasestar.com/access-denied-for-user-root-at-localhost/)
- [Hướng dẫn cài đặt PHP 8.1 trên CentOS7](https://huongdan.azdigi.com/huong-dan-cai-dat-php-8-1-tren-centos7/)
- [How To Install Laravel On CentOS 7](https://operavps.com/docs/install-laravel-on-centos/)
- [Chmod 777: Nó thực sự nghĩa là gì?](https://viblo.asia/p/chmod-777-no-thuc-su-nghia-la-gi-E375zw4JKGW?fbclid=IwAR3nJAlb6nhILWm4cGZgoDjn1PiW3dOTbzQA9CoyF2VtfVJRgDU6sOXjmIY)

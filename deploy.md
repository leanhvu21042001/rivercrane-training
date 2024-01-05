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

# Step 2 – Enable remi-8.0 PHP Module
sudo yum -y install yum-utils
sudo yum-config-manager --disable 'remi-php*'
sudo yum-config-manager --enable remi-php80

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

## Tham khảo

- [How To Install PHP 8 on CentOS 7 | RHEL 8 – 5 Simple Steps](https://www.websitevidya.com/how-to-install-php-8-on-centos-7-rhel-8/)
- [How to Install PHP 8 on CentOS/RHEL 8/7](https://www.tecmint.com/install-php-8-on-centos/)
- [Cài đặt laravel Framework trên CentOs VPS](https://viblo.asia/p/cai-dat-laravel-framework-tren-centos-vps-mrDkMMjPkzL)
- [How To Install the Apache Web Server on CentOS 7](https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-centos-7)
- [How to Fix MySQL Error: Access Denied for User ‘root’@’localhost’](https://www.databasestar.com/access-denied-for-user-root-at-localhost/)
- [Hướng dẫn cài đặt PHP 8.1 trên CentOS7](https://huongdan.azdigi.com/huong-dan-cai-dat-php-8-1-tren-centos7/)
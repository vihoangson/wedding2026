git add .
git commit -m "commit_message"
git push
ssh root@188.166.213.71 -i ../002.pem "cd /var/www/vhosts/hoangson-yennhi.oop.vn && git fetch && git checkout wedding_main&& git pull && service httpd restart"

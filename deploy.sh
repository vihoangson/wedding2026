git add .
git commit -m "commit_message"
git push
ssh sondev@206.189.92.105 "cd /var/www/vhosts/hoangson-yennhi.oop.vn && git fetch && git checkout laravel_template && git pull"

git add .
git commit -m "commit_message"
git push
ssh sondev@206.189.92.105 "cd /var/docker/wedding/src && git fetch &&  git pull"

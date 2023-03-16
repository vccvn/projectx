@echo off
set /p message="Enter Message: "
git add .
git commit -a -m "%message%"
git push
set /p e="Press Enter to Exit... "
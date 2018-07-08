@echo off
echo %1
curl -F "file=@%1" https://lo-ope.com/cs/test/test.php

pause
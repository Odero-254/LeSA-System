@echo off
:start
REM Get the current time
for /f "tokens=1-2 delims=: " %%a in ('time /t') do (
    set hour=%%a
    set minute=%%b
)

REM Check if the current time is midnight (12:00 AM)
if %hour% == 12 if %minute% == 00 (
    REM Run the PHP script
    C:\wamp64\bin\php\php8.2.18\php.exe C:\wamp64\www\popo\reset_status.php
)

REM Wait for 60 seconds before checking again
timeout /t 60 /nobreak >nul

REM Loop back to start
goto start

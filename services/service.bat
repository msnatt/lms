@echo off
setlocal

:: =========================================================
:: RTCServerLMS Windows Service Manager
:: =========================================================

set SERVICE_NAME=.RTCServerLMS
set NSSM=nssm.exe
set PHP=C:\xampp\php\php.exe
set SCRIPT=C:\xampp\htdocs\lms\config\chat-server.php
set APP_DIR=C:\xampp\htdocs\lms
set LOG_DIR=%APP_DIR%\logs

title RTCServerLMS Service Manager

:MENU
cls

echo ==========================================
echo       RTCServerLMS Service Manager
echo ==========================================
echo.
echo Choose which one RTCServerLMS service
echo.
echo  1. Check status
echo  2. Install
echo  3. Uninstall
echo  4. Exit
echo.
set /p CHOICE=Please choose [1-4]: 

if "%CHOICE%"=="1" goto CHECK
if "%CHOICE%"=="2" goto INSTALL
if "%CHOICE%"=="3" goto UNINSTALL
if "%CHOICE%"=="4" goto END

echo.
echo Invalid choice.
pause
goto MENU


:: =========================================================
:: CHECK STATUS
:: =========================================================

:CHECK
cls

echo ==========================================
echo       Check RTCServerLMS Service
echo ==========================================
echo.
echo Service Name: %SERVICE_NAME%
echo.

sc query "%SERVICE_NAME%" >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo [FOUND] Service exists.
    echo.
    sc query "%SERVICE_NAME%"
) else (
    echo [NOT FOUND] Service does not exist.
)

echo.
pause
goto MENU


:: =========================================================
:: INSTALL
:: =========================================================

:INSTALL
cls

echo ==========================================
echo       Install RTCServerLMS Service
echo ==========================================
echo.

:: Check service already exists
sc query "%SERVICE_NAME%" >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo [ERROR] Service "%SERVICE_NAME%" already exists.
    echo.
    echo Please uninstall it first if you want to reinstall.
    echo.
    pause
    goto MENU
)

:: Check NSSM
where %NSSM% >nul 2>&1

if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] NSSM was not found.
    echo.
    echo Please put nssm.exe in the same folder as this BAT file
    echo or add NSSM to Windows PATH.
    echo.
    pause
    goto MENU
)

:: Check PHP
if not exist "%PHP%" (
    echo [ERROR] PHP was not found:
    echo %PHP%
    echo.
    pause
    goto MENU
)

:: Check PHP script
if not exist "%SCRIPT%" (
    echo [ERROR] PHP script was not found:
    echo %SCRIPT%
    echo.
    pause
    goto MENU
)

:: Create log directory
if not exist "%LOG_DIR%" (
    mkdir "%LOG_DIR%"
)

echo PHP:
echo   %PHP%
echo.
echo Script:
echo   %SCRIPT%
echo.
echo Installing service...
echo.

nssm install "%SERVICE_NAME%" "%PHP%"

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo [ERROR] Failed to install service.
    pause
    goto MENU
)

:: Configure service
nssm set "%SERVICE_NAME%" AppDirectory "%APP_DIR%"
nssm set "%SERVICE_NAME%" AppParameters "\"%SCRIPT%\""

:: Logging
nssm set "%SERVICE_NAME%" AppStdout "%LOG_DIR%\RTCServerLMS-out.log"
nssm set "%SERVICE_NAME%" AppStderr "%LOG_DIR%\RTCServerLMS-error.log"

:: Restart behavior
nssm set "%SERVICE_NAME%" AppExit Default Restart
nssm set "%SERVICE_NAME%" AppThrottle 5000

:: Service startup
nssm set "%SERVICE_NAME%" Start SERVICE_AUTO_START

echo.
echo ==========================================
echo Service installed successfully!
echo ==========================================
echo.
echo Service Name: %SERVICE_NAME%
echo.

echo Starting service...
nssm start "%SERVICE_NAME%"

echo.
echo Current status:
echo.
sc query "%SERVICE_NAME%"

echo.
pause
goto MENU


:: =========================================================
:: UNINSTALL
:: =========================================================

:UNINSTALL
cls

echo ==========================================
echo       Uninstall RTCServerLMS Service
echo ==========================================
echo.

sc query "%SERVICE_NAME%" >nul 2>&1

if %ERRORLEVEL% NEQ 0 (
    echo [NOT FOUND] Service "%SERVICE_NAME%" does not exist.
    echo.
    pause
    goto MENU
)

echo Service found.
echo.
sc query "%SERVICE_NAME%"
echo.

set /p CONFIRM=Are you sure you want to uninstall? [Y/N]: 

if /I not "%CONFIRM%"=="Y" (
    echo.
    echo Cancelled.
    pause
    goto MENU
)

echo.
echo Stopping service...
nssm stop "%SERVICE_NAME%"

timeout /t 2 /nobreak >nul

echo Removing service...
nssm remove "%SERVICE_NAME%" confirm

echo.
echo ==========================================
echo Service removed successfully!
echo ==========================================
echo.

pause
goto MENU


:: =========================================================
:: END
:: =========================================================

:END
cls
echo.
echo RTCServerLMS Service Manager closed.
echo.
endlocal
exit /b
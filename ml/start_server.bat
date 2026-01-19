@echo off
title AI Tools Recommender - SVD Server
color 0A

echo ========================================
echo   AI Tools Recommender - SVD Server
echo   Model-Based Collaborative Filtering
echo ========================================
echo.

cd /d %~dp0

echo [1/2] Checking Python installation...
py -3.12 --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Python 3.12 not found!
    echo Please install Python 3.12 from python.org
    pause
    exit /b 1
)
echo [OK] Python 3.12 found

echo.
echo [2/2] Starting SVD Recommender Server...
echo.
echo Server will run at: http://localhost:5000
echo Press Ctrl+C to stop the server
echo.
echo ========================================

py -3.12 recommender.py

pause

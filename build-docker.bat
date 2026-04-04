@echo off
echo Building Satria Eko Docker image...
echo.

echo Step 1: Check if Docker is installed
docker --version >nul 2>&1
if errorlevel 1 (
    echo Docker is not installed. Please install Docker Desktop from:
    echo https://www.docker.com/products/docker-desktop/
    pause
    exit /b 1
)

echo Step 2: Build the Docker image
docker build -t satria-eko:latest .

if errorlevel 1 (
    echo Docker build failed!
    pause
    exit /b 1
)

echo.
echo Docker image built successfully!
echo Image name: satria-eko:latest
echo.
echo To run the application with docker-compose:
echo   docker-compose up -d
echo.
echo To run just the app container:
echo   docker run -p 8080:80 satria-eko:latest
echo.
pause
## Project Structure

```
app
├── http
│   ├── Controllers
├── Models
├── Providers

database
├── migrations
├── seeders

resources
├── components
├── js
│   ├── pages
│   ├── router

routes
│
```

## Before Running the Project

### Install NPM Packages
```sh
npm i
```

### Install Laravel, PHP, and Composer
For Windows, run the following command in PowerShell:
```sh
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

## Running the Project

### Start the Development Server
```sh
php artisan migrate
npm run dev
php artisan serve
```


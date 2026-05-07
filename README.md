# 💱 P2P Trading Portfolio Tracker

A clean and scalable Laravel application for managing and tracking P2P USDT trading activities with CRUD operations, REST API integration, and future-ready portfolio analytics architecture.

---

# 🚀 Features

- ✅ Full Trade Management CRUD
- ✅ Laravel Resource Routing
- ✅ Blade-based UI
- ✅ PostgreSQL / MySQL Integration
- ✅ REST API Endpoints
- ✅ Validation & Error Handling
- ✅ API Tested with Postman
- 🚧 Portfolio Analytics Engine (In Progress)
- 🚧 Dashboard & Metrics (Planned)

---

# 🧱 Tech Stack

- Laravel
- Blade
- PostgreSQL / MySQL
- PHP
- REST API
- Postman

---

# 🗄️ Database Structure

## trades table

| Column       | Type               |
| -------------| ------------------ |
| id           | bigint             |
| type         | enum (buy/sell)    |
| amount_usdt  | decimal            |
| bank_fee     | decimal            |
| total_lkr    | decimal            |
| fee          | decimal (nullable) |
| timestamps   | timestamps         |

---

# ⚙️ Installation

## Clone Repository

```bash
git clone https://github.com/YOUR_USERNAME/p2p-portfolio-tracker.git
cd p2p-portfolio-tracker
```

---

## Install Dependencies

```bash
composer install
```

---

## Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

---

## Configure Database

### PostgreSQL

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=p2p_tracker
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=p2p_tracker
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## Run Migrations

```bash
php artisan migrate
```

---

## Start Development Server

```bash
php artisan serve
```

Application runs at:

```text
http://127.0.0.1:8000
```

---

# 🌐 REST API Endpoints

## Trade APIs

| Method | Endpoint           | Description        |
| ------ | ------------------ | ------------------ |
| GET    | /api/trades        | Get all trades     |
| POST   | /api/trades        | Create new trade   |
| GET    | /api/trades/{id}   | Get single trade   |
| PUT    | /api/trades/{id}   | Update trade       |
| DELETE | /api/trades/{id}   | Delete trade       |

---

# ✅ API Testing

All API endpoints were tested successfully using **Postman**.

## Example Tested API Response

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "type": "buy",
            "amount_usdt": "100.00",
            "bank_fee": "50.00",
            "total_lkr": "32000.00",
            "fee": "15.00"
        }
    ]
}
```

---

# 📸 API Testing Showcase

You should add screenshots here from Postman to prove APIs are working.

Recommended screenshots:
- GET /api/trades
- POST /api/trades
- PUT /api/trades/{id}
- DELETE /api/trades/{id}

---

# 🚧 Planned Features

- Portfolio Summary Dashboard
- Weighted Average Price Calculation
- Break-even Calculation
- Profit/Loss Analytics
- Authentication System
- Multi-user Support
- Live Market Price Integration
- Charts & Analytics Dashboard
- Multi-Asset Support (BTC, ETH)
---

# 🧠 Current Development Status
| Module | Status |
| ------ | ------ |
| CRUD System | ✅ Completed |
| REST API | ✅ Completed |
| API Testing | ✅ Completed |
| Portfolio Engine | 🚧 In Progress |
| Dashboard Analytics | 🚧 Planned |
---

# 📜 License
MIT License
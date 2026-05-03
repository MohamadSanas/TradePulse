# 💱 P2P Trading Portfolio Tracker

A clean and scalable Laravel application for tracking P2P USDT trades and analyzing portfolio performance.

---

## 🚀 Features

* ✅ Trade Management (CRUD)
* ✅ Portfolio Summary Dashboard
* ✅ Weighted Average Price Calculation
* ✅ Break-even Price Calculation
* ✅ REST API Support
* ✅ Clean Architecture (Service Layer)
* ✅ Pagination & Validation

---

## 🧱 Tech Stack
* Laravel (latest)
* Blade
* MySQL
* REST API

---

## 📊 Portfolio Metrics

The system calculates:
* Total USDT Balance
* Total Bank Balance (LKR)
* Remaining Investment Cost
* Average Buy Price
* Break-even Price
* Total Portfolio Value
* Overall Profit/Loss

---

## 🗄️ Database Structure

### trades table

| Column      | Type               |
| ----------- | ------------------ |
| id          | bigint             |
| type        | enum (buy/sell)    |
| amount_usdt | decimal            |
| price       | decimal            |
| total_lkr   | decimal            |
| fee         | decimal (nullable) |
| timestamps  | timestamps         |
---

## ⚙️ Installation
git clone https://github.com/YOUR_USERNAME/p2p-portfolio-tracker.git
cd p2p-portfolio-tracker

composer install
cp .env.example .env
php artisan key:generate

### Configure Database
Update `.env`:

DB_DATABASE=p2p_tracker
DB_USERNAME=root
DB_PASSWORD=your_password


Then run:
php artisan migrate
php artisan serve
---

## 🌐 API Endpoints

| Method | Endpoint     | Description       |
| ------ | ------------ | ----------------- |
| GET    | /api/trades  | List trades       |
| POST   | /api/trades  | Create trade      |
| GET    | /api/summary | Portfolio summary |
---

## 📦 Example API Response
json
{
  "bank_balance": 29009.17,
  "usdt": 649.04,
  "remaining_cost": 211249.69,
  "avg_buy_price": 325.48,
  "break_even_price": 325.81,
  "total_value": 240258.86,
  "profit": 558.86
}
---

## 🧠 Calculation Logic

* Uses **weighted average method** for buy trades
* Sell trades reduce USDT balance and increase bank balance
* Break-even includes realized profit from sells
* Portfolio value combines cash + current holdings
---

## 📁 Project Structure
app/
 ├── Models/Trade.php
 ├── Services/PortfolioService.php
 ├── Http/Controllers/
 ├── Http/Resources/

resources/views/
routes/
database/

## ⚡ Future Improvements
* Multi-user authentication
* Multi-asset support (BTC, ETH)
* Live market price integration
* Charts & analytics dashboard

---

## 📜 License
MIT License

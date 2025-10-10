# 🧠 Feedback Automation Workflow

## 📌 Overview
This project automates the process of collecting and analyzing client feedback using **Google Sheets**, **Laravel API**, and **n8n automation**.  
Every time a new feedback entry is added to a Google Sheet, it is automatically sent to the Laravel API for **AI-based summarization** and **sentiment analysis**, and the results are then forwarded to a **Telegram channel**.

---

## ⚙️ Architecture

### 🔄 Workflow Overview
1. **Google Sheets Trigger (n8n)**  
   Detects when a new row (feedback) is added.
2. **HTTP Request (n8n)**  
   Sends the feedback text to a Laravel API endpoint (`/api/analyse-feedback`).
3. **Laravel API**  
   - Receives feedback text  
   - Calls an AI model (e.g., OpenAI / Mistral)  
   - Returns:  
     ```json
     {
       "summary": "Short summary of feedback",
       "sentiment": "positive|neutral|negative"
     }
     ```
4. **Telegram Node (n8n)**  
   Sends the analyzed result to a Telegram channel for monitoring.

### 🧩 Tech Stack
- **Laravel 12.x** (Backend API)
- **PHP 8.x**
- **SQLite** (Local Database)
- **n8n** (Automation Orchestrator)
- **Google Sheets** (Data Source)
- **Telegram Bot API** (Notifications)
- **AI Model** (OpenAI / Mistral)

---

## 🧰 Setup Instructions

### 1. Laravel API
#### Clone & Install
```bash
git clone https://github.com/yourusername/feedback-analyzer.git
cd feedback-analyzer
composer install

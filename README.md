# 📖 Project Documentation: Feedback Automation Workflow

## 🧠 Introduction
The **Feedback Automation Workflow** is an intelligent system designed to automate the process of **collecting**, **analyzing**, and **distributing** client feedback.  
It integrates **Google Sheets**, **n8n**, **Laravel API**, and **Mistral AI** to automatically summarize feedback, analyze sentiment, and send the results to a **Telegram channel** for real-time monitoring.

---

## 🎯 Objectives
- Automate manual feedback review tasks.  
- Use AI to extract key insights from client feedback.  
- Centralize feedback data from Google Sheets.  
- Provide real-time feedback reports to internal teams via Telegram.

---

## ⚙️ System Overview

### 🔄 Workflow Diagram


### 📡 Process Flow
1. **Feedback Submission** — Clients submit feedback via Google Sheets.  
2. **Trigger Detection** — n8n automatically detects a new row in the sheet.  
3. **API Call** — n8n sends the new feedback to the Laravel API endpoint (`/api/analyse-feedback`).  
4. **AI Processing** — Laravel sends the feedback text to **Mistral AI** for summarization and sentiment analysis.  
5. **Result Delivery** — n8n forwards the AI-generated results to a **Telegram channel** for quick review.

---

## 🧩 Architecture Components

| Component | Description |
|------------|--------------|
| **Google Sheets** | Input source for client feedback |
| **n8n** | Automation tool for triggering, transforming, and routing data |
| **Laravel API** | Backend service that communicates with Mistral AI |
| **Mistral AI** | Natural language model for summarization and sentiment detection |
| **Telegram** | Notification endpoint for delivering analyzed feedback |

---

## 🧰 Setup Instructions

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/farihulrouf/n8n_juice
cd n8n_juice
composer install


php artisan key:generate

php artisan serve

curl -X POST http://127.0.0.1:8000/api/analyse-feedback \
  -H "Content-Type: application/json" \
  -d '{"feedback_text": "The checkout process is confusing and keeps giving me errors."}'

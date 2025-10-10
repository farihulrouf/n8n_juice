# 📖 Project Documentation: Feedback Automation Workflow
## 🧠 Introduction
The **Feedback Automation Workflow** is an intelligent automation system designed to streamline how client feedback is collected, analyzed, and distributed. It integrates **Google Sheets**, **n8n**, **Laravel API**, and **Mistral AI** to automatically summarize feedback, detect sentiment, and deliver analyzed results to a **Telegram channel** in real time.
## ⚙️ Pre-Setup Requirements
Before running the project, please complete **two essential setup steps**: 1. **Create and configure a Telegram Bot** 2. **Connect your Google Sheet document**
### 🔹 Step 1: Create Telegram Bot via BotFather (Fast Setup)
1. Open **Telegram** and search for **@BotFather**.
2. Type the command: `/newbot`
3. Enter your bot name (e.g., `Feedback AI Bot`)
4. Enter a unique username that ends with `bot` (e.g., `feedback_ai_bot`)
5. You’ll receive a **Bot Token**, for example: `1234567890:ABCdefGhIJkLmNopQRstuVWxyz`
6. Save this token securely — it will be used inside **n8n**.
7. Add your bot to your **Telegram Channel** (e.g., `@feedback_monitor_channel`) and make it **Admin**.
8. In **n8n**, open the node **“Send a text message”** → click ⚙️ **Credentials** → select **Create new** → paste your bot token → click **Save** → test the connection.
### 🔹 Step 2: Configure Google Sheets
1. Open the workflow file: `Feedback Automation Workflow.json`
2. Locate this section in the file:
"documentId": "1dpZcIBC0pp4JzgYnwB3BpbYbMiHBa7EiAuTMB0LQM6g"
3. Replace the `"documentId"` value with **your own Google Sheet ID** (for example, if your sheet URL is `https://docs.google.com/spreadsheets/d/1ABCxyz987654321/edit`, then your ID is `1ABCxyz987654321`).
4. Ensure the `"sheetName"` field matches your actual sheet name (e.g., `Sheet1` or `Feedback`).
5. In **n8n**, open the **Google Sheets Trigger** node → under **Credentials**, create a new **Google OAuth2** connection → log in with your Google account → click **Save**.
## 🧩 System Components
| Component | Description |
|------------|--------------|
| **Google Sheets** | Source of client feedback entries |
| **n8n** | Workflow automation and data routing tool |
| **Laravel API** | Backend service communicating with Mistral AI |
| **Mistral AI** | Performs summarization and sentiment analysis |
| **Telegram** | Sends analyzed feedback to your channel |
## 🧰 Installation Steps
### 1️⃣ Clone the Repository
git clone https://github.com/farihulrouf/n8n_juice
cd n8n_juice
composer install
php artisan key:generate
php artisan serve
### 2️⃣ Test the Laravel API
Run this command to verify the API is working:
curl -X POST http://127.0.0.1:8000/api/analyse-feedback -H "Content-Type: application/json" -d '{"feedback_text": "The checkout process is confusing and keeps giving me errors."}'
You should get a response like:
{
  "summary": "Customer mentioned confusion and errors during checkout.",
  "sentiment": "negative"
}
✅ Once everything works locally, import your workflow into **n8n**, connect your Google Sheet and Telegram bot credentials, then activate the workflow. Every time a new feedback row is added in Google Sheets, your Laravel API will process it, and the summarized result will be sent to Telegram automatically.

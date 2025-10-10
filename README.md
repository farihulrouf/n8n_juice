# 📖 Project Documentation: Feedback Automation Workflow
## 🧠 Introduction
The **Feedback Automation Workflow** is an intelligent automation system designed to streamline how client feedback is collected, analyzed, and distributed. It integrates **Google Sheets**, **n8n**, **Laravel API**, and **Mistral AI** to automatically summarize feedback, detect sentiment, and deliver analyzed results to a **Telegram channel** in real time.

## ⚙️ Pre-Setup Requirements
Before running the project, please complete **two essential setup steps**:
1. **Create and configure a Telegram Bot**
2. **Connect your Google Sheet document**

### 🔹 Step 1: Create Telegram Bot via BotFather (Fast Setup)
1. Open **Telegram** and search for **@BotFather**.  
2. Type the command: `/newbot`  
3. Enter your bot name (e.g., `Feedback AI Bot`).  
4. Enter a unique username that ends with `bot` (e.g., `feedback_ai_bot`).  
5. You’ll receive a **Bot Token**, for example:  
   `1234567890:ABCdefGhIJkLmNopQRstuVWxyz`  
6. Save this token securely — it will be used inside **n8n**.  
7. Create a **Telegram Channel** (e.g., `@feedback_monitor_channel`).  
8. Add your bot to that channel and **promote it as an Admin**, so it can send messages.  
9. To get your **Channel ID**, forward any message from that channel to [@userinfobot](https://t.me/userinfobot) — it will show something like `-1001234567890`.  
10. Copy that **Channel ID**, you’ll use it in the Telegram node inside **n8n**.  
11. In **n8n**, open the node **“Send a text message”** → click ⚙️ **Credentials** → select **Create new** → paste your bot token → click **Save** → test the connection.

### 🔹 Step 2: Configure Google Sheets
1. Open the workflow file: `Feedback Automation Workflow.json`.  
2. Locate this line in the file:  
   `"documentId": "1dpZcIBC0pp4JzgYnwB3BpbYbMiHBa7EiAuTMB0LQM6g"`.  
3. Replace the `"documentId"` value with **your own Google Sheet ID** (example: `1ABCxyz987654321`).  
4. Make sure the `"sheetName"` field matches your actual sheet name (e.g., `Sheet1` or `Feedback`).  
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
### 1️⃣ Clone and Setup the Laravel API
```bash
git clone https://github.com/farihulrouf/n8n_juice
cd n8n_juice
cp .env.example .env
composer install
php artisan key:generate
php artisan serve

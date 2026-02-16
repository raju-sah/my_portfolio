# Raju Sah's Portfolio & RAG Chatbot (RajuGPT)

Welcome to the source code of my personal portfolio and its sarcastic digital twin, **RajuGPT**. This project is a full-stack Laravel application that combines a modern frontend with a sophisticated Retrieval-Augmented Generation (RAG) chatbot.

## 🚀 Key Features

### 💻 Frontend & User Experience
- **Modern UI/UX**: Built with a sleek, responsive design focusing on readability and interactive elements.
- **Dynamic Content**: Managed sections for Projects, Experience, Articles, and Testimonials.
- **Micro-interactions**: Subtle animations and hover effects for a premium feel.
- **RAG Chat Widget**: A sarcastic, Gen-Z styled chatbot integrated directly into the UI.

### 🤖 The RAG Chatbot (RajuGPT)
RajuGPT isn't just a bot; it's a context-aware digital twin powered by a custom RAG (Retrieval-Augmented Generation) pipeline.

#### **Core Architecture**
- **LLM Provider**: Integrated with **OpenRouter**, allowing seamless fallback between high-performance models like **Grok-4.1 Fast**, **GPT-4o**, and **Gemini 1.5 Pro**.
- **Vector Retrieval**:
    - **Embeddings**: Text chunks are converted into vector representations for semantic understanding.
    - **Cosine Similarity**: A custom PHP implementation calculates the similarity score between user queries and document chunks.
    - **Hybrid Search**: Combines MySQL **Fulltext Search** (Keyword-based) with vector similarity (Semantic-based) for maximum accuracy.
- **Conversation Memory**:
    - Uses **Laravel Native Sessions** and **localStorage** persistence to remember the user's name and previous context across interactions.

#### **Ingestion Pipeline**
The chatbot's knowledge base is automatically populated and updated:
- **Website Ingestion**: Crawls and scrapes web content using the **Firecrawl** API to ingest live site data.
- **Resume/PDF Parsing**: Uses `smalot/pdfparser` to extract structured text from resumes and technical documents.
- **GitHub Integration**: Automatically fetches repository details and READMEs via the GitHub API.
- **Automation**: Knowledge sources are resynced weekly using the **Laravel Scheduler**.

## 🛠️ Tech Stack

- **Backend**: Laravel 10 (PHP 8.2+)
- **Frontend**: Blade, Vanilla CSS, JavaScript
- **Database**: MySQL (Fulltext indices + Document Chunks)
- **AI/ML**: 
    - OpenRouter API (LLM)
    - OpenAI Embedding API
    - Custom Cosine Similarity Engine
- **Ingestion Tools**: Firecrawl, Smalot PDF Parser, GitHub API

## 📦 Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/raju-sah/my_portfolio.git
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Add your API keys for **OpenRouter**, **OpenAI**, and **Firecrawl** in the `.env` file.

4. **Initialize Database**:
   ```bash
   php artisan migrate
   ```

5. **Ingest Initial Data**:
   ```bash
   php artisan rag:ingest resume /path/to/resume.pdf
   php artisan rag:sync-all
   ```

6. **Run the application**:
   ```bash
   php artisan serve
   ```

---
Built with 💻 and ☕ by [Raju Sah](https://sahraju.com.np/)

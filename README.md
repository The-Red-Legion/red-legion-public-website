# The Red Legion Public Website

This is the public-facing website for **The Red Legion**, a Star Citizen organization that also supports RedMonsterSC in his streaming endeavors.

---

## 🛠 Tech Stack

- **PHP 8.3**  
- **Apache 2** on Ubuntu  
- **Composer** for dependency management  
- **Twig** templating engine  
- **Bootstrap 5** for front-end layout & styling  
- **MySQL / MariaDB** via **PDO** for database access  
- **dotenv** (phpdotenv) for managing environment variables in development

---

## 📁 Repository Structure

```text
red-legion-public-website/
├── app/
│   ├── bootstrap.php         # central bootstrap: sessions, Twig, PDO, etc.
│   ├── views/                # Twig templates
│   └── cache/                # Twig compiled templates (git-ignored)
├── public_html/              # Web root — Apache DocumentRoot should point here
│   ├── index.php
│   ├── assets/               # CSS, JS, images
│   └── other public files
├── vendor/                   # Composer-installed dependencies (git-ignored)
├── composer.json
├── composer.lock
├── .env                      # local environment variables (git-ignored)
└── README.md
```

##

🔒 Configuration & Secrets

.env stores environment variables locally, never commit real secrets to Git

vendor/, app/cache/, .env are in .gitignore

Database credentials, API keys, etc., should be set via .env in dev; in production, via Apache SetEnv or environment variables in PHP process

⚠️ Make Startup Failures Clear

The bootstrap file checks for required DB variables (DB_HOST, DB_NAME, DB_USER, DB_PASS) and will throw a clear runtime error if any are missing. This helps prevent misconfig from causing weird, hard-to-debug behavior.

📜 License & Access

This is a private / internal project. Not open source.
If needed, we can add sections for contribution later.

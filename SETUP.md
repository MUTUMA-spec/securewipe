# SecureWipe — Deployment Guide

## Your Only Steps

### 1. Create a free GitHub account
→ https://github.com/signup

### 2. Create a new PUBLIC repository
→ https://github.com/new
- Name it e.g. `securewipe`
- Set it to **Public** (required for free GitHub Actions + free downloads)

### 3. Upload this project to GitHub
In your new repo, click **"uploading an existing file"**, drag in everything from this ZIP, click **Commit changes**.

### 4. Edit ONE line in `download-tool.php` (line 6):
```php
define('GITHUB_REPO', 'your-username/securewipe');
```
Commit that change.

### 5. Wait ~5 minutes
Go to the **Actions** tab in your GitHub repo. You'll see the build running.
When it finishes, it creates a Release with `SecureWipe.exe` attached.

### 6. Upload your website files to your web server
Upload everything. Done.

---

## How the download link works

GitHub has a permanent, predictable URL for the latest release of any file:

```
https://github.com/USERNAME/REPO/releases/latest/download/SecureWipe.exe
```

Your download button uses exactly that URL. When GitHub Actions builds a new EXE
and publishes it as a release, that URL automatically serves the newest version.
No API calls, no caching, no server-side logic needed.

---

## Updating the tool in future

Just edit `python/secure_wipe_tool.py` and commit the change to GitHub.
The EXE rebuilds automatically in ~5 minutes and the download link updates itself.

## Setting your production URL in the Python tool

Open `python/secure_wipe_tool.py`, find this line and update it before pushing:
```python
url = "https://YOUR_DOMAIN.com/log_completion.php"
```

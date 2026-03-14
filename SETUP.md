# SecureWipe — Setup Guide (read this first)

## Your exact steps

---

### Step 1 — Create a GitHub account (free)
Go to → **https://github.com/signup**
(skip if you already have one)

---

### Step 2 — Create a new repository
1. Go to → **https://github.com/new**
2. Repository name: `securewipe` (or anything you like)
3. Set visibility to **Public**  ← important, free Actions only run on public repos
4. Leave everything else blank — don't add README or .gitignore
5. Click **Create repository**

---

### Step 3 — Upload this project
1. On your new empty repo page, click the link that says **"uploading an existing file"**
2. **Unzip** the securewipe ZIP on your computer
3. Select ALL files and folders inside and drag them into the GitHub browser window
4. Scroll down, click **"Commit changes"**

> ⚠️ Make sure you upload the **contents** of the ZIP, not the ZIP file itself.
> GitHub should show files like `index.php`, `python/`, `.github/` etc. at the root.

---

### Step 4 — Watch the EXE build (takes ~5 minutes)
1. Click the **Actions** tab at the top of your repo
2. You should see a workflow called **"Build SecureWipe.exe"** running (yellow spinner)
3. Click into it to see live build logs
4. When it goes green ✅ → click **Releases** on the right sidebar
5. You'll see a release with `SecureWipe.exe` attached — that's your file

> If the Actions tab shows nothing: go to Actions → click the workflow name on the left
> → click the grey "Run workflow" button → confirm. This forces it to run.

---

### Step 5 — Set your repo name in one file
Open `includes/github_release.php` in any text editor and change line 9:

```php
// BEFORE:
define('GITHUB_REPO', 'YOUR_GITHUB_USERNAME/YOUR_REPO_NAME');

// AFTER (example):
define('GITHUB_REPO', 'johndoe/securewipe');
```

---

### Step 6 — Upload to your web server
Upload **all files** from the ZIP to your web server (same as you normally would).
The `.github/` folder can be skipped — it's only needed on GitHub.

That's it. The download button on your site will now serve the EXE automatically.

---

## How the auto-build works

```
You upload code to GitHub
        ↓
GitHub spins up a Windows virtual machine (free)
        ↓
It installs Python, downloads ADB from Google,
runs PyInstaller → produces SecureWipe.exe (~20 MB)
        ↓
Creates a GitHub Release with SecureWipe.exe attached
        ↓
Your download-tool.php fetches the URL via GitHub API
        ↓
download-proxy.php streams the file to users
(users only see YOUR domain — never github.com)
```

## Updating the tool in future
Just edit `python/secure_wipe_tool.py` and push/upload it to GitHub again.
The EXE rebuilds automatically and the download button updates within an hour.

## If the download page shows "temporarily unavailable"
It means the GitHub API couldn't be reached from your server, OR no release
exists yet (the build hasn't run). Check:
1. Did the GitHub Actions build finish? (green tick on Actions tab)
2. Is there a Release with SecureWipe.exe? (Releases tab on your repo)
3. Is GITHUB_REPO set correctly in `includes/github_release.php`?

# HRMP - Human Resource Management Platform

A web-based HR management system for tracking employee attendance, leave requests, and other HR functions.

---

## 🚀 Deployment Guide (cPanel with Git)

Follow these steps to deploy or update the platform on a cPanel server using Git.

### 1. Connect Git Repository

1. Log in to your cPanel account.
2. Go to **Git Version Control** → click **Create Repository**.
3. Clone this repository: https://github.com/christojacques/hrmp.git
4. Set the **deployment path** to your target web directory (e.g., `public_html/` or `udugpdss/`).

### 2. Auto-Deploy Changes

In the Git repository settings on cPanel:
- Enable **automatic deployment** if available.
- If not, use the **Pull or Deploy** button manually after each update.

---

## 🔄 Updating the Platform (Safely)

When you need to update the codebase:

### Step 1: **Pull latest updates via Git**
SSH into your cPanel account (or use the File Manager Git interface) and run:

```bash
cd /home/username/public_html/hrmp
git pull origin main
```

### Step 2: Ensure the following are NOT overwritten:
1. uploads/ folder (contains user files and photos)
2. database/ folder or .sql
3. config.php file or configuration settings (if applicable)
4. These should be excluded in .gitignore.

## 🧩 How to Add New Features or Fix Bugs
### 1. Create a new branch locally:
```bash
git checkout -b feature/your-feature-name
```
### 2. Make your changes, commit them:
```bash
git commit -am "Added: your feature name"
```
#### Note : Push the branch and merge to main after testing.


## 🔐 cPanel Backup System
1. Automated Backups on cPanel (Namecheap Hosting)
Namecheap provides daily, weekly, and monthly automatic backups via the AutoBackup plugin in cPanel.

### 🔧 Steps to Access and Download Backups
1.  Log in to your cPanel account.

2. In the search bar, type:
    - AutoBackup Or scroll down to the section: Exclusive for Namecheap Customers.

3. Open the AutoBackup plugin.

- You’ll see tabs for Daily, Weekly, and Monthly backups. Select your desired backup date.

- Review and select the items you want to back up:

    1. Files (public_html, uploads, etc.)

    2. Databases

    3. Email accounts

    4. Scroll down to "Get Full Backup as Format", and choose:

    5. .ZIP or .TAR.GZ format from the dropdown.

    6. Click on the "Get" button to generate the backup.

    7. Monitor the "Action Logs" section — once the backup is completed, you’ll see a Download button.

### 📌 Note: Always download and store a copy of the latest backup before performing updates to the platform via Git or any manual changes.

## 👨‍💻 Maintainers
#### Name: Nazmul Hasan Piash

#### GitHub: https://github.com/devnhpiash

#### Email: developer.nhpiash@gmail.com



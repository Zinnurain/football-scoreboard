# Football ScoreBoard (Symfony 8)

A simple Football World Cup ScoreBoard CLI project built with Symfony 8.  
It allows starting games, updating scores, finishing games, and displaying a summary sorted by total score.

---

## **If Git is not installed:**

- **For macOS:**

```brew install git```

- **For Ubuntu / Debian:**

```sudo apt update```

```sudo apt install git -y```

- **For Windows:**

Download Git from https://git-scm.com/download/win and install.

## **Clone the repository**

[//]: # (## **1️⃣ Clone the repository**)

git clone https://github.com/Zinnurain/football-scoreboard.git

cd football-scoreboard

## **Using Docker**

Step 1 — Build the Docker container

```docker-compose build```


⚠️ First build may take a few minutes (downloads PHP, installs Composer, dependencies).

Step 2 — Run the ScoreBoard CLI

```docker-compose run --rm app php bin/console app:scoreboard '[{"Mexico":0,"Canada":6},{"Spain":10,"Brazil":2},{"Germany":2,"France":2}]'```


**Note: Replace the JSON array with your own games
Output will show the summary sorted by total score.

Step 3 — Run PHPUnit tests

```docker-compose run --rm app php bin/phpunit```

Runs all tests inside the container
No PHP or PHPUnit installation needed on your host

======================================================

## **Without Docker (local setup)**
## **Requirements**

- PHP >= 8.4
- Composer
- Git

---
**Step 1 — Install PHP and Composer**

**To Install PHP**

- **For macOS:**

```brew install php@8.4```

- **For Ubuntu / Debian:**

```sudo apt update```

```sudo apt install php8.4 php8.4-cli php8.4-xml php8.4-mbstring php8.4-zip unzip -y```

- **For Windows:**
Download PHP from https://windows.php.net/download/
and add it to your PATH.

Check Installed version : ```php -v```

**Install Composer:** https://getcomposer.org/download/

**Step 2 — Install project dependencies**

```composer install```

**Note: Run this into the project directory.

**Step 3 — Run the ScoreBoard CLI**

```php bin/console app:scoreboard '[{"Mexico":0,"Canada":6},{"Spain":10,"Brazil":2},{"Germany":2,"France":2}]'```

**Note: Replace the JSON array with your own games
Output will show the summary sorted by total score.

**Step 4 — Run PHPUnit tests**

```php bin/phpunit```


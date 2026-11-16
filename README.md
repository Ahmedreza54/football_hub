# Football Hub

## 1. Project Overview

Football Hub is a web-based football management system developed using Laravel. It allows users to manage football teams, players, matches, scores and league standings through a simple web interface.

## 2. Project Objectives

- Develop a football management website.
- Manage football teams and players.
- Create and manage football matches.
- Record match scores and results.
- Calculate league standings automatically.
- Display football fixtures using an external API.
- Provide reminders for scheduled matches.

## 3. Technologies Used

- PHP
- Laravel
- HTML
- CSS
- Bootstrap 5.3.3
- JavaScript
- SQLite for local development
- Football API
- Git and GitHub

## 4. Main Features

### Dashboard
- Displays football statistics.
- Shows live, upcoming and finished fixtures.
- Allows users to search for teams and players.

### Team Management
- Add and manage football teams.
- Store team names and countries.
- Delete teams.

### Player Management
- Add and manage players.
- Store player names and positions.
- Assign players to teams.

### Match Management
- Create football matches.
- Select home and away teams.
- Set match dates, times and venues.
- Edit and delete matches.
- Record scores and results.

### League Table
- Calculates played, won, drawn and lost matches.
- Calculates goals for, goals against and goal difference.
- Awards three points for a win and one point for a draw.
- Automatically ranks teams using their results.

### Match Reminders
- Creates reminders one hour before scheduled matches.
- Displays reminders on the Matches page.
- Supports browser notifications.
- Uses Laravel scheduled tasks to process reminders.

**Note:** Browser notifications currently require the Matches page to remain open.

## 5. Database Structure

The main database tables are:

| Table | Description |
|---|---|
| teams | Stores football team information |
| players | Stores player information |
| matches | Stores match details and scores |
| match_reminders | Stores match reminder information |

## 6. Installation and Setup

### Requirements
- PHP
- Composer
- Laravel
- Git

### Step 1: Clone the repository

```bash
git clone https://github.com/Ahmedreza54/football_hub.git
```

### Step 2: Open the project folder

```bash
cd football_hub
```

### Step 3: Install dependencies

```bash
composer install
```

### Step 4: Configure the environment

Copy `.env.example` to `.env`.

Generate the application key:

```bash
php artisan key:generate
```

Configure the database in the `.env` file.

### Step 5: Run migrations

```bash
php artisan migrate
```

### Step 6: Start the application

```bash
php artisan serve
```

Open the application:

http://127.0.0.1:8000

### Step 7: Start the reminder scheduler

Open another terminal in the project folder:

```bash
php artisan schedule:work
```

Keep the scheduler running to process reminders.

## 7. GitHub Repository

Project repository:

https://github.com/Ahmedreza54/football_hub

Git and GitHub are used to track project development and maintain version history.

## 8. Testing

The following features have been tested during local development:

- Team management.
- Player management.
- Match creation and management.
- Match scores and results.
- League table calculations.
- Dashboard search.
- Football fixture display.
- Match reminder creation.
- Browser notifications.
- Scheduled reminder processing.

## 9. Limitations

- The application has been developed and tested locally.
- Browser notifications require the Matches page to remain open.
- Local development currently uses SQLite.
- Football fixture information depends on the external API.
- The Laravel server and scheduler must be running for local operation.

## 10. Future Improvements

- Improve reminder delivery when the browser is closed.
- Add user authentication.
- Improve mobile responsiveness.
- Add more football statistics.
- Complete deployment and testing on the university hosting server.

## 11. Project Information

**Project Name:** Football Hub

**Framework:** Laravel

**Repository:** https://github.com/Ahmedreza54/football_hub

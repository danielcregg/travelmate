# Travel Mate

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)

A web application that connects travelers with friendly, like-minded local tour guides at their destination.

> **Note:** This repository is a fork of [minhtran365411/travelmate](https://github.com/minhtran365411/travelmate).

## Overview

Travel Mate is a full-stack web platform designed to help travelers find and connect with local tour guides. Users can sign up as either a traveler or a tour guide, browse guide profiles, match with a compatible guide, and communicate via a built-in real-time chat system. The application features user authentication, profile management, an image gallery, and a matchmaking workflow.

## Features

- **User Registration and Authentication** -- Sign up as a traveler or tour guide with secure password hashing
- **Profile Management** -- Create and update user profiles with personal details and photos
- **Guide Matching** -- Browse and request connections with local tour guides
- **Real-Time Chat** -- Built-in messaging system for matched travelers and guides
- **Image Gallery** -- Upload and share travel photos
- **Responsive Design** -- Mobile-friendly interface built with Bootstrap 5

## Prerequisites

- **PHP** 7.4 or higher
- **MySQL** 5.7 or higher
- **Apache** or **Nginx** web server with PHP support (e.g., XAMPP, WAMP, MAMP, or LAMP stack)

## Getting Started

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/danielcregg/travelmate.git
   cd travelmate
   ```

2. Set up the database:
   - Create a MySQL database named `auth`
   - Import the provided SQL schema:
     ```bash
     mysql -u root -p auth < image.sql
     ```

3. Configure the database connection:
   - Open `dbConfig.php` and update the credentials to match your local environment:
     ```php
     $server = 'localhost';
     $username = 'root';
     $password = '';
     $database = 'auth';
     ```

4. Place the project in your web server's document root (e.g., `htdocs` for XAMPP).

### Usage

1. Start your Apache and MySQL services.
2. Navigate to `http://localhost/travelmate` in your browser.
3. Register a new account as either a traveler or tour guide.
4. Complete your profile to appear in search results.
5. Browse available tour guides and request a connection.
6. Once matched, use the chat feature to plan your trip.

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP | Server-side logic and authentication |
| MySQL | Database storage for users, chats, and media |
| HTML5 | Page structure and semantic markup |
| CSS3 | Custom styling and layout |
| JavaScript | Client-side interactivity and AJAX chat |
| Bootstrap 5 | Responsive grid system and UI components |

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

<p align="center">
  <img src="logo-white.png" alt="Vira Logo" width="120" />
  <p align="center">
    <img src="https://img.shields.io/badge/status-active-brightgreen" alt="Status" />
    <img src="https://img.shields.io/github/last-commit/sinnshr/Vira" alt="Last Commit" />
    <img src="https://img.shields.io/badge/license-MIT-blue" alt="License" />
  </p>
</p>

## Table of Contents
- [Overview](#overview)
- [Quickstart](#quickstart)
- [Features](#features)
- [Used Technologies](#used-technologies)
- [Project Structure](#project-structure)
- [Project Index](#project-index)
- [Roadmap](#roadmap)
- [Contribution](#contribution)
- [License](#license)

---

## Overview
Vira is a clean, lightweight online bookstore built with PHP and Hack. It provides a simple interface to browse, search, and manage books in your collection.

## Quickstart
1. **Clone the repo**
   ```bash
   git clone https://github.com/sinnshr/Vira.git
   cd Vira
   ```
2. **Install dependencies**
   ```bash
   composer install
   ```
3. **Run locally**
   ```bash
   php -S localhost:8000 -t public
   ```
4. Visit `http://localhost:8000` in your browser.

## Features
- Clean, responsive UI powered by PHP & Hack templates
- Modular codebase for easy extension
- Asset bundling and routing built-in

## Used Technologies
- ![PHP](https://img.shields.io/badge/PHP-777BB4?logo=PHP&logoColor=white) **PHP**
- ![Hack](https://img.shields.io/badge/Hack-878787?logo=PHP&logoColor=white) **Hack**
- ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=JavaScript&logoColor=black) **JavaScript**
- ![Composer](https://img.shields.io/badge/Composer-FF5A51?logo=Composer&logoColor=white) **Composer**
- ![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=HTML5&logoColor=white) **HTML5**
- ![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=CSS3&logoColor=white) **CSS3**
- ![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-38B2AC?logo=Tailwind-CSS&logoColor=white) **Tailwind CSS**

## Project Structure
```
Vira/
├── assets/        # Images, styles, scripts
├── includes/      # Header, footer, shared templates
├── public/        # Web root (index.php, route.php)
├── src/           # Core PHP/Hack code
├── composer.json  # Dependencies
└── logo.png       # Project logo
```

## Project Index
- **index.php**: Entry point, loads router
- **route.php**: Defines URL routes
- **includes/header.php**: Site header
- **includes/footer.php**: Site footer
- **src/Book.php**: Book model & logic

## Roadmap
- [ ] User authentication & profiles
- [ ] Shopping cart & checkout
- [ ] Admin dashboard for inventory
- [ ] Pagination & filters
- [ ] Automated tests & CI integration
- [ ] Enable browsing and searching for books by title, author, or ISBN
- [ ] Enhance mobile compatibility and ensure a fully responsive user interface

## Contribution
1. Fork the repo
2. Create a new branch (`git checkout -b feature-name`)
3. Make your changes
4. Submit a pull request

Please follow the [Code of Conduct](CODE_OF_CONDUCT.md).

## License
Distributed under the MIT License. See [LICENSE](LICENSE) for details.
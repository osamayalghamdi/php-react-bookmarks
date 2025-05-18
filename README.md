# PHP React Bookmarks

A simple URL bookmarking application. Backend built with PHP, frontend with React. Uses PostgreSQL (via Docker).

## Features

*   Add, Edit, Delete, and List URL bookmarks.
*   Search bookmarks by title or URL.

## Tech Stack

*   **Backend:** PHP
*   **Frontend:** React
*   **Database:** PostgreSQL (Dockerized)

## Quick Start

1.  **Backend Setup:**
    *   Navigate to `compose-postgres` and run `docker-compose up -d`.
    *   Ensure the `bookmarks` table is created in your `postgres` database.
    *   Configure DB connection (e.g., via environment variables for `db/Database.php`).
    *   Start PHP server from the project root: `php -S localhost:3000 -t .` (or your preferred port for the API).

2.  **Frontend Setup:**
    *   Navigate to `client-bookmarks-react`.
    *   Run `npm install`.
    *   Run `npm start`. (This usually opens on a different port like 3001 if your API is on 3000, or adjust API base URL in `src/api.js`).

3.  Open the React app URL in your browser.

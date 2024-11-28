# **Screen Printing Traceability Application**

A software application for tracking the use and managing the states of screen printing screens in a CMS environment. This solution is designed to improve the management, quality, and traceability of industrial processes.

---

## **Table of Contents**
1. [Description](#description)
2. [Main Features](#main-features)
3. [Prerequisites](#prerequisites)
4. [Installation and Configuration](#installation-and-configuration)
5. [Usage](#usage)
6. [File Structure](#file-structure)
7. [Author](#author)

---

## **Description**
This application allows operators and administrators to track the states of screen printing screens during various phases of production and cleaning, with options for searching and exporting the usage history.

---

## **Main Features**
1. **Screen Management**:
   - Adding and deleting screens by administrators.
   - Viewing existing screens with their information.

2. **State Tracking**:
   - Recording the state of screens (OK/KO) for the following operations:
     - Start of production.
     - End of production.
     - Cleaning before and after.

3. **Search and History**:
   - Searching screens by:
     - Screen number.
     - Product reference.
     - Date range.
     - Face.
   - Exporting usage history.

4. **Dedicated Spaces**:
   - User space for operators.
   - Admin space for management and tracking.

---

## **Prerequisites**
Before you begin, ensure the following elements are installed and configured on your machine:

1. **Development Environment**:
   - [PHP](https://www.php.net/downloads) (version 7.4 or higher).
   - [Apache](https://httpd.apache.org/) or any other compatible server.
   - [PostgreSQL](https://www.postgresql.org/download/) (version 12 or higher).
   - [DBeaver](https://dbeaver.io/download/) for managing the database (or any other tool of your choice).

2. **Recommended Tools**:
   - [XAMPP](https://www.apachefriends.org/index.html) or [WAMP](http://www.wampserver.com/) for setting up a local environment.
   - A code editor such as [Visual Studio Code](https://code.visualstudio.com/) or [PHPStorm](https://www.jetbrains.com/phpstorm/).

3. **Version Control Tools**:
   - [Git](https://git-scm.com/) to clone and manage the project repository.

4. **Web Browser**:
   - A modern browser compatible with web applications (Chrome, Firefox, Edge, etc.).

5. **PHP Extension**:
   - Ensure the following extensions are enabled in your `php.ini` file:
     ```ini
     extension=pdo_pgsql
     extension=pdo
     ```

---

## **Installation and Configuration**

1. **Clone the repository**:
   ```bash
   git clone https://github.com/YathrebSamaali/SuiviEcrans.git

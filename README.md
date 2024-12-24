
# GetMeADrink (Demo project)

**Order software for drinks – flexible, efficient, and versatile!**

GetMeADrink is a powerful software designed to manage orders, specifically tailored for use in hospitality environments.
It offers an intuitive table overview, detailed order management, and a comprehensive product database with the ability to create product variations.

While primarily designed for drinks, the software can also be adapted for other ordering processes.

---

## **Features**

- **Table Overview:** Visual representation and management of tables.
- **Order Overview:** Keep track of all orders efficiently.
- **Product Database:** Easily manage products and their variations.
- **Flexible Usage:** Applicable for drinks and beyond.

---

## **Tech Stack**

GetMeADrink is built on a modern and proven technology stack:

- ![MySQL](https://img.shields.io/badge/-MySQL-4479A1?logo=mysql&logoColor=white&style=flat-square) **MySQL/MariaDB** – For database management.
- ![PHP Symfony](https://img.shields.io/badge/-Symfony-000000?logo=symfony&logoColor=white&style=flat-square) **PHP (Symfony)** – As the backend framework.
- ![VueJS](https://img.shields.io/badge/-Vue.js-4FC08D?logo=vue.js&logoColor=white&style=flat-square) **Vue.js** – For a dynamic and user-friendly frontend.
- ![Devenv](https://img.shields.io/badge/-Devenv-5277C3?logo=nixos&logoColor=white&style=flat-square) **Devenv** – For stable and reproducible environment configurations.
- ![Bootstrap](https://img.shields.io/badge/-Bootstrap-7952B3?logo=bootstrap&logoColor=white&style=flat-square) **Bootstrap** – For styling and responsive design.

---

## **Installation**

### Prerequisites

- **Devenv:** If desired, to provide a consistent environment. ([Guide](https://devenv.sh/getting-started))

--- **or** ---

- **Database:** MySQL or MariaDB installed and configured.
- **PHP:** Version 8.2 or higher with Composer.
- **Node.js:** For frontend build tooling.

### Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/cyl3x/GetMeADrink.git
   cd GetMeADrink
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Set up:**
   ```bash
   composer setup
   ```

4. **Start the server:**
   ```bash
   symfony server:start
   ```

### **Setup Script**

For ease of setup, the project includes predefined scripts in the `composer.json` file:

- **Full setup:**
   ```bash
   composer setup
   ```
   This will:
   - Drop and recreate the database.
   - Apply migrations.
   - Install dependencies and build the frontend.
   - Generate demo data.

- **Update setup:**
   ```bash
   composer setup:update
   ```
   This will:
   - Install any new dependencies.
   - Apply migrations.
   - Rebuild the frontend.

- **Database migration:**
   ```bash
   composer migrate
   ```
   This applies all pending database migrations.

---

## **Contributing**

The project was developed by:

- cyl3x ([GitHub](https://github.com/cyl3x/)) – Lead Developer
- THN_Michi ([GitHub](https://github.com/Michi-M22)) – Developer
- jonathanleiermann ([GitHub](https://github.com/jonathanleiermann)) – Developer

---

## **License**

GetMeADrink is licensed under the MIT license. For more information, see the [LICENSE](./LICENSE) file.

---

Thank you for using GetMeADrink! Cheers! 🍻

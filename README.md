# Atelier Tailleur (University Project)

This is a PHP + MySQL (XAMPP) web project for a university assignment.

**Requirements**
1. XAMPP installed (Apache + MySQL)
2. A browser

**How To Run Locally (Windows + XAMPP)**
1. Place the project in your XAMPP web root: `C:\xampp\htdocs\atelier_tailleur\atelier_tailleur`
2. Open XAMPP Control Panel
3. Start `Apache` and `MySQL`
4. Open the website in your browser:
   - `http://localhost/atelier_tailleur/atelier_tailleur/index.php`

**Database Setup**
The app auto-creates the database and tables when the site loads.
1. Ensure `MySQL` is running in XAMPP
2. Visit the homepage once to trigger setup

Optional manual setup:
1. Open `http://localhost/phpmyadmin`
2. Import `C:\xampp\htdocs\atelier_tailleur\atelier_tailleur\database.sql`

**How To Test**
1. Registration + Login:
   - Go to `Register`
   - Create an account
   - Log in
2. Booking flow:
   - Go to `Book`
   - Fill the form
   - Submit and check your booking in `Dashboard`
3. Contact form:
   - Go to `Contact`
   - Submit a message
4. Admin panel (basic view):
   - Open `http://localhost/atelier_tailleur/atelier_tailleur/admin/admin.php`

**Notes**
1. This is a coursework project, so the password reset is a demo flow (reset link is shown on screen).
2. No paid GitHub subscription is needed to host this code. A free GitHub account is sufficient.

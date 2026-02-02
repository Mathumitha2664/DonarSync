# DonarSync 🩸

DonarSync is a **web-based donor management system** that helps track blood donors and receiver requests efficiently.  
Built with **PHP, MySQL, HTML, CSS, and JavaScript**, it provides a modern dashboard and secure data management.

---

## 🌟 Features

- **Donor Registration:** Add new donors with personal details and blood group.  
- **Receiver Requests:** Receivers can request blood and match with available donors.  
- **Dashboard:** View donor and receiver data, filter by blood group, city, or availability.  
- **Reports:** Print-friendly donor and request reports.  
- **Secure Login:** Admin login with role-based access for staff.

---

## 📌 Donor Registration (`register.html`)

### 1. User Access
Open a browser and navigate to:

```

[http://localhost/db/register.html](http://localhost/db/register.html)

````

This loads the **Donor Registration Form**.  

*(Optional screenshot)*  
`![Register Page](screenshots/register.png)`

---

### 2. Form Fields
| Field | Description |
|-------|-------------|
| Name | Donor full name |
| Age | Donor age |
| Gender | Male/Female/Other |
| Blood Group | Dropdown (A+, A-, B+, etc.) |
| City | Donor's city |
| Contact Number | Phone number for notifications |
| Email | Optional, for alerts |

---

### 3. Form Submission
When the **Register** button is clicked, the form sends a **POST request** to `register.php`.

Example (simplified):

```php
<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $age = $_POST['age'];
    $blood = $_POST['blood'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    // Insert into database
    $sql = "INSERT INTO donors (name, age, blood_group, city, contact) 
            VALUES ('$name','$age','$blood','$city','$contact')";
    mysqli_query($conn, $sql);
}
?>
````

---

### 4. Database Integration

Data is stored in **MySQL database (`s.sql`)**.

Example table `donors`:

```
donors(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    age INT,
    blood_group VARCHAR(5),
    city VARCHAR(50),
    contact VARCHAR(15)
)
```

---

### 5. Post Submission

* Donor is added to the **database**.
* Admin can view new entry on the **dashboard**.
* Optional: Send confirmation message to donor.

---

## 🏗️ System Architecture

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│ Frontend    │ <---> │ PHP Backend │ <---> │ MySQL DB    │
│ register.html│      │ register.php│       │ donors/receiver tables
└─────────────┘       └─────────────┘       └─────────────┘
```

**Flow Explanation:**

1. User fills **register.html** form
2. Data is submitted via **POST request**
3. PHP script `register.php` processes and validates data
4. Data is saved into **MySQL database**
5. Dashboard (`index.php` / `home.html`) retrieves data using **SELECT queries**

---

## 🔧 How to Run Locally

1. Install **XAMPP**.
2. Copy `DonarSync` folder to:

```
C:\xampp\htdocs\db
```

3. Start **Apache** and **MySQL**.
4. Import `s.sql` in **phpMyAdmin**.
5. Open browser:

```
http://localhost/db/register.html
```

6. Fill form → Click **Register** → Check **dashboard** for new entry.

---

## 🛠️ Technology Stack

| Component | Technology             |
| --------- | ---------------------- |
| Frontend  | HTML, CSS, JavaScript  |
| Backend   | PHP                    |
| Database  | MySQL                  |
| Server    | XAMPP (Apache + MySQL) |
| IDE       | VS Code                |

---

## 🧪 Testing

* Register new donors → Confirm in `donors` table
* Submit receiver requests → Check matches in dashboard
* Filter by blood group or city → Confirm dashboard updates
* Print reports → Test print functionality

---

## 📈 Future Enhancements

* Email/SMS notifications to donors
* AI-based donor suggestions (nearest match)
* Mobile-friendly React / React Native version
* Real-time dashboards using WebSocket
* Admin analytics & visualization

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch:

```bash
git checkout -b feature/AmazingFeature
```

3. Commit changes:

```bash
git commit -m 'Add AmazingFeature'
```

4. Push branch and open Pull Request

---

## 📄 License

© 2026 Mathumitha R. All rights reserved.
```

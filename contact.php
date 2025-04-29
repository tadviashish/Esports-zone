<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone Contact</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>

    <header>
        <h1>ESport-Zone</h1>
        <nav>
            <a href="#">HOME</a>
        </nav>
    </header>
    <section class="contact-section">
        <div class="form-container">
            <h2>Connect With Our Team</h2>
            <p>Fill the form so that our team can reach out to you</p>

            <form action="#" method="POST">
                <label for="name">NAME</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="email">E-MAIL</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">SUBMIT</button>
            </form>
        </div>
    </section>
    <a href="about.php">
        <button class="about-btn">ABOUT</button>
    </a>
</body>
</html>

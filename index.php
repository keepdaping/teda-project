<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEDA - Teso Elites Development Association</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

<header>
    <img src="public/images/logo.png" alt="TEDA Logo">
    <h1>TEDA</h1>
    <p>Teso Elites Development Association</p>
</header>

<nav>
    <a href="#about">About Us</a>
    <a href="#focus">Focus Areas</a>
    <a href="#resources">Resources</a>
    <a href="#get">Get Involved</a>
    <a href="#clubs">TEDA Clubs</a>
    <a href="#donate">Donate</a>
</nav>

<section class="hero">
    <div class="hero-content">
        <h1>Empowering Teso Youth for a Sustainable Future</h1>
        <p>
            Teso Elites Development Association (TEDA) is a youth-led movement
            transforming communities through education, innovation, culture, and leadership.
        </p>
        <div class="hero-buttons">
            <a href="#get" class="btn">Join Us</a>
            <a href="#donate" class="btn btn-outline">Donate</a>
        </div>
    </div>
</section>

<!-- ABOUT US -->
<section id="about">
    <h2>About Us</h2>
    <p>
        Teso Elites Development Association (TEDA) is one of the largest youth-led organizations
        operating in the Teso and Bukeddi sub-regions of Uganda...
    </p>

    <h3>Vision</h3>
    <p>An empowered generation of Teso youth driving education, culture, and sustainable development</p>

    <h3>Mission</h3>
    <p>Empower youth and promote education, culture, and identity among the youth of Teso as a foundation for sustainable development.</p>

    <h3>Core Values</h3>
    <ul>
        <li>Unity</li>
        <li>Respect</li>
        <li>Inclusivity</li>
        <li>Integrity</li>
        <li>Volunteerism</li>
        <li>Youth Empowerment</li>
        <li>Cultural Preservation</li>
        <li>Innovation</li>
        <li>Accountability</li>
        <li>Service to Community</li>
    </ul>

    <div class="card">
        <h3>Our Team (Directors)</h3>
        <div class="directors">
            <div>
                <img src="public/images/director 1.jpg" alt="Director 1">
                <p>Director 1</p>
            </div>
            <div>
                <img src="public/images/director 2.jpg" alt="Director 2">
                <p>Director 2</p>
            </div>
        </div>
    </div>
</section>

<!-- FOCUS AREAS -->
<section id="focus">
    <h2>Focus Areas</h2>

    <div class="card">
        <img src="public/images/img6.jpg" alt="Education">
        <h3>Education</h3>
        <p>TEDA champions education as a cornerstone for personal growth and community development...</p>
    </div>

    <div class="card">
        <img src="public/images/img4.jpg" alt="Climate Action">
        <h3>Climate Action</h3>
        <p>The issue to be addressed is the urgency of climate adaptation among young people...</p>
    </div>

    <div class="card">
        <h3>Health</h3>
        <p>TEDA prioritizes health promotion and disease prevention as a foundation...</p>
    </div>

    <div class="card">
        <h3>Skilling and Innovation</h3>
        <p>TEDA promotes skilling and innovation as powerful tools for economic empowerment...</p>
    </div>

    <div class="card">
        <h3>Teso Youth Forum</h3>
        <select>
            <option>2024</option>
            <option>2025</option>
            <option>2026</option>
            <option>2027</option>
            <option>2028</option>
        </select>
        <p>The Teso Youth Forum is an annual gathering that brings together young people...</p>
    </div>

    <div class="card">
        <h3>Entrepreneurship</h3>
        <p>TEDA promotes entrepreneurship as a sustainable pathway to economic empowerment...</p>
    </div>

    <div class="card">
        <h3>Culture and Identity</h3>
        <p>Promotion of cultural values and identity.</p>
    </div>
</section>

<!-- RESOURCES -->
<section id="resources">
    <h2>Resources</h2>
    <ul>
        <li>Publications</li>
        <li>News</li>
        <li>Blogs</li>
        <li>Events and Activities</li>
    </ul>
</section>

<!-- GET INVOLVED -->
<section id="get">
    <h2>Get Involved</h2>
    <h3>Membership Form</h3>
    <form action="backend/submit_membership.php" method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <textarea name="message" placeholder="Why do you want to join?"></textarea>
        <button type="submit">Join TEDA</button>
    </form>
</section>

<!-- GALLERY -->
<section id="gallery">
    <h2>Our Activities</h2>
    <div class="gallery">
        <img src="public/images/img1.jpg" onclick="openModal(this.src)" alt="Activity 1">
        <img src="public/images/img2.jpg" onclick="openModal(this.src)" alt="Activity 2">
        <img src="public/images/img3.jpg" onclick="openModal(this.src)" alt="Activity 3">
        <img src="public/images/img4.jpg" onclick="openModal(this.src)" alt="Activity 4">
        <img src="public/images/img5.jpg" onclick="openModal(this.src)" alt="Activity 5">
        <img src="public/images/img6.jpg" onclick="openModal(this.src)" alt="Activity 6">
    </div>
</section>

<!-- MODAL -->
<div id="modal" class="modal" onclick="closeModal()">
    <img id="modal-img" alt="Gallery image">
</div>

<!-- TEDA CLUBS -->
<section id="clubs">
    <h2>TEDA Clubs</h2>
    <h3>Contact Us</h3>
    <form action="backend/submit_contact.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Message"></textarea>
        <button type="submit">Send Message</button>
    </form>
</section>

<!-- DONATE -->
<section id="donate">
    <h2>Support Our Work</h2>
    <p>Your contribution helps empower youth across Teso.</p>
    <a href="https://www.paypal.com/donate" target="_blank" class="btn">Donate via PayPal</a>

    <h3>Donate via Mobile Money</h3>
    <p><strong>MTN:</strong> +256 775 375249</p>
    <p><strong>Airtel:</strong> +256 774 856806</p>
    <p>Send your support and help us empower youth.</p>
</section>

<!-- FRIENDS & AMBASSADORS -->
<section>
    <h2>Friends &amp; Ambassadors</h2>
    <div class="social">
        <a href="https://www.linkedin.com/company/teso-elite-development-association-teda/">LinkedIn</a>
        <a href="https://x.com/tedayouthteso">X (Twitter)</a>
        <a href="https://whatsapp.com/channel/0029Vb5jNbhAO7RDvUoENq1T">WhatsApp</a>
        <a href="https://www.tiktok.com/@tedayouthteso">TikTok</a>
        <a href="https://www.facebook.com/profile.php?id=61580124693716">Facebook</a>
    </div>
</section>

<footer>
    <p>&copy; 2026 TEDA - Teso Elites Development Association</p>
</footer>

<script src="public/js/main.js"></script>

</body>
</html>

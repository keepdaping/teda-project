<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEDA - Teso Elites Development Association</title>
    <link rel="stylesheet" href="/teda/public/css/style.css?v=102">
</head>

<body>

<header>
    <img src="public/images/logo.png" alt="TEDA Logo">
    <div class="header-text">
        <h1>TEDA</h1>
        <p>Teso Elites Development Association</p>
    </div>
</header>

<nav>
    <a href="#about">About</a>
    <a href="#resources">Resources</a>
    <a href="#contact">Contact</a>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">Youth-Led · Community-Driven</span>
        <h1>Empowering Teso Youth</h1>
        <p class="hero-sub">
            Building a stronger future through education, innovation, and community action.
        </p>
        <div class="hero-buttons">
            <a href="#resources" class="btn btn-primary">Join Us</a>
            <a href="#contact" class="btn btn-ghost">Donate</a>
        </div>
    </div>
</section>

<!-- ── ABOUT + FOCUS ─────────────────────────────────────── -->
<section id="about" class="section">
    <div class="container">

        <!-- About -->
        <span class="label">Who we are</span>
        <h2>About TEDA</h2>
        <p class="lead">
            TEDA is a youth-led organization driving change across Teso through
            education, leadership, and community development.
        </p>

        <div class="split-grid">
            <div class="info-block">
                <h3>Vision</h3>
                <p>Empowered youth shaping sustainable communities.</p>
            </div>
            <div class="info-block">
                <h3>Mission</h3>
                <p>To equip young people with skills and opportunities to lead change.</p>
            </div>
        </div>

        <p class="sub-heading">Core Values</p>
        <ul class="pill-list">
            <li>Unity</li>
            <li>Integrity</li>
            <li>Innovation</li>
            <li>Inclusivity</li>
            <li>Leadership</li>
            <li>Community Service</li>
        </ul>

        <p class="sub-heading">Our Team</p>
        <div class="team-row">
            <div class="director-card">
                <img src="public/images/director 1.jpg" alt="Director 1">
                <p>Director 1</p>
            </div>
            <div class="director-card">
                <img src="public/images/director 2.jpg" alt="Director 2">
                <p>Director 2</p>
            </div>
        </div>

        <!-- Focus Areas -->
        <div class="block-sep">
            <span class="label">What we do</span>
            <h2>Focus Areas</h2>
            <p class="lead">Our programs focus on empowering youth across key areas.</p>

            <div class="cards-grid">
                <div class="card">
                    <img src="public/images/img6.jpg" alt="Education">
                    <h3>Education</h3>
                    <p>Expanding access to learning opportunities.</p>
                </div>
                <div class="card">
                    <img src="public/images/img4.jpg" alt="Climate Action">
                    <h3>Climate Action</h3>
                    <p>Promoting sustainability and environmental awareness.</p>
                </div>
                <div class="card">
                    <h3>Health</h3>
                    <p>Improving youth wellbeing and awareness.</p>
                </div>
                <div class="card">
                    <h3>Innovation</h3>
                    <p>Building skills for modern opportunities.</p>
                </div>
                <div class="card">
                    <h3>Youth Forum</h3>
                    <p>Connecting youth across the region.</p>
                </div>
                <div class="card">
                    <h3>Entrepreneurship</h3>
                    <p>Supporting business and self-employment.</p>
                </div>
                <div class="card">
                    <h3>Culture</h3>
                    <p>Preserving identity and traditions.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ── RESOURCES + JOIN ──────────────────────────────────── -->
<section id="resources" class="section section--tinted">
    <div class="container">

        <!-- Resources -->
        <span class="label">Library</span>
        <h2>Resources</h2>
        <ul class="resource-list">
            <li>📘 Publications</li>
            <li>📰 News &amp; Updates</li>
            <li>✍️ Blogs</li>
            <li>📅 Events</li>
        </ul>

        <!-- Join -->
        <div class="block-sep">
            <div class="form-wrap">
                <span class="label">Take action</span>
                <h2>Join TEDA</h2>
                <p class="lead">Join a growing community of youth creating real impact.</p>

                <form action="backend/submit_membership.php" method="POST">
                    <div class="form-row">
                        <input type="text"  name="fullname" placeholder="Full Name"     required>
                        <input type="email" name="email"    placeholder="Email Address" required>
                    </div>
                    <input type="text" name="phone" placeholder="Phone Number" required>
                    <textarea name="message" placeholder="Why do you want to join?" rows="4"></textarea>
                    <button type="submit" class="btn btn-primary btn-full">Join Now</button>
                </form>
            </div>
        </div>

    </div>
</section>

<!-- GALLERY (standalone) -->
<section id="gallery" class="section">
    <div class="container">
        <span class="label">In the field</span>
        <h2>Our Activities</h2>
        <p class="lead">Explore our recent work across the region.</p>

        <div class="carousel-wrapper">
            <button class="carousel-btn carousel-btn--prev" onclick="scrollGallery(-1)" aria-label="Previous">&#8592;</button>
            <div id="gallery-carousel" class="gallery-carousel">
                <img src="public/images/img1.jpg" alt="Activity 1">
                <img src="public/images/img2.jpg" alt="Activity 2">
                <img src="public/images/img3.jpg" alt="Activity 3">
                <img src="public/images/img4.jpg" alt="Activity 4">
                <img src="public/images/img5.jpg" alt="Activity 5">
                <img src="public/images/img6.jpg" alt="Activity 6">
            </div>
            <button class="carousel-btn carousel-btn--next" onclick="scrollGallery(1)" aria-label="Next">&#8594;</button>
        </div>
    </div>
</section>

<!-- MODAL (opened when gallery image is clicked) -->
<div id="modal" class="modal">
    <button class="modal-close" aria-label="Close">&times;</button>
    <img id="modal-img" alt="Activity photo">
</div>

<!-- ── CONTACT + DONATE ──────────────────────────────────── -->
<section id="contact" class="section section--tinted">
    <div class="container">

        <!-- Contact -->
        <div class="form-wrap">
            <span class="label">Reach out</span>
            <h2>Contact Us</h2>
            <p class="lead">Have a question? We'd love to hear from you.</p>

            <form action="backend/submit_contact.php" method="POST">
                <div class="form-row">
                    <input type="text"  name="name"  placeholder="Your Name"  required>
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <textarea name="message" placeholder="Your message..." rows="4"></textarea>
                <button type="submit" class="btn btn-primary btn-full">Send Message</button>
            </form>
        </div>

        <!-- Donate -->
        <div class="block-sep">
            <span class="label">Support us</span>
            <h2>Support Our Work</h2>
            <p class="lead">Your support helps us empower more youth across Teso.</p>

            <div class="donate-grid">
                <div class="donate-panel">
                    <h3>Online Donation</h3>
                    <p>Contribute securely via PayPal from anywhere in the world.</p>
                    <a href="https://www.paypal.com/donate" target="_blank" class="btn btn-primary">Donate via PayPal</a>
                </div>
                <div class="donate-panel">
                    <h3>Mobile Money</h3>
                    <p>Send support directly via mobile money in Uganda.</p>
                    <p class="money-line"><strong>MTN:</strong> +256 775 375249</p>
                    <p class="money-line"><strong>Airtel:</strong> +256 774 856806</p>
                </div>
            </div>
        </div>

    </div>
</section>

<footer>
    <p>&copy; 2026 TEDA. All rights reserved.</p>
</footer>

<script src="public/js/main.js"></script>
</body>
</html>

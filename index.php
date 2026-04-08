<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEDA - Teso Elites Development Association</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/teda/public/css/style.css?v=99">
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
    <a href="#about">About Us</a>
    <a href="#focus">Focus Areas</a>
    <a href="#resources">Resources</a>
    <a href="#get">Get Involved</a>
    <a href="#clubs">Contact</a>
    <a href="#donate">Donate</a>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">Youth-Led · Community-Driven</span>
        <h1>Empowering Teso Youth for a Sustainable Future</h1>
        <p class="hero-sub">
            TEDA is a youth-led movement transforming communities through
            education, innovation, culture, and leadership.
        </p>
        <div class="hero-buttons">
            <a href="#get" class="btn btn-primary">Join Us</a>
            <a href="#donate" class="btn btn-ghost">Donate</a>
        </div>
    </div>
</section>

<!-- ABOUT US -->
<section id="about" class="section">
    <div class="container">
        <span class="label">Who we are</span>
        <h2>About Us</h2>
        <p class="lead">
            Teso Elites Development Association (TEDA) is one of the largest youth-led
            organizations operating in the Teso and Bukeddi sub-regions of Uganda.
        </p>

        <div class="split-grid">
            <div class="info-block">
                <h3>Vision</h3>
                <p>An empowered generation of Teso youth driving education, culture, and sustainable development.</p>
            </div>
            <div class="info-block">
                <h3>Mission</h3>
                <p>Empower youth and promote education, culture, and identity among the youth of Teso as a foundation for sustainable development.</p>
            </div>
        </div>

        <p class="sub-heading">Core Values</p>
        <ul class="pill-list">
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
    </div>
</section>

<!-- FOCUS AREAS -->
<section id="focus" class="section section--tinted">
    <div class="container">
        <span class="label">What we do</span>
        <h2>Focus Areas</h2>
        <p class="lead">Our programs address the most pressing needs of Teso youth across seven key pillars.</p>

        <div class="cards-grid">
            <div class="card">
                <img src="public/images/img6.jpg" alt="Education">
                <div class="card-body">
                    <h3>Education</h3>
                    <p>TEDA champions education as a cornerstone for personal growth and community development.</p>
                </div>
            </div>
            <div class="card">
                <img src="public/images/img4.jpg" alt="Climate Action">
                <div class="card-body">
                    <h3>Climate Action</h3>
                    <p>Addressing the urgency of climate adaptation among young people in the Teso region.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Health</h3>
                    <p>TEDA prioritizes health promotion and disease prevention as a foundation for youth wellbeing.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Skilling &amp; Innovation</h3>
                    <p>Promoting skilling and innovation as powerful tools for economic empowerment.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Teso Youth Forum</h3>
                    <select>
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                        <option>2027</option>
                        <option>2028</option>
                    </select>
                    <p>An annual gathering that brings together young people from across the Teso region.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Entrepreneurship</h3>
                    <p>TEDA promotes entrepreneurship as a sustainable pathway to economic empowerment.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Culture &amp; Identity</h3>
                    <p>Preservation and promotion of Teso cultural values, traditions, and identity.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RESOURCES -->
<section id="resources" class="section">
    <div class="container">
        <span class="label">Library</span>
        <h2>Resources</h2>
        <ul class="resource-list">
            <li>Publications</li>
            <li>News</li>
            <li>Blogs</li>
            <li>Events and Activities</li>
        </ul>
    </div>
</section>

<!-- GET INVOLVED -->
<section id="get" class="section section--tinted">
    <div class="container container--narrow">
        <span class="label">Take action</span>
        <h2>Get Involved</h2>
        <p class="lead">Become a member and join hundreds of youth across Teso driving real change.</p>
        <form action="backend/submit_membership.php" method="POST" class="form-panel">
            <div class="form-row">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <textarea name="message" placeholder="Why do you want to join TEDA?" rows="4"></textarea>
            <button type="submit" class="btn btn-primary btn-full">Join TEDA</button>
        </form>
    </div>
</section>

<!-- GALLERY -->
<section id="gallery" class="section">
    <div class="container">
        <span class="label">In the field</span>
        <h2>Our Activities</h2>
        <p class="lead">Scroll right to see our recent activities and community engagements across Teso region.</p>

        <div class="gallery" id="gallery-carousel">
            <div class="gallery-item" onclick="openModal(this.querySelector('img').src)">
                <img src="public/images/img1.jpg" alt="Activity 1">
            </div>
            <div class="gallery-item" onclick="openModal(this.querySelector('img').src)">
                <img src="public/images/img2.jpg" alt="Activity 2">
            </div>
            <div class="gallery-item" onclick="openModal(this.querySelector('img').src)">
                <img src="public/images/img3.jpg" alt="Activity 3">
            </div>
            <div class="gallery-item" onclick="openModal(this.querySelector('img').src)">
                <img src="public/images/img4.jpg" alt="Activity 4">
            </div>
            <div class="gallery-item" onclick="openModal(this.querySelector('img').src)">
                <img src="public/images/img5.jpg" alt="Activity 5">
            </div>
            <div class="gallery-item" onclick="openModal(this.querySelector('img').src)">
                <img src="public/images/img6.jpg" alt="Activity 6">
            </div>
        </div>

        <div class="gallery-controls">
            <button class="gallery-scroll-btn" onclick="scrollGallery(-1)" title="Scroll left">←</button>
            <button class="gallery-scroll-btn" onclick="scrollGallery(1)" title="Scroll right">→</button>
        </div>
    </div>
</section>

<!-- MODAL -->
<div id="modal" class="modal">
    <button class="modal-close" onclick="closeModal()" aria-label="Close">&times;</button>
    <img id="modal-img" alt="Gallery image">
</div>

<!-- CONTACT -->
<section id="clubs" class="section section--tinted">
    <div class="container container--narrow">
        <span class="label">Reach out</span>
        <h2>Contact Us</h2>
        <p class="lead">Have a question or want to learn more? Send us a message.</p>
        <form action="backend/submit_contact.php" method="POST" class="form-panel">
            <div class="form-row">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
            </div>
            <textarea name="message" placeholder="Your message..." rows="4"></textarea>
            <button type="submit" class="btn btn-primary btn-full">Send Message</button>
        </form>
    </div>
</section>

<!-- DONATE -->
<section id="donate" class="section">
    <div class="container">
        <span class="label">Support us</span>
        <h2>Support Our Work</h2>
        <p class="lead">Your contribution helps empower youth across Teso.</p>

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
</section>

<!-- SOCIAL -->
<section class="section section--tinted">
    <div class="container">
        <span class="label">Stay connected</span>
        <h2>Friends &amp; Ambassadors</h2>
        <div class="social">
            <a href="https://www.linkedin.com/company/teso-elite-development-association-teda/">LinkedIn</a>
            <a href="https://x.com/tedayouthteso">X (Twitter)</a>
            <a href="https://whatsapp.com/channel/0029Vb5jNbhAO7RDvUoENq1T">WhatsApp</a>
            <a href="https://www.tiktok.com/@tedayouthteso">TikTok</a>
            <a href="https://www.facebook.com/profile.php?id=61580124693716">Facebook</a>
        </div>
    </div>
</section>

<footer>
    <div class="footer-inner">
        <div>
            <p class="footer-brand">TEDA</p>
            <p class="footer-tagline">Teso Elites Development Association — empowering youth across Uganda.</p>
        </div>
        <ul class="footer-links">
            <li><a href="#about">About</a></li>
            <li><a href="#focus">Focus Areas</a></li>
            <li><a href="#get">Join</a></li>
            <li><a href="#donate">Donate</a></li>
        </ul>
    </div>
    <p class="footer-bottom">&copy; 2026 TEDA. All rights reserved.</p>
</footer>

<script src="public/js/main.js"></script>

<!-- Toast Notification System -->
<script>
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    // Auto-remove after 4 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Add slideOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        to { transform: translateX(450px); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>

<!-- Form Handlers -->
<script>
// Handle Get Involved (Membership) Form
const membershipForm = document.querySelector('[action="backend/submit_membership.php"]');
if (membershipForm) {
    membershipForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(membershipForm);

        try {
            const response = await fetch('backend/submit_membership.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showToast('✓ Application submitted! Redirecting to WhatsApp...', 'success');

                // Open WhatsApp in new tab
                setTimeout(() => {
                    window.open(data.whatsappLink, '_blank');

                    // Redirect after a moment
                    setTimeout(() => {
                        membershipForm.reset();
                        window.location.href = '#about';
                    }, 1000);
                }, 300);
            } else {
                showToast('✗ ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('✗ Error submitting form. Please try again.', 'error');
        }
    });
}

// Handle Contact Form
const contactForm = document.querySelector('[action="backend/submit_contact.php"]');
if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(contactForm);

        try {
            const response = await fetch('backend/submit_contact.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showToast('✓ ' + data.message, 'success');
                contactForm.reset();
            } else {
                showToast('✗ ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('✗ Error sending message. Please try again.', 'error');
        }
    });
}
</script>

</body>
</html>

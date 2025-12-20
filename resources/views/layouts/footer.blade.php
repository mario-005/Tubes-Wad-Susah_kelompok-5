<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3 class="footer-title">Telkom Foodies</h3>
            <p class="footer-description">Discover and enjoy the best culinary options around Telkom University campus.</p>
        </div>
        <div class="footer-section">
            <h4 class="footer-subtitle">Contact</h4>
            <ul class="footer-contact">
                <li><i class="fas fa-map-marker-alt"></i> Telkom University, Bandung</li>
                <li><i class="fas fa-phone"></i> +62 22 7564108</li>
                <li><i class="fas fa-envelope"></i> telufood@telkomuniversity.ac.id</li>
            </ul>
        </div>
        <div class="footer-section">
            <h4 class="footer-subtitle">Follow Us</h4>
            <div class="social-links">
                <a href="#\https://www.facebook.com/telkomuniversity" class="social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com/TelUniversity" class="social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/telkomuniversity" class="social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://id.linkedin.com/school/telkom-university/" class="social-link" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Telkom Foodies. All rights reserved.</p>
    </div>
</footer>

<style>
.footer {
    background-color: #1f2937;
    color: #f3f4f6;
    padding: 4rem 0 1rem;
    margin-top: 4rem;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.footer-section {
    padding: 0 1rem;
}

.footer-title {
    color: #e42313;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.footer-description {
    color: #9ca3af;
    line-height: 1.6;
}

.footer-subtitle {
    color: #f3f4f6;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: #9ca3af;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #e42313;
}

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    color: #9ca3af;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-link {
    color: #9ca3af;
    text-decoration: none;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.social-link:hover {
    color: #e42313;
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    margin-top: 2rem;
    border-top: 1px solid #374151;
}

.footer-bottom p {
    color: #9ca3af;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
    }

    .footer-section {
        text-align: center;
    }

    .footer-contact li {
        justify-content: center;
    }

    .social-links {
        justify-content: center;
    }
}
</style> 
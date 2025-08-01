<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<section id="kontak" class="py-4 bg-white">
    <div class="container">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-3">Kontak kami</h4>
                <p class="text-muted mb-4">Silahkan hubungi kami melalui informasi berikut :</p>
                
                <!-- Contact List -->
                <div class="contact-list">
                    <?php if (isset($kontak) && $kontak): ?>
                        <!-- WhatsApp/Telepon dari Database -->
                        <?php if (!empty($kontak['no_wa'])): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="bi bi-telephone fs-5 "></i>
                            </div>
                            <div>
                                <span class="fw-semibold">Telepon</span>
                                <span class="text-muted ms-2">: <?= esc($kontak['no_wa']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($kontak['email'])): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="bi bi-envelope-fill fs-5 text-danger"></i>
                            </div>
                            <div>
                                <span class="fw-semibold">Email</span>
                                <span class="text-muted ms-2">: <?= esc($kontak['email']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($kontak['alamat'])): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="bi bi-geo-alt-fill fs-5 text-primary"></i>
                            </div>
                            <div>
                                <span class="fw-semibold">Alamat</span>
                                <span class="text-muted ms-2">: <?= esc($kontak['alamat']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="d-flex align-items-center mb-3">
                        <div class="contact-icon me-3">
                            <i class="bi bi-facebook fs-5 text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-semibold">Facebook</span>
                            <span class="text-muted ms-2">: kelompokwanitani</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="contact-icon me-3">
                            <i class="bi bi-instagram fs-5" style="color: #E4405F;"></i>
                        </div>
                        <div>
                            <span class="fw-semibold">Instagram</span>
                            <span class="text-muted ms-2">: @kelompokwanitani_</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!4v1754051488645!6m8!1m7!1snwnIA13WOzncDuB-wG96Rw!2m2!1d-2.593198011196051!2d120.4498579884243!3f289.1313948551698!4f-27.37457435391233!5f0.4000000000000002" 
                        width="100%" 
                        height="250" 
                        style="border:1px solid #ddd; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-item {
    padding: 8px;
    border-radius: 6px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.contact-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.contact-icon {
    width: 30px;
    text-align: center;
    transition: all 0.3s ease;
}

.contact-item:hover .contact-icon i {
    transform: scale(1.1);
}

.map-container {
    transition: all 0.3s ease;
}

.map-container iframe {
    transition: all 0.3s ease;
}

.map-container:hover iframe {
    border-color: #28a745;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}

@media (max-width: 768px) {
    .col-md-6:first-child {
        margin-bottom: 2rem;
    }
    
    .map-container iframe {
        height: 200px;
    }
    
    .contact-item:hover {
        transform: none;
    }
}
</style>
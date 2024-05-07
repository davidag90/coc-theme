jQuery(function ($) {
    let homeItem = `<li class="menu-item menu-item-home nav-item">
                        <a href="${envParams.SITE_URL}" class="btn btn-light">
                            <i class="bi bi-house-fill"></i><span class="d-none">Inicio</span>
                        </a>
                    </li>`;
    
    $('#bootscore-navbar').prepend(homeItem);
}); // jQuery End
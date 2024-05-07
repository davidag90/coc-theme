jQuery(function ($) {
    let homeItem = `<li class="menu-item menu-item-home nav-item">
                        <a href="${envParams.SITE_URL}" class="nav-link">
                            <i class="fa-solid fa-house-chimney fa-2x"></i> <span class="d-none">Inicio</span>
                        </a>
                    </li>`;
    
    $('#bootscore-navbar').prepend(homeItem);
}); // jQuery End
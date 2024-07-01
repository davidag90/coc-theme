jQuery(function ($) {
    $(document).ready(function() {
        let homeItem = `<li class="menu-item menu-item-home nav-item">
                            <a href="${envParams.SITE_URL}" class="nav-link"><i class="fa-solid fa-house-chimney"></i> Inicio</a>
                        </li>`;
        
        $('#bootscore-navbar').prepend(homeItem);
    });
});
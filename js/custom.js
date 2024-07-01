jQuery(function($) {
    $(document).ready(function() {
        let homeIcon = `<i class="fa-solid fa-house-chimney"></i>`;
        
        $('.link-home > .nav-link').prepend(homeIcon);
    });
});
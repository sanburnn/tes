function isEmailValid(email) {
    const regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return regex.test(email);
}

$('#show_password').click(function() {
    var password = $('#password');
    var icon = $(this).find('i');

    if (password.attr('type') === 'password') {
        password.attr('type', 'text');
        icon.removeClass('fa-eye-slash');
        icon.addClass('fa-eye');
    } else {
        password.attr('type', 'password');
        icon.removeClass('fa-eye');
        icon.addClass('fa-eye-slash');
    }
});

$(document).on('click', '.submit', function(e) {
    const emailInput = $("input[name='email']");
    const passwordInput = $("input[name='password']");
    
    if(emailInput.val() === '' || passwordInput.val() === '') {
        return;
    }
    
    if(!isEmailValid(emailInput.val())) {
        return;
    }
    
    $.ajax({
        beforeSend: function(request) {
            $.blockUI({
                css: {
                backgroundColor: 'transparent',
                border: 'none'
                },
                message: '<img src="../assets/image/rolling.svg">',
                baseZ: 1500,
                overlayCSS: {
                backgroundColor: '#7C7C7C',
                opacity: 0.4,
                cursor: 'wait'
                }
            });
        }
    });
});
gsap.fromTo(
    ".loading-page",
    { opacity: 1 },
    {
        opacity: 0,
        display: "none",
        duration: 1.5,
        delay: 3.5,
    }
);

gsap.fromTo(
    ".logo-name",
    {
        y: 50,
        opacity: 0,
    },
    {
        y: 0,
        opacity: 1,
        duration: 1,
        delay: 0.5,
    });
    const element = document.querySelector('.loading-page');
    const svg = document.querySelector('#svg');
    const title = document.querySelector('.name-container');
    if (sessionStorage.getItem('MIFTAHUL_HUDA') !== 'true') {
        console.log('dfgfdg');
        sessionStorage.setItem('MIFTAHUL_HUDA', true);
    } else {
        element.style.visibility = 'hidden';
        svg.style.visibility = 'hidden';
        title.style.visibility = 'hidden';
    }
    
    setTimeout(function() {
        element.style.visibility = 'hidden';
        svg.style.visibility = 'hidden';
        title.style.visibility = 'hidden';
        sessionStorage.removeItem('MIFTAHUL_HUDA');
    }, 8 * 60 * 60 * 1000);
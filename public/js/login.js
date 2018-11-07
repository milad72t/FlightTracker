var loginForm = $("#loginForm");
loginForm.submit(function (e) {
    e.preventDefault();
    var formData = loginForm.serialize();
    $('#loading-image').show();
    document.getElementById('errorForm').style.display = "none";
    $.ajax({
        url: '/login',
        type: 'POST',
        data: formData,
        dataType: "json",
        success: function (data) {
            if (data.login_status == 1) {
                window.location = "/dashboard";
            }
            else {
                document.getElementById('errorForm').style.display = "";
                $("#errorForm").html(data.message);
            }
        },
        error: function (data) {
            console.log("error");
            console.log(data);
            swal({
                title: 'خطا در سیستم',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
            $('#loading-image').hide();
        }
    });
});

particlesJS("particles-js", {
    "particles": {
        "number": {
            "value": 280,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#ffffff"
        },
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {
                "nb_sides": 5
            },
            "image": {
                "src": "img/github.svg",
                "width": 100,
                "height": 100
            }
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
                "enable": false,
                "speed": 0.5,
                "opacity_min": 0.3,
                "sync": false
            }
        },
        "size": {
            "value": 3,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 20,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 3,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,
                "mode": "grab"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 140,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
            },
            "repulse": {
                "distance": 200,
                "duration": 0.4
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
});

var count_particles, update;
count_particles = document.querySelector('.js-count-particles');
update = function () {

    requestAnimationFrame(update);
};
requestAnimationFrame(update);

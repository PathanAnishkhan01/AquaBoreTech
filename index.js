function login(){
    window.open("/Sign_in.html");
}
function loginmain(){
    window.open("/Sign_up.html");
}


function description(){
    window.open("/productdetail.html");
}

const sliderWrapper = document.querySelector('.slider-wrapper');

sliderWrapper.addEventListener('mouseover', () => {
  sliderWrapper.style.animationPlayState = 'paused'; // Pause animation on hover
});

sliderWrapper.addEventListener('mouseout', () => {
  sliderWrapper.style.animationPlayState = 'running'; // Resume animation when not hovering
});



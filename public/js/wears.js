document.querySelectorAll('.img-container').forEach((elem) => {
    let img = elem.querySelector('img');
    let xTransform = img.getAttribute('data-scroll');

    gsap
    .to(img, {
        x: xTransform,
        ease: "none",
        scrollTrigger:{
            trigger: img,
            start: "top 80px",
            end: "bottom top",
            scrub: 2,
            pin: true,
            pinSpacer:false
        }
    });
})
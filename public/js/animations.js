// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

// Hero section animation
gsap.from(".hero-content", {
    duration: 1,
    y: 100,
    opacity: 0,
    ease: "power3.out"
});

// Partners section animation
gsap.from(".partner-card", {
    scrollTrigger: {
        trigger: ".partners-section",
        start: "top center",
        toggleActions: "play none none reverse"
    },
    duration: 0.8,
    y: 50,
    opacity: 0,
    stagger: 0.2,
    ease: "power2.out"
});

// Discover sections animations
gsap.utils.toArray('.scroll-section').forEach((section, i) => {
    const isEven = i % 2 === 0;
    const firstCol = section.querySelector('.col-md-6:first-child');
    const lastCol = section.querySelector('.col-md-6:last-child');
    
    // Animate the content div instead of the column
    gsap.from(firstCol.querySelector('div'), {
        scrollTrigger: {
            trigger: section,
            start: "top center",
            toggleActions: "play none none reverse"
        },
        duration: 1,
        x: isEven ? -100 : 100,
        opacity: 0,
        ease: "power3.out"
    });

    gsap.from(lastCol.querySelector('div'), {
        scrollTrigger: {
            trigger: section,
            start: "top center",
            toggleActions: "play none none reverse"
        },
        duration: 1,
        x: isEven ? 100 : -100,
        opacity: 0,
        ease: "power3.out"
    });
});

// Membership cards animation
gsap.from(".pricing-card", {
    scrollTrigger: {
        trigger: "#membership",
        start: "top center",
        toggleActions: "play none none reverse"
    },
    duration: 0.8,
    y: 50,
    opacity: 0,
    stagger: 0.2,
    ease: "power2.out"
});

// FAQ section animation
// gsap.from(".accordion-item", {
//     scrollTrigger: {
//         trigger: "#faqAccordion",
//         start: "top center",
//         toggleActions: "play none none reverse"
//     },
//     duration: 0.6,
//     y: 30,
//     opacity: 0,
//     stagger: 0.1,
//     ease: "power2.out"
// });

// Footer animation
gsap.from("footer .col", {
    scrollTrigger: {
        trigger: "footer",
        start: "top bottom",
        toggleActions: "play none none reverse"
    },
    duration: 0.8,
    y: 50,
    opacity: 0,
    stagger: 0.2,
    ease: "power2.out"
}); 
document.addEventListener("DOMContentLoaded", function () {
  // 1. ROLE TYPEWRITER (Same timing as jigarsable.netlify.app)
  const roleElements = document.querySelectorAll(".typing-role");
  const roles = [
    "Full-stack Web Developer",
    "Game Developer",
    "Frontend Developer",
    "Backend Developer",
    "Software Engineer"
  ];

  roleElements.forEach(function (el) {
    let roleIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    
    // Create cursor if not present
    let cursor = el.parentNode.querySelector(".typed-cursor-role");
    if (!cursor) {
      cursor = document.createElement("span");
      cursor.className = "typed-cursor typed-cursor-role";
      cursor.textContent = "|";
      el.parentNode.insertBefore(cursor, el.nextSibling);
    }

    function typeRole() {
      const currentRole = roles[roleIndex];

      if (isDeleting) {
        charIndex--;
        el.textContent = currentRole.substring(0, charIndex);
      } else {
        charIndex++;
        el.textContent = currentRole.substring(0, charIndex);
      }

      let speed = isDeleting ? 25 : 50;

      if (!isDeleting && charIndex === currentRole.length) {
        speed = 1000;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        roleIndex = (roleIndex + 1) % roles.length;
        speed = 500;
      }

      setTimeout(typeRole, speed);
    }

    typeRole();
  });


  // 2. NAME TYPEWRITER WITH 3 FONT ROTATIONS
  // Font 0: Original Poppins ('Poppins', sans-serif)
  // Font 1: https://res.my.id/ Redefining font ('Space Grotesk', sans-serif)
  // Font 2: Webpage Serif font ('Playfair Display', Georgia, serif)
  const nameElements = document.querySelectorAll(".typing-name");
  const fontClasses = ["font-style-poppins", "font-style-space", "font-style-serif"];

  nameElements.forEach(function (el) {
    const fullName = el.getAttribute("data-name") || el.textContent.trim() || "Ari Eka Putragani";
    let fontCycleIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    el.classList.add(fontClasses[fontCycleIndex]);

    let cursor = el.parentNode.querySelector(".typed-cursor-name");
    if (!cursor) {
      cursor = document.createElement("span");
      cursor.className = "typed-cursor typed-cursor-name";
      cursor.textContent = "|";
      el.parentNode.insertBefore(cursor, el.nextSibling);
    }

    function typeName() {
      if (isDeleting) {
        charIndex--;
        el.textContent = fullName.substring(0, charIndex);
      } else {
        charIndex++;
        el.textContent = fullName.substring(0, charIndex);
      }

      let speed = isDeleting ? 25 : 50;

      if (!isDeleting && charIndex === fullName.length) {
        speed = 1200;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        // Rotate font family
        el.classList.remove(fontClasses[fontCycleIndex]);
        fontCycleIndex = (fontCycleIndex + 1) % fontClasses.length;
        el.classList.add(fontClasses[fontCycleIndex]);
        speed = 400;
      }

      setTimeout(typeName, speed);
    }

    el.textContent = "";
    typeName();
  });
});

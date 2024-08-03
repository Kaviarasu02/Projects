// dashboard content

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function openNav2() {
  document.getElementById("mySidenav2").style.width = "250px";
}

function closeNav2() {
  document.getElementById("mySidenav2").style.width = "0";
}



// Profile card star rating 
document.addEventListener('DOMContentLoaded', () => {
  const stars = document.querySelectorAll('.star');

  stars.forEach(star => {
    star.addEventListener('click', setRating);
    star.addEventListener('mouseover', addHover);
    star.addEventListener('mouseout', removeHover);

    // Load saved rating from localStorage
    const profileId = star.closest('.profile-card').getAttribute('data-profile-id');
    const savedRating = localStorage.getItem(`rating-${profileId}`);
    if (savedRating) {
      updateStars(star.parentElement, savedRating);
    }
  });

  function setRating(e) {
    const value = parseInt(e.target.getAttribute('data-value'));
    const parent = e.target.parentNode;
    const profileId = parent.closest('.profile-card').getAttribute('data-profile-id');

    updateStars(parent, value);
    localStorage.setItem(`rating-${profileId}`, value);
  }

  function updateStars(parent, value) {
    const allStars = parent.querySelectorAll('.star');
    allStars.forEach((star, index) => {
      if (index < value) {
        star.innerHTML = '&#9733;';
      } else {
        star.innerHTML = '&#9734;';
      }
    });
  }

  function addHover(e) {
    const value = parseInt(e.target.getAttribute('data-value'));
    const parent = e.target.parentNode;
    const allStars = parent.querySelectorAll('.star');

    allStars.forEach((star, index) => {
      if (index < value) {
        star.innerHTML = '&#9733;';
      } else {
        star.innerHTML = '&#9734;';
      }
    });
  }

  function removeHover(e) {
    const parent = e.target.parentNode;
    const profileId = parent.closest('.profile-card').getAttribute('data-profile-id');
    const savedRating = localStorage.getItem(`rating-${profileId}`);

    if (savedRating) {
      updateStars(parent, savedRating);
    } else {
      parent.querySelectorAll('.star').forEach(star => {
        star.innerHTML = '&#9734;';
      });
    }
  }
});



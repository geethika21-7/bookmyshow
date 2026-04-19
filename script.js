const API_KEY = "ce81aa5bcea3d255c5232fb1bd784bec";

let selectedMovie = "";

function loadMovies() {
  fetch(`https://api.themoviedb.org/3/movie/now_playing?api_key=${API_KEY}`)
    .then(res => res.json())
    .then(data => {
      let container = document.getElementById("movies");

      data.results.forEach(movie => {
        let card = document.createElement("div");
        card.className = "movie-card";

        card.innerHTML = `
          <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}">
          <p>${movie.title}</p>
        `;

        card.onclick = () => {
          selectedMovie = movie.title;
          localStorage.setItem("movie", movie.title);

          // Highlight selection
          document.querySelectorAll(".movie-card").forEach(c => c.style.border = "none");
          card.style.border = "3px solid red";
        };

        container.appendChild(card);
      });
    });
}

window.onload = loadMovies;

function goSeats() {
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;

  if (!name || !email || !selectedMovie) {
    alert("Fill all details!");
    return;
  }

  localStorage.setItem("name", name);
  localStorage.setItem("email", email);

  window.location = "seats.html";
}
function goPayment() {
  let seats = localStorage.getItem("seats");

  if (!seats || seats.length === 0) {
    alert("Please select at least one seat!");
    return;
  }

  window.location.href = "payment.html";
}
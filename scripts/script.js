function ifPosterNotFoundOverview(source) {
  source.src = "../../assets/img/not-found.png";
  source.onerror = "";
  source.style.height = "300px";
  return true;
}

function ifPosterNotFound(source) {
  source.src = "../../assets/img/not-found.png";
  source.onerror = "";
  return true;
}

function ifLogoNotFound(source) {
  source.src = "../../assets/img/TM-logo.png";
  source.onerror = "";
  return true;
}

function test(source) {
  source.src = "../assets/img/seat-selected.svg";
}

function test2(source) {
  source.src = "../assets/img/seat-available.svg";
}

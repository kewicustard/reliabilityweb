let navElems = document.querySelectorAll('nav');
let hrElems = document.querySelectorAll('hr');
let mainMenuOfficialElem = document.querySelector('#offcial_indices');
let mainMenuUnoffcialElem = document.querySelector('#unoffcial_indices');
navElems[2].classList.add('d-none')
mainMenuOfficialElem.addEventListener("click", () => {
    navElems[2].classList.toggle('d-none')
    // hrElems[0].classList.toggle('d-none')
});
mainMenuUnoffcialElem.addEventListener("click", () => {
    navElems[1].classList.toggle('d-none')
    hrElems[0].classList.toggle('d-none')
});
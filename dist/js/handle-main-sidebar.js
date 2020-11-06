let navElems = $('nav');
// let hrElems = $('hr');
let mainMenuOfficialElem = document.querySelector('#offcial_indices');
let mainMenuUnoffcialElem = document.querySelector('#unoffcial_indices');

    if (Storage !== 'undefined') {
        if (sessionStorage.hideOfficalMenu !== 'undefined') {
            if (sessionStorage.hideOfficalMenu === '1') {
                navElems.eq(2).slideUp(300);
            } else {
                navElems.eq(2).slideDown(300);
            }
            if (sessionStorage.hideUnofficalMenu === '1') {
                navElems.eq(1).slideUp(300);
            } else {
                navElems.eq(1).slideDown(300);
            }
        }
    }    

mainMenuOfficialElem.addEventListener("click", () => {
    navElems.eq(2).slideToggle(300);
    sessionStorage.hideOfficalMenu = (sessionStorage.hideOfficalMenu === '1') ? '0' : '1';
    // hrElems[0].classList.toggle('d-none')
});
mainMenuUnoffcialElem.addEventListener("click", () => {
    navElems.eq(1).slideToggle(300);
    sessionStorage.hideUnofficalMenu = (sessionStorage.hideUnofficalMenu === '1') ? '0' : '1';
    // hrElems.eq(0).slideToggle('fast');
});
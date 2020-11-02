function displayHilightMenu(linkMenu) {
    const linkMenuText = "#"+linkMenu;
    // const navItemElems = Array.from(document.querySelectorAll('.nav-item'));
    // console.log(navItemElems);
    // navItemElems.map(navItemElem => console.log(navItemElem.innerText.trim()));
    // const navItemSeletectedElem = navItemElems.filter(navItemElem => navItemElem.innerText.includes(linkMenuText));
    // console.log(navItemSeletectedElem);
    // const navLinkSelectedElem = navItemSeletectedElem[navItemSeletectedElem.length - 1].children[0];
    const navItemSelectedElem = document.querySelector(linkMenuText);
    const navLinkSelectedElem = navItemSelectedElem.children[0];
    navLinkSelectedElem.classList.add('active');
    // console.log(navLinkSelectedElem);
    // console.log(navLinkSelectedElem.classList);
    const hasTreeviewLink = navItemSelectedElem.parentElement.previousElementSibling;
    // console.log(hasTreeviewLink);
    if (hasTreeviewLink) {
        hasTreeviewLink.classList.add('active');
        // console.log(hasTreeviewLink.classList);
        const menuOpen = hasTreeviewLink.parentElement;
        // console.log(menuOpen);
        menuOpen.classList.add('menu-open');
        // console.log(menuOpen.classList);
        const hasTreeviewLinkOuter = menuOpen.parentElement.previousElementSibling;
        if (hasTreeviewLinkOuter) {
            hasTreeviewLinkOuter.classList.add('active');
            const menuOpenOuter = hasTreeviewLinkOuter.parentElement;
            menuOpenOuter.classList.add('menu-open');
        }
    }
}
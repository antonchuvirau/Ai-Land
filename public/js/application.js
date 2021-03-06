
'use strict';

const heroElement = document.querySelector(`.hero`);
const heroLayerElement = document.querySelector(`.hero__layer`);
const headerElement = document.querySelector(`.header`);
const anchorLinks = document.querySelectorAll(`a[href*="#"]`);
const openMenuButton = document.querySelector(`.header__mobile-button`);
const headerNavigationElement = document.querySelector(`.header__navigation`);
const navigationLinksCollection = document.querySelectorAll(`.navigation__list-link`);
const friction = 1 / 15;
let lFollowX = 0;
let lFollowY = 0;
let x = 0, y = 0;

function moveBackground() {
  x += (lFollowX - x) * friction;
  y += (lFollowY - y) * friction;
  
  const translate = 'translate(' + x + 'px, ' + y + 'px) scale(1.1)';
  heroLayerElement.style.transform = `${translate}`;

  window.requestAnimationFrame(moveBackground);
}

function onHeroElementEventHandler(evt) {
    const lMouseX = Math.max(-100, Math.min(100, window.innerWidth / 2 - evt.clientX));
    const lMouseY = Math.max(-100, Math.min(100, window.innerHeight / 2 - evt.clientY));
    lFollowX = (20 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
    lFollowY = (10 * lMouseY) / 100;
}

function onWindowScrollHandler() {
    if (window.pageYOffset > 1) {
        headerElement.classList.add(`header_is-scrolled`);
    }
    else {
        headerElement.classList.remove(`header_is-scrolled`);
    }
}

function anchorLinkOnClickHandler(evt) {
    evt.preventDefault();
    const href = this.getAttribute(`href`);
    const offsetTop = document.querySelector(href).offsetTop;
    
    window.scroll({
        top: offsetTop,
        behavior: `smooth`
    });
}

function onOpenMenuButtonClickHandler() {
    document.documentElement.classList.toggle(`is-locked`);
    headerNavigationElement.classList.toggle(`header__navigation_opened`);
    openMenuButton.classList.toggle(`header__mobile-button_active`);
}

function onNavigationLinkClickHandler(evt) {
    evt.preventDefault();
    if (document.documentElement.classList.contains(`is-locked`)) {
        document.documentElement.classList.remove(`is-locked`);
        headerNavigationElement.classList.toggle(`header__navigation_opened`);
        openMenuButton.classList.toggle(`header__mobile-button_active`);
    }
    const href = this.getAttribute(`href`);
    const offsetTop = document.querySelector(href).offsetTop;
    
    window.scroll({
        top: offsetTop,
        behavior: `smooth`
    });
}

heroElement.addEventListener(`mousemove`, onHeroElementEventHandler);
window.addEventListener(`scroll`, onWindowScrollHandler);
document.addEventListener(`DOMContentLoaded`, () => {
    moveBackground();
    if (anchorLinks.length) {
        for (const anchorLink of anchorLinks) {
            anchorLink.addEventListener(`click`, anchorLinkOnClickHandler);
        }
    }
    if (openMenuButton) {
        openMenuButton.addEventListener(`click`, onOpenMenuButtonClickHandler);
    }
    if (navigationLinksCollection.length) {
        for (const navigationLink of navigationLinksCollection) {
            navigationLink.addEventListener(`click`, onNavigationLinkClickHandler);
        }
    }
});
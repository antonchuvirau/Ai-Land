'use strict';

const heroElement = document.querySelector(`.hero`);
const heroLayerElement = document.querySelector(`.hero__layer`);
const headerElement = document.querySelector(`.header`);
const friction = 1 / 30;
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

heroElement.addEventListener(`mousemove`, onHeroElementEventHandler);
window.addEventListener(`scroll`, onWindowScrollHandler);
document.addEventListener(`DOMContentLoaded`, () => {
    moveBackground();
});
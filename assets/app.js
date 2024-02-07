/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import "./flashMessage.js";
import $ from 'jquery';



require('bootstrap');

function magnify(imgID, zoom)
{
    let img, glass, w, h, bw;
    img = document.getElementById(imgID);
    glass = document.createElement("DIV");
    glass.setAttribute("class", "img-magnifier-glass");
    img.parentElement.insertBefore(glass, img);
    glass.style.backgroundImage = "url('" + img.src + "')";
    glass.style.backgroundRepeat = "no-repeat";
    glass.style.backgroundSize =
    img.width * zoom + "px " + img.height * zoom + "px";
    bw = 3;
    w = glass.offsetWidth / 2;
    h = glass.offsetHeight / 2;

    // Cache la loupe
    function hideMagnifier()
    {
        glass.style.display = "none";
    }

    // Affiche la loupe
    function showMagnifier()
    {
        glass.style.display = "block";
    }

    // Ajoute l'écouteur pour cacher/afficher la loupe
    img.addEventListener("mouseenter", showMagnifier);
    img.addEventListener("mouseleave", hideMagnifier);
    glass.addEventListener("mouseenter", showMagnifier);
    glass.addEventListener("mouseleave", hideMagnifier);

    glass.addEventListener("mousemove", moveMagnifier);
    img.addEventListener("mousemove", moveMagnifier);
    glass.addEventListener("touchmove", moveMagnifier);
    img.addEventListener("touchmove", moveMagnifier);

    function moveMagnifier(e)
    {
        let pos, x, y;
        pos = getCursorPos(e);
        x = pos.x;
        y = pos.y;
        if (x > img.width - w / zoom) {
            x = img.width - w / zoom;
        }
        if (x < w / zoom) {
            x = w / zoom;
        }
        if (y > img.height - h / zoom) {
            y = img.height - h / zoom;
        }
        if (y < h / zoom) {
            y = h / zoom;
        }
        glass.style.left = x - w + "px";
        glass.style.top = y - h + "px";
        glass.style.backgroundPosition =
        "-" + (x * zoom - w + bw) + "px -" + (y * zoom - h + bw) + "px";
    }

    const getCursorPos = (e) => {
        let a,
            x = 0,
            y = 0;
        e = e || window.event;
        a = img.getBoundingClientRect();
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return { x: x, y: y };
    };
}

magnify("my_image", 2);

document.addEventListener('DOMContentLoaded', function () {
    // Select the .box-area div
    let boxArea = document.querySelector('.box-area');

    // Select the .box-right div
    let boxRight = document.querySelector('.box-right');

    // Add a click event listener to the .box-area div
    boxArea.addEventListener('click', function () {
        // Toggle the display style of the .box-right div
        if (boxRight.style.display !== 'none') {
            boxRight.style.display = 'none';
        } else {
            boxRight.style.display = 'block';
        }
    });
});
$(document).ready(function () {

    // required elements
    let imgPopup = $('.img-popup');
    let imgCont  = $('.box-artwork');
    let popupImage = $('.img-popup img');
    let closeBtn = $('.close-btn');

    // handle events
    imgCont.on('click', function () {
        let img_src = $(this).children('img').attr('src');
        imgPopup.children('img').attr('src', img_src);
        imgPopup.addClass('opened');
    });

    $(imgPopup, closeBtn).on('click', function () {
        imgPopup.removeClass('opened');
        imgPopup.children('img').attr('src', '');
    });

    /* popupImage.on('click', function (e) {
        e.stopPropagation();
    });
*/
});

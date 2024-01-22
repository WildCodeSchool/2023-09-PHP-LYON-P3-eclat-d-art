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
    glass.addEventListener("mousemove", moveMagnifier);
    img.addEventListener("mousemove", moveMagnifier);
    glass.addEventListener("touchmove", moveMagnifier);
    img.addEventListener("touchmove", moveMagnifier);

    function moveMagnifier(e)
    {
        let pos, x, y;
        e.preventDefault();
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
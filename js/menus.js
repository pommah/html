/**
 * Created by vladislav on 15.05.17.
 */
onload = function () {
    userMenu = document.getElementsByClassName('userMenu')[0];
    content = document.getElementsByClassName('content')[0];
}

window.onscroll = function () {
    if(content.getBoundingClientRect().top<=0) {
        userMenu.style.position = "fixed";
        document.getElementsByClassName('content')[0].style.marginLeft = "19.4%";
    }
    else {
        userMenu.style.position = "relative";
        document.getElementsByClassName('content')[0].style.marginLeft = "0%";
    }
}
const profile = document.getElementById("profil");
const popupProfile = document.getElementById('popupProfil');
const profilImg = document.getElementById('profilImg');


if(profile.checked == true){
    popupProfile.classList.add("popupProfile_activate");
    popupProfile.classList.remove("popupProfile_desactivate");
}
else{
    popupProfile.classList.add("popupProfile_desactivate");
    popupProfile.classList.remove("popupProfile_activate");
    //popupProfile.style.display = "flex";
}
profile.addEventListener("change", event => {
    if(profile.checked == true){
        popupProfile.classList.add("popupProfile_activate");
        popupProfile.classList.remove("popupProfile_desactivate");
        popupProfile.style.display = "flex";
    }
    else{
        popupProfile.classList.add("popupProfile_desactivate");
        popupProfile.classList.remove("popupProfile_activate");
        popupProfile.style.display = "none";
    }
});


const nav = document.getElementById("nav");
if (window.innerWidth < 1000) {
    nav.classList.add("phoneNav");
    nav.classList.add("desactivate_nav");
    nav.classList.remove("computerNav");
}
else{
    nav.classList.remove("phoneNav");
    nav.classList.remove("activate_nav");
    nav.classList.remove("desactivate_nav");
    nav.classList.add("computerNav");
}
window.onresize = function () {
    if (window.innerWidth < 1000) {
        nav.classList.add("phoneNav");
        nav.classList.remove("computerNav");
        nav.classList.add("desactivate_nav");
        burger.checked = false;
        burger_label.classList.remove("burger_activate");
        burger_label.classList.add("burger_desactivate");
        nav.classList.remove("activate_nav");
        nav.classList.add("desactivate_nav");
    }
    else{
        nav.classList.remove("phoneNav");
        nav.classList.add("computerNav");
        nav.classList.remove("activate_nav");
        nav.classList.remove("desactivate_nav");
    }
}


const burger = document.getElementById("burger_menu");
const burger_label = document.getElementById("burger_menu_label");
burger.addEventListener("change", function(){
    if(burger.checked == true){
        burger_label.classList.remove("burger_desactivate");
        burger_label.classList.add("burger_activate");
        nav.classList.add("activate_nav");
        nav.classList.remove("desactivate_nav");
    }
    else{
        burger_label.classList.remove("burger_activate");
        burger_label.classList.add("burger_desactivate");
        nav.classList.remove("activate_nav");
        nav.classList.add("desactivate_nav");
    }
});

function SelectedIME(value) {
    window.location.replace("/changeIME.php?IME=" + value);
}
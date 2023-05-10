let elements = document.getElementsByClassName("button_style_1");

addEventListener("mouseleave", function(){
    for(var i = 0; i < elements.length; i++)
    {
        elements.item(i).style.backgroundColor = "white";
        elements.item(i).style.transition = "background-color 0.5s linear";
    }
});
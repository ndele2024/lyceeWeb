const imgElement = document.querySelector('#imageToggleView');
imgElement.addEventListener('click', (e)=>toggleViewPassword(e, "pwd"));

function toggleViewPassword(elm, ps) {
    const inp = document.querySelector("#"+ps);
    if(inp.getAttribute("type")==="password") {
        inp.setAttribute("type", "text");
        elm.target.setAttribute("src", "./ressources/view-6444.png")
    }
    else {
        inp.setAttribute("type", "password");
        elm.target.setAttribute("src", "./ressources/hidden-12115.png")
    }
}
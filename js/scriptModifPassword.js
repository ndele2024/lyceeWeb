const imgElement1 = document.querySelector('#imageToggleView1');
imgElement1.addEventListener('click', (e)=>toggleViewPassword(e, "formerpassword"));

const imgElement2 = document.querySelector('#imageToggleView2');
imgElement2.addEventListener('click', (e)=>toggleViewPassword(e, "newpassword"));

const imgElement3 = document.querySelector('#imageToggleView3');
imgElement3.addEventListener('click', (e)=>toggleViewPassword(e, "newpasswordconfirm"));

function toggleViewPassword(elm, ps) {
    const inp = document.querySelector("#"+ps);
    if(inp.getAttribute("type")==="password") {
        inp.setAttribute("type", "text");
        elm.target.setAttribute("src", "../ressources/view-6444.png")
    }
    else {
        inp.setAttribute("type", "password");
        elm.target.setAttribute("src", "../ressources/hidden-12115.png")
    }
}
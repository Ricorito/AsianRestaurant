
let menus = document.querySelector("nav");
let menuBtn = document.querySelector(".menu-btn");
let closeBTN = document.querySelector(".close-btn");

menuBtn.addEventListener("click",function (){
   menus.classList.add("active");
})

closeBTN.addEventListener("click",function (){
    menus.classList.remove("active");
})


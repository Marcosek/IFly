let gra;
let graWidth = 360;
let graHeight = 640;
let context;

let samolotWidth = 54;
let samolotHeight = 44;
let samolotX = graWidth/8;
let samolotY = graHeight/2;

let samolotImg;

let samolot = {
    x : samolotX,
    y : samolotY,
    width : samolotWidth,
    height : samolotHeight
}

let blokiArray = [];
let blokiWidth = 64;
const blokiHeight = 512;
let blokiX = graWidth;
let blokiY = 0;

let goraBlokImg;
let dolBlokImg;

let predkoscX = -4;
let predkoscY = 0;
let grawitacja = 0.3;

let koniec = true;
let wynik = 0;



window.onload = function() {
    gra = document.getElementById("gra");
    gra.height = graHeight;
    gra.width = graWidth;
    context = gra.getContext("2d");

    samolotImg = new Image();
    samolotImg.src = "samolot.png";
    samolotImg.onload = function() {
    context.drawImage(samolotImg, samolot.x, samolot.y, samolot.width, samolot.height);
    }

    goraBlokImg = new Image();
    goraBlokImg.src = "gora.png";

    dolBlokImg = new Image();
    dolBlokImg.src = "dol.png";

    requestAnimationFrame(update);
    setInterval(postawBloki, 1500);
    document.addEventListener("keydown", ruchSamolotu);
    document.addEventListener("touchstart", function(e) {
        if (e.target.id === "gra") {
            ruchSamolotu(e);
        }
    });
      document.addEventListener("click", function(e) {
        if (e.target.id === "gra") {
            ruchSamolotu(e);
        }
    });
}

let lastTime = 0;
let framesPerSecond = 70;

function update(timestamp) {
    requestAnimationFrame(update);

    if (koniec) {
        return;
    }

    let deltaTime = timestamp - lastTime;

    if (deltaTime < 1000 / framesPerSecond) {
        return;
    }

    lastTime = timestamp;

    context.clearRect(0, 0, gra.width, gra.height);

    predkoscY += grawitacja;
    samolot.y = Math.max(samolot.y + predkoscY, 0);
    context.drawImage(samolotImg, samolot.x, samolot.y, samolot.width, samolot.height);

    if (samolot.y > gra.height) {
        koniec = true;
    }

    for (let i = 0; i < blokiArray.length; i++) {
        let blok = blokiArray[i];
        blok.x += predkoscX;
        context.drawImage(blok.img, blok.x, blok.y, blok.width, blok.height);

        if (!blok.miniete && samolot.x > blok.x + blok.width) {
            wynik += 0.5;
            blok.miniete = true;
        }

        if (uderzenie(samolot, blok)) {
            koniec = true;
        }
    }

    document.getElementById("wynik").value = wynik;

    if (koniec) {
        context.fillStyle = "white";
        context.font = "45px sans-serif";
        context.fillText("GAME OVER", 45, 90);
    }
}

requestAnimationFrame(update);

function postawBloki() {
if (koniec) {
    return;
}

    let randomBlokY = blokiY - blokiHeight/4 - Math.random() *(blokiHeight/2);
    let wolneMiejsce = gra.height/4;
    let goraBlok = {
        img: goraBlokImg,
        x : blokiX,
        y : randomBlokY,
        width : blokiWidth,
        height : blokiHeight,
        miniete : false
    }

    blokiArray.push(goraBlok);

    let dolBlok = {
        img: dolBlokImg,
        x : blokiX,
        y : randomBlokY + blokiHeight + wolneMiejsce,
        width : blokiWidth,
        height : blokiHeight,
        miniete : false
    }
    blokiArray.push(dolBlok);
}

function ruchSamolotu(e) {
   
        predkoscY = -6;

        if (koniec) {
            samolot.y = samolotY;
            blokiArray = [];
            wynik = 0;
            koniec = false;
        
    }
}

function uderzenie(a, b) {
return a.x < b.x + b.width && a.x + a.width > b.x && a.y < b.y + b.height && a.y + a.height > b.y;
}

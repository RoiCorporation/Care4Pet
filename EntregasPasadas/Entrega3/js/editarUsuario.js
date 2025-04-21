window.onload = function () {
    const cuidadorSi = document.getElementById("CuidadorSi");
    const cuidadorNo = document.getElementById("CuidadorNo");
    const esDueno = document.getElementById("esDueno");

    if (cuidadorSi && cuidadorNo && esDueno) {
        cuidadorSi.addEventListener("click", function () {
            esDueno.value = "0";
        });

        cuidadorNo.addEventListener("click", function () {
            esDueno.value = "1";
        });
    }
};

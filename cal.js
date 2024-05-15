var calcController = (function () {
    var munkavallaloiAdoKalk = function (brutto) {
      var SZJA = Math.floor(brutto * 0.15);
      var nyugdijJarulek = Math.floor(brutto * 0.1);
      var egeszsegBiztositasiJarulek = Math.floor(brutto * 0.07);
      var munkaeroPiaciJarulek = Math.floor(brutto * 0.015);
      var osszesAdo =
        SZJA + nyugdijJarulek + egeszsegBiztositasiJarulek + munkaeroPiaciJarulek;
      return {
        SZJA: SZJA,
        nyugdijJarulek: nyugdijJarulek,
        egeszsegBiztositasiJarulek: egeszsegBiztositasiJarulek,
        munkaeroPiaciJarulek: munkaeroPiaciJarulek,
        osszesAdo: osszesAdo
      };
    };
    var munkaltatoiAdoKalk = function (brutto) {
      var szocHo = Math.floor(brutto * 0.195);
      var szakkepHozz = Math.floor(brutto * 0.015);
      var munkaadoOsszHaviKoltseg = szocHo + szakkepHozz;
      return {
        szocHo: szocHo,
        szakkepHozz: szakkepHozz,
        munkaadoOsszHaviKoltseg: munkaadoOsszHaviKoltseg
      };
    };
    var gyerekSzamKalk = function (
      tizennyolcAlattiGyerek,
      egyetemistaGyerek,
      tartosanBetegGyerek
    ) 
	{
      var gy =
        tizennyolcAlattiGyerek != 0 || tizennyolcAlattiGyerek != ""
          ? parseInt(tizennyolcAlattiGyerek)
          : 0;
      var e =
        egyetemistaGyerek != 0 || egyetemistaGyerek != ""
          ? parseInt(egyetemistaGyerek)
          : 0;
      var tb =
        tartosanBetegGyerek != 0 || tartosanBetegGyerek != ""
          ? parseInt(tartosanBetegGyerek)
          : 0;
      var gyerekszam = gy + e + tb;
  
      return {
        gy: gy,
        e: e,
        tb: tb,
        gyerekszam: gyerekszam
      };
    };
  
    var potlekKalk = function (egyedul, gyerekSzam) {
      var e = gyerekSzam.e;
      var tb = gyerekSzam.tb;
      var gyerekszam = gyerekSzam.gyerekszam;
      var tbOsszeg = egyedul === false ? 23300 : 25900;
      var megfeleloPotlekSzorzo = 0;
      var potlek = 0;
      if (gyerekszam === 1 && egyedul === false) {
        megfeleloPotlekSzorzo = 12200;
      } else if (gyerekszam === 1 && egyedul === true) {
        megfeleloPotlekSzorzo = 13700;
      } else if (gyerekszam === 2 && egyedul === false) {
        megfeleloPotlekSzorzo = 13300;
      } else if (gyerekszam === 2 && egyedul === true) {
        megfeleloPotlekSzorzo = 14800;
      } else if (gyerekszam > 2 && egyedul === false) {
        megfeleloPotlekSzorzo = 16000;
      } else if (gyerekszam > 2 && egyedul === true) {
        megfeleloPotlekSzorzo = 17000;
      }
      potlek = gyerekszam * megfeleloPotlekSzorzo;
      if (e > 0) {
        potlek -= e * megfeleloPotlekSzorzo;
      }
      if (tb > 0) {
        potlek -= tb * megfeleloPotlekSzorzo;
        potlek += tbOsszeg;
      }
  
      return potlek;
    };
    var csaladiAdokedvezmenyKalk = function (gyerekSzam) {
      var gyerekszam = gyerekSzam.gyerekszam;
      var e = gyerekSzam.e;
      var csaladiAdoKedvezmenySzorzo = 0;
      var csaladiAdoKedvezmeny = 0;
      if (gyerekszam !== 0) {
        if (gyerekszam === 1) {
          csaladiAdoKedvezmenySzorzo = 10000;
        } else if (gyerekszam === 2) {
          csaladiAdoKedvezmenySzorzo = 17500;
        } else if (gyerekszam > 2) {
          csaladiAdoKedvezmenySzorzo = 33000;
        }
      } else {
        csaladiAdoKedvezmenySzorzo = 0;
      }
      csaladiAdoKedvezmeny = gyerekszam * csaladiAdoKedvezmenySzorzo;
      if (e > 0) {
        csaladiAdoKedvezmeny -= e * csaladiAdoKedvezmenySzorzo;
      }
      return csaladiAdoKedvezmeny;
    };
  
    var frissHazasKalk = function (kedv) {
      var frissHazasAdoKedvezmeny = 0;
      var frisshazas = kedv;
      if (frisshazas) {
        frissHazasAdoKedvezmeny += 5000;
      }
      return frissHazasAdoKedvezmeny;
    };
  
    var szemelyiAdokedvezmenyKalk = function (kedv) {
      var SZJAAdokedvezmeny = 0;
      var szemelyiadokedvezmeny = kedv;
      if (szemelyiadokedvezmeny) {
        SZJAAdokedvezmeny += 6990;
      }
      return SZJAAdokedvezmeny;
    };
  
    var osszesAdoKedvezmenyKalk = function (
      csaladiAdokedvezmeny,
      frissHazas,
      szemelyiAdokedvezmeny
    ) {
      var osszesadokedvezmeny = 0;
      osszesadokedvezmeny =
        csaladiAdokedvezmeny + frissHazas + szemelyiAdokedvezmeny;
      return osszesadokedvezmeny;
    };
  
    return {
      dataCalc: function (getInput) {
        var input;
        var munkavallaloiAdo;
        var munkaltatoiAdo;
        var gyerekSzam;
        var potlek;
        var csaladiAdokedvezmeny;
        var frissHazas;
        var szemelyiAdokedvezmeny;
        var osszesAdoKedvezmeny;
        input = getInput();
        munkavallaloiAdo = munkavallaloiAdoKalk(input.brutto);
        munkaltatoiAdo = munkaltatoiAdoKalk(input.brutto);
        gyerekSzam = gyerekSzamKalk(
          input.tizennyolcAlattiGyerek,
          input.egyetemistaGyerek,
          input.tartosanBetegGyerek
        );
        potlek = potlekKalk(input.egyedul, gyerekSzam);
        csaladiAdokedvezmeny = csaladiAdokedvezmenyKalk(gyerekSzam);
        frissHazas = frissHazasKalk(input.frissHazas);
        szemelyiAdokedvezmeny = szemelyiAdokedvezmenyKalk(
          input.szemelyiAdokedvezmeny
        );
        osszesAdoKedvezmeny = osszesAdoKedvezmenyKalk(
          csaladiAdokedvezmeny,
          frissHazas,
          szemelyiAdokedvezmeny
        );
  
        return {
          munkavallaloiAdo: munkavallaloiAdo,
          munkaltatoiAdo: munkaltatoiAdo,
          gyerekSzam: gyerekSzam,
          potlek: potlek,
          csaladiAdokedvezmeny: csaladiAdokedvezmeny,
          frissHazas: frissHazas,
          szemelyiAdokedvezmeny: szemelyiAdokedvezmeny,
          osszesAdoKedvezmeny: osszesAdoKedvezmeny
        };
      },
      testing: function () {}
    };
  })();
  var UIController = (function () {
    var domItems = {
  
      btnToTop: document.getElementById("myBtn"),
      bruttoBer: document.getElementById("bruttoBer-input"),
      tizennyolcAlattiGyerek: document.getElementById("18AlattiGyerek-input"),
      egyetemistaGyerek: document.getElementById("egyetemistaGyerek-input"),
      tartosanBetegGyerek: document.getElementById("tartosanBetegGyerek-input"),
      egyedul: document.getElementById("egyedul-input"),
      frissHazas: document.getElementById("frissHazas-input"),
      szemelyiAdokedvezmeny: document.getElementById(
        "szemelyiAdokedvezmeny-input"
      ),
      szamol: document.getElementById("kuldes"),
      errorSzoveg: document.getElementById("errorSzoveg"),
      loadingGif: document.getElementById("loading"),
      tabla: document.getElementById("tabla"),
      bruttoTabla: document.getElementById("brutto-tabla"),
      bruttoEvesTabla: document.getElementById("bruttoEves-tabla"),
      eltartottakTabla: document.getElementById("eltartottak-tabla"),
      kedvEltartottakTabla: document.getElementById("kedvEltartottak-tabla"),
      szjaAdoTabla: document.getElementById("szjaAdo-tabla"),
      munkaeroPiaciJarulekTabla: document.getElementById(
        "munkaeroPiaciJarulek-tabla"
      ),
      egszBiztJarTabla: document.getElementById("egszbiztJar-tabla"),
      nyugdijJarulekTabla: document.getElementById("nyugdijJarulek-tabla"),
      osszesAdoTabla: document.getElementById("osszesAdo-tabla"),
      szocHoTabla: document.getElementById("szocHo-tabla"),
      szakHozzTabla: document.getElementById("szakHozz-tabla"),
      munkaltatoOsszTabla: document.getElementById("munkaltatoOssz-tabla"),
      csaladiAdokedvTabla: document.getElementById("csaladiAdokedv-tabla"),
      frissHazasAdokedvTabla: document.getElementById("frissHazasAdokedv-tabla"),
      fogyatekosAdokedvTabla: document.getElementById("fogyatekosAdokedv-tabla"),
      felhasznaltAdokedvTabla: document.getElementById(
        "felhasznaltAdokedv-tabla"
      ),
      felhasznalatlanAdokedvTabla: document.getElementById(
        "felhasznalatlanAdokedv-tabla"
      ),
      maradtAdoTabla: document.getElementById("maradtAdo-tabla"),
      nettoBerTabla: document.getElementById("nettoBer-tabla"),
      csaladiPotlekTabla: document.getElementById("csaladiPotlek-tabla"),
      nettoOsszTabla: document.getElementById("nettoOssz-tabla")
    };
    var inputGreen = function () {
      var formCtrl = document.querySelectorAll(".form-control");
      for (var i = 0; i < formCtrl.length - 1; i++) {
        formCtrl[i].classList.add("greenBorder");
      }
    };
    var loadingGif = function () {
      domItems.loadingGif.style.display = "block";
      setTimeout(function () {
        domItems.loadingGif.style.display = "none";
      }, 2000);
    };
    var tablaShow = function () {
      setTimeout(function () {
        domItems.tabla.style.display = "block";
      }, 2100);
    };
    var tablaFill = function (calcRes) {
      domItems.bruttoTabla.innerHTML = parseInt(domItems.bruttoBer.value) + " Ft";
      domItems.bruttoEvesTabla.innerHTML =
        parseInt(domItems.bruttoBer.value) * 12 + " Ft";
      domItems.kedvEltartottakTabla.innerHTML =
      domItems.szjaAdoTabla.innerHTML = calcRes.munkavallaloiAdo.SZJA + " Ft";
      domItems.munkaeroPiaciJarulekTabla.innerHTML =
        calcRes.munkavallaloiAdo.munkaeroPiaciJarulek + " Ft";
      domItems.egszBiztJarTabla.innerHTML =
        calcRes.munkavallaloiAdo.egeszsegBiztositasiJarulek + " Ft";
      domItems.nyugdijJarulekTabla.innerHTML =
        calcRes.munkavallaloiAdo.nyugdijJarulek + " Ft";
      domItems.osszesAdoTabla.innerHTML =
        calcRes.munkavallaloiAdo.osszesAdo + " Ft";
      domItems.szocHoTabla.innerHTML = calcRes.munkaltatoiAdo.szocHo + " Ft";
      domItems.szakHozzTabla.innerHTML =
        calcRes.munkaltatoiAdo.szakkepHozz + " Ft";
      domItems.munkaltatoOsszTabla.innerHTML =
        calcRes.munkaltatoiAdo.munkaadoOsszHaviKoltseg + " Ft";
      domItems.csaladiAdokedvTabla.innerHTML =
        calcRes.csaladiAdokedvezmeny + " Ft";
      domItems.frissHazasAdokedvTabla.innerHTML = calcRes.frissHazas + " Ft";
      domItems.fogyatekosAdokedvTabla.innerHTML =
        calcRes.szemelyiAdokedvezmeny + " Ft";
      if (
        domItems.szemelyiAdokedvezmeny.checked ||
        domItems.frissHazas.checked ||
        calcRes.gyerekSzam.gyerekszam - calcRes.gyerekSzam.e > 0
      ) {
        if (
          calcRes.munkavallaloiAdo.osszesAdo -
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek -
            calcRes.osszesAdoKedvezmeny >
          0
        ) {
          domItems.felhasznaltAdokedvTabla.innerHTML =
            calcRes.osszesAdoKedvezmeny + " Ft";
        } else {
          domItems.felhasznaltAdokedvTabla.innerHTML =
            calcRes.munkavallaloiAdo.osszesAdo -
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek +
            " Ft";
        }
      } else {
        domItems.felhasznaltAdokedvTabla.innerHTML = 0 + " Ft";
      }
  
      // Felhaszn�latlan ad�kedvezm�ny
      if (
        calcRes.munkavallaloiAdo.osszesAdo -
          calcRes.munkavallaloiAdo.munkaeroPiaciJarulek -
          calcRes.osszesAdoKedvezmeny <
        0
      ) {
        domItems.felhasznalatlanAdokedvTabla.innerHTML =
          calcRes.osszesAdoKedvezmeny -
          (calcRes.munkavallaloiAdo.osszesAdo -
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek) +
          " Ft";
      } else {
        domItems.felhasznalatlanAdokedvTabla.innerHTML = 0 + " Ft";
      }
      if (
        domItems.szemelyiAdokedvezmeny.checked ||
        domItems.frissHazas.checked ||
        calcRes.gyerekSzam.gyerekszam - calcRes.gyerekSzam.e > 0
      ) {
        if (
          calcRes.munkavallaloiAdo.osszesAdo -
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek -
            calcRes.osszesAdoKedvezmeny >
          0
        ) {
          domItems.maradtAdoTabla.innerHTML =
            calcRes.munkavallaloiAdo.osszesAdo -
            calcRes.osszesAdoKedvezmeny +
            " Ft";
        } else {
          domItems.maradtAdoTabla.innerHTML =
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek + " Ft";
        }
      } else {
        domItems.maradtAdoTabla.innerHTML = 0 + " Ft";
      }
      if (
        domItems.szemelyiAdokedvezmeny.checked ||
        domItems.frissHazas.checked ||
        calcRes.gyerekSzam.gyerekszam - calcRes.gyerekSzam.e > 0
      ) {
        if (
          calcRes.munkavallaloiAdo.osszesAdo -
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek -
            calcRes.osszesAdoKedvezmeny >
          0
        ) {
          domItems.nettoBerTabla.innerHTML =
            parseInt(domItems.bruttoBer.value) -
            (calcRes.munkavallaloiAdo.osszesAdo - calcRes.osszesAdoKedvezmeny) +
            " Ft";
        } else {
          domItems.nettoBerTabla.innerHTML =
            parseInt(domItems.bruttoBer.value) -
            calcRes.munkavallaloiAdo.munkaeroPiaciJarulek +
            " Ft";
        }
      } else {
        domItems.nettoBerTabla.innerHTML =
          parseInt(domItems.bruttoBer.value) -
          (calcRes.munkavallaloiAdo.osszesAdo +
            calcRes.csaladiAdokedvezmeny +
            calcRes.frissHazas +
            calcRes.szemelyiAdokedvezmeny) +
          " Ft";
      }
      domItems.csaladiPotlekTabla.innerHTML = 0 + " Ft";
      if (calcRes.potlek !== 0) {
        domItems.csaladiPotlekTabla.innerHTML = calcRes.potlek + " Ft";
      } else {
        domItems.csaladiPotlekTabla.innerHTML = 0 + " Ft";
      }
      var nettober = domItems.nettoBerTabla.innerHTML;
      var nettohozPotlek = domItems.csaladiPotlekTabla.innerHTML;
      var nettoOssz;
  
      nettober = nettober.split(" ");
      nettober = parseInt(nettober[0]);
  
      nettohozPotlek = nettohozPotlek.split(" ");
      nettohozPotlek = parseInt(nettohozPotlek[0]);
  
      domItems.nettoOsszTabla.innerHTML = nettober + nettohozPotlek + " Ft";
    };
  
    var inputEventListeners = function () {
      var form = document.getElementById("form1");
      form.addEventListener("input", resetDefault);
    };
  
    var resetDefault = function () {
      domItems.tabla.style.display = "none";ű
      var formCtrl = document.querySelectorAll(".form-control");
      setTimeout(function () {
        for (var i = 0; i < formCtrl.length - 1; i++) {
          formCtrl[i].classList.remove("greenBorder");
        }
      }, 500);
    };
    return {
      getInput: function () {
        return {
          brutto: domItems.bruttoBer.value,
          tizennyolcAlattiGyerek: domItems.tizennyolcAlattiGyerek.value,
          egyetemistaGyerek: domItems.egyetemistaGyerek.value,
          tartosanBetegGyerek: domItems.tartosanBetegGyerek.value,
          egyedul: domItems.egyedul.checked,
          frissHazas: domItems.frissHazas.checked,
          szemelyiAdokedvezmeny: domItems.szemelyiAdokedvezmeny.checked
        };
      },
      getDOMstrings: function () {
        return domItems;
      },
      scrollFunction: function () {
        if (document.documentElement.scrollTop > 20) {
          domItems.btnToTop.style.display = "block";
        } else {
          domItems.btnToTop.style.display = "none";
        }
      },
  
      topFunction: function () {
        document.documentElement.scrollTop = 0;
      },
  
      UIRefresh: function (calcResult) {
        inputGreen();
        loadingGif();
        tablaFill(calcResult);
        tablaShow();
        inputEventListeners();

      }
    };
  })();
  
  var appController = (function (calcCtrl, UICtrl) {
    var runEvent = function (DOM) {
      if (DOM.bruttoBer.value !== "") {
        if (DOM.errorSzoveg.style.display === "block") {
          DOM.errorSzoveg.style.display = "none";
        }
        if (DOM.bruttoBer.classList.contains("inputError")) {
          DOM.bruttoBer.classList.remove("inputError");
        }
        var calcResult = calcCtrl.dataCalc(UICtrl.getInput);
        UICtrl.UIRefresh(calcResult);
      } else {
        DOM.bruttoBer.classList.add("inputError");
        DOM.errorSzoveg.style.display = "block";
      }
    };
  
    var esemenyKezeloTelepitese = function () {
      var DOM = UICtrl.getDOMstrings();
      DOM.szamol.addEventListener("click", function (e) {
        runEvent(DOM);
        e.preventDefault();
      });
      document.addEventListener("keypress", function (event) {
        if (event.keyCode === 13 || event.which === 13) {
          runEvent(DOM);
          event.preventDefault();
        }
      });
      window.onscroll = function () {
        UICtrl.scrollFunction();
      };
    };
  
    return {
      init: function () {
        esemenyKezeloTelepitese();
      }
    };
  })(calcController, UIController);
  appController.init();
  
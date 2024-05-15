<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="q.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
      <script src="https://code.jquery.com/jquery-latest.js"></script>
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->

    <!-- end loader -->
    <div id="mySidepanel" class="sidepanel">
        
        
    </div>
    <!-- header -->
    <header id="navbar">
        <!-- header inner -->
        
    </header>

<body>
                <div class="widget-wrap">
                    <h1 class="text-center">Pénzügyi kvíz</h1>
                     <div id="quizWrap"></div>
                </div>

    </div>

    <script>
        var quiz = {
    data: [
        {
            q: "Mi a legfőbb előnye a passzív megtakarításnak?",
            o: ["Nagyobb hozamok a befektetésekből", "Nagyobb kockázat a pénz elvesztése miatt", "Az automatikus pénzügyi rendszerek által nyújtott kényelem", "Nincs semmilyen előnye"],
            a: 2
        },
        {
            q: "Melyik az alábbi lehetőségek közül a leginkább kockázatos befektetési forma?",
            o: ["Befektetési alapok", "Készpénz és banki megtakarítások", "Készletek és részvények", "Vonzó kamatozású megtakarítási számlák"],
            a: 2
        },
        {
            q: "Miért előnyös a hosszú távú megtakarítás?",
            o: ["Nagyobb kockázat a pénz elvesztése miatt", "Alacsonyabb hozamok a befektetésekből", "Az automatikus pénzügyi rendszerek által nyújtott kényelem", "Lehetőség a hosszú távú pénzügyi célok elérésére"],
            a: 3
        },
        {
            q: "Mi a 'compound interest' (összetett kamat) fogalma?",
            o: ["Egy banki termék", "Egy olyan kamat, amelyet soha nem kell visszafizetni", "A kamatos kamat elve, amely lehetővé teszi a kamatösszegek újbóli kamatozását", "A fix kamatlábú megtakarítási számlák"],
            a: 2
        },
        {
            q: "Melyik az alábbi megtakarítási forma, amelyet leginkább a rövid távú pénzügyi célok elérésére használnak, például egy autóvásárlásra vagy utazásra?",
            o: ["Hosszú távú megtakarítások", "Befektetési alapok", "Vésztartalék számla", "Készpénz és banki megtakarítások"],
            a: 2
        },
        {
            q: "Melyik az alábbi megtakarítási forma, amelyet leginkább a nyugdíj előkészítésére használnak?",
            o: ["Vonzó kamatozású megtakarítási számlák", "Részvénybefektetések", "Készpénz és banki megtakarítások", "Hosszú távú megtakarítások"],
            a: 3
        },
        {
            q: "Melyik az alábbi megtakarítási forma, amely leginkább a váratlan kiadásokra készül?",
            o: ["Részvénybefektetések", "Készletek és részvények", "Vésztartalék számla", "Hosszú távú megtakarítások"],
            a: 2
        },
        {
            q: "Mi a legfontosabb dolog, amelyre a megtakarítási tervben figyelmet kell fordítani?",
            o: ["Azonnali hozamok elérése", "A megtakarítások rugalmassága", "Az automatikus pénzügyi rendszerek által nyújtott kényelem", "A megtakarítási célok és határidők meghatározása"],
            a: 3
        },
        {
            q: "Mi a legfontosabb előnye a külön megtakarítási számláknak?",
            o: ["Magasabb hozamokat kínálnak", "Ingyenes banki szolgáltatásokat biztosítanak", "A célra történő pénzügyi tervezés lehetősége", "Nincs semmilyen előnyük"],
            a: 2
        },
        {
            q: "Melyik a következő közül a legjobb példa passzív jövedelemforrásra?",
            o: ["Vonzó kamatozású megtakarítási számlák", "Hozamok a részvénybefektetésekből", "Befektetési alapok", "Készpénz és banki megtakarítások"],
            a: 1
        },
        {
            q: "Mi az egyik legfontosabb tényező, amikor az emberek hosszú távú megtakarítási célokat határoznak meg?",
            o: ["A kamatok alacsony szintje", "Az adókedvezmények mértéke", "Az elérhető befektetési lehetőségek diverzifikálása", "A jelenlegi kockázatvállalási képesség"],
            a: 3
        },
        {
            q: "Miért fontos rendszeresen ellenőrizni és frissíteni a megtakarítási tervet?",
            o: ["A megtakarítási célok és a pénzügyi helyzet változása miatt", "Az állami támogatások növelése érdekében", "A banki díjak elkerülése érdekében", "Nincs szükség a terv rendszeres frissítésére"],
            a: 0
        },
        {
            q: "Mi a legnagyobb kockázata a magas hozamú befektetéseknek?",
            o: ["Nincs kockázat", "A befektetés elvesztése", "Alacsonyabb hozamok", "Rövid távú hozamok"],
            a: 1
        },
        {
            q: "Mi a legjobb módja annak, hogy minimalizáljuk a kockázatot a befektetéseinkben?",
            o: ["Összetett kamatok használata", "Teljes tőkemozgás azonnali visszavonása", "A portfólió diverzifikálása", "Nem kell csökkenteni a kockázatot"],
            a: 2
        },
        {
            q: "Melyik a következő közül a legjobb példa hosszú távú megtakarításra?",
            o: ["Vonzó kamatozású megtakarítási számlák", "Részvénybefektetések", "Vésztartalék számla", "Nyugdíj-megtakarítási számla"],
            a: 3
        },
        {
            q: "Mi a 'dollar cost averaging' (DCA) stratégia?",
            o: ["A megtakarított pénz befektetése egyetlen nagyobb ügyletben", "Az azonos összegű részletekben történő rendszeres vásárlás", "A kockázat növelése a spekulatív befektetésekkel", "Azonnali visszavonás a teljes tőkéből"],
            a: 1
        },
        {
            q: "Miért fontos a pénzügyi célkitűzések meghatározása a megtakarítási tervben?",
            o: ["Csak azért, hogy ne legyen céltalan pénzügyi tervezés", "A hosszú távú megtakarítási célok meghatározása érdekében", "A cél eléréséhez szükséges megtakarítási összeg meghatározása", "Az automatikus pénzügyi rendszerek beállításának megkönnyítése érdekében"],
            a: 2
        },
        {
            q: "Mi a 'sunk cost fallacy' (eltüntetett költség tévedés)?",
            o: ["A befektető saját tőkéjének elvesztése", "Az elvesztett pénz visszaszerzésére irányuló téves meggyőződés", "A korábbi pénzügyi hibák ismétlődése", "A tőke elvesztése a rossz befektetések miatt"],
            a: 1
        },
        {
            q: "Mi a legjobb módja annak, hogy felkészüljünk a váratlan pénzügyi költségekre?",
            o: ["Azonnali költségvetési megszorítások bevezetése", "A pénzügyi biztonsági háló kiépítése az elkövetkező nehéz időkre", "A megtakarítások felhasználása váratlan költségekre", "A váratlan költségekre való reakcióképesség elvesztése"],
            a: 1
        }
    ],


        
    hWrap: null, // HTML kvíz konténer
            hQn: null, // HTML kérdés konténer
            hAns: null, // HTML válaszok konténer

            now: 0, // jelenlegi kérdés
            score: 0, // jelenlegi pontszám

            init: () => {
                quiz.hWrap = document.getElementById("quizWrap");

                quiz.hQn = document.createElement("div");
                quiz.hQn.id = "quizQn";
                quiz.hWrap.appendChild(quiz.hQn);

                quiz.hAns = document.createElement("div");
                quiz.hAns.id = "quizAns";
                quiz.hWrap.appendChild(quiz.hAns);

                quiz.draw();
            },

            draw: () => {
                quiz.hQn.innerHTML = quiz.data[quiz.now].q;

                quiz.hAns.innerHTML = "";
                for (let i in quiz.data[quiz.now].o) {
                    let radio = document.createElement("input");
                    radio.type = "radio";
                    radio.name = "quiz";
                    radio.id = "quizo" + i;
                    quiz.hAns.appendChild(radio);
                    let label = document.createElement("label");
                    label.innerHTML = quiz.data[quiz.now].o[i];
                    label.setAttribute("for", "quizo" + i);
                    label.dataset.idx = i;
                    label.addEventListener("click", () => { quiz.select(label); });
                    quiz.hAns.appendChild(label);
                }
            },

            select: (option) => {
                let all = quiz.hAns.getElementsByTagName("label");
                for (let label of all) {
                    label.removeEventListener("click", quiz.select);
                }

                let correct = option.dataset.idx == quiz.data[quiz.now].a;
                if (correct) {
                    quiz.score++;
                    option.classList.add("correct");
                } else {
                    option.classList.add("wrong");
                }

                quiz.now++;
                setTimeout(() => {
                    if (quiz.now < quiz.data.length) {
                        quiz.draw();
                    } else {
                        quiz.hQn.innerHTML = `A  ${quiz.data.length} válaszból  ${quiz.score} helyes.`;
                        quiz.hAns.innerHTML = "";
                    }
                }, 1000);
            },

            reset: () => {
                quiz.now = 0;
                quiz.score = 0;
                quiz.draw();
            }
        };

        window.addEventListener("load", quiz.init);
    </script>
<footer>
        <?php include("footer.php") ?>
    </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js "></script>
      <script src="js/bootstrap.bundle.min.js "></script>
      <script src="js/jquery-3.0.0.min.js "></script>
      <script src="js/custom.js "></script>
   </body>
</html>
<script>
    $('#navbar').load('nav.php');
    $('#mySidepanel').load('sidenav.php');
    document.getElementsByTagName('html')[0].addEventListener("click", closeNav);
</script>
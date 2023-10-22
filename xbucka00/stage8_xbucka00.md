## xbucka00 - Testovanie makety

Testovanie bolo vykonané na 2 subjektoch - obchodný manažér a zubný technik, ktorí majú záujem o používanie aplikácie. Každý subjekt mal za úlohu vyplniť dotazník v aplikácii Maze. Každá otázka pozostávala z vykonania určitej úlohy v aplikácii a následne zodpovedania otázky: "Čo by bolo vhodné zlepšiť?".

## Metriky testovania

Za metriky testovania makety boli použité nasledovné metriky:

-   Úspešnosť splnenia úlohy na priamo (bez prechádzania na iné stránky)
-   Percentuálny podiel chýbných stlačení

## Testovacie scenáre

### 1. Scenár - Pridaj potravinu do svojho príjmu.

-   Úspešnosť splnenia úlohy na priamo: 100%
-   Percentuálny podiel chýbných stlačení: 20%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"

    -   Pridanie nutričných hodnôt pri pridávaní jedla

-   **Analýza výsledku**: Pridanie presmerovania na sekciu kalendár pri kliknutí na údaje o dennom príjme, kde bude možné vidieť prijaté jedlá a zapísať si ďalšie. Pri zadávaní jedla bude vhodné zobraziť nutričné hodnoty jedla.

### 2. Scenár - Pridaj vlasnté jedlo do svojho príjmu.

-   Úspešnosť splnenia úlohy na priamo: 50%
-   Percentuálny podiel chýbných stlačení: 0%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"

    -   Mätúci popup pre pridanie vlastného jedla. Nemá názov.
    -   Pri zapisovaní sa stratí údaj o tom, čo sa zapisuje.

-   **Analýza výsledku**: Neslpnenie úlohy bolo spôsobené popupom bez názvu. Pri pridávaní vlastného jedla bude vhodné zobraziť popuo aj s nadpisom. Nad input by bolo vhodné pridať názov menenej informácie.

### 3. Scenár - Zisti informácie o navrhovanom jedle a pridaj ho do svojho príjmu.

-   Úspešnosť splnenia úlohy na priamo: 50%
-   Percentuálny podiel chýbných stlačení: 0%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"

    -   Lepšie označiť navrhované jedlá.

-   **Analýza výsledku**: Bude vhodné zmeniť text nad navrhovanými jedlami z dôvodu lepšej orientácie.

### 4. Scenár - Pridaj recept do svojho príjmu.

-   Úspešnosť splnenia úlohy na priamo: 100%
-   Percentuálny podiel chýbných stlačení: 0%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"
    - *bez odpovede*

- **Analýza výsledku**: Úloha bola splnená bez problémov.

### 5. Scenár - Pridaj nápoj do svojho príjmu.

-  Úspešnosť splnenia úlohy na priamo: 100%
-  Percentuálny podiel chýbných stlačení: 14.3%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"
    - *bez odpovede*

- **Analýza výsledku**: Podobne ako v scenári 1, bude vhodné pridať presmerovanie na kalendár pri kliknutí na údaje o dennom pitnom režime (chýbné stlačenie vzniklo práve pri kliku na tento údaj).

### 6. Scenár - Zapíš aktivitu do svojho denníka.

-   Úspešnosť splnenia úlohy na priamo: 100%
-   Percentuálny podiel chýbných stlačení: 33%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"
    - *bez odpovede*

- **Analýza výsledku**: Rovnako ako v scenári 1 a 5, sa subjekty pokúšali pristúpiť k zápisu skrz kliknutie na denné údaje (o aktivite). Riešením by bolo presmerovanie na kalendár, kde si užívateľ bude môcť zaznamenať aktivitu a prezerať si záznamy.

### 7. Scenár - Pridaj vlastnú aktivitu do svojho denníka.

-   Úspešnosť splnenia úlohy na priamo: 50%
-   Percentuálny podiel chýbných stlačení: 33%
-   Nadväzujúca otázka: "Čo by bolo vhodné zlepšiť?"
    - *bez odpovede*

- **Analýza výsledku**: Testovaný subjekt namiesto tlačítka *Custom* prešiel na vyhľadávanie aktivít. Riešením by mohlo byť zmenenie textu tlačítka na *Add custom* alebo *Add custom activity* poprípade pridanie nadpisu pre popup.
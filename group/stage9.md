# Technické riešenie a implementácia

Ako cieľovú platformu sme si zvolili webovú apikáciu. Implementácia sa riadila vzorom MVC (Model View Controller). Pre Back end bol použitý framework Laravel a pre Front end bol použitý framework Vue.js. Vybrali sme si tieto frameworky, pretože sú vhodné pre naše potreby a sú rozšírené v rámci webových aplikácií.

## Návrhový vzor MVC

### Model
Náš model je reprezentovaný triedami v jazyku PHP. Každý model reprezentuje tabuľku z dátového modelu v MySQL databáze. Všetky modely sú uložené v priečinku `app/Models`. Každý náš model rožširuje základnú funckionalitu abstraktnej triedy `Illuminate\Database\Eloquent\Model`. Táto trieda poskytuje základnú funckionalitu pre prácu s databázou. Základné funkcie, ktoré nám táto trieda poskytuje sú funckie na získavanie a editáciu záznamov z databázy napr. `all()`, `create()`. Je možné volať funkcie na spravovanie vzťahov medzi tabuľkami v databáze napr. `hasMany()`, `belongsTo()`. Taktiež je možné volať funkcie na filtrovanie záznamov napr. `where()`, `orderBy()`.

### View

### Controller
V našeh aplikácii controller obsluhuje užívateľské žiadosti komunikáciou s modelmi. Controller triedy sú uložené v priečinku `app/Http/Controllers`. Každý controller rozširuje funckionalitu triedy `Illuminate\Routing\Controller`.

## Dátový model
Dátový model je reprezentovaný tabuľkami v MySQL databáze. Používané tabuľky:
- `BodyData` - tabuľka reprezentujúca fyzické údaje užívateľa
- `Meal` - reprezentuje jedlo a jeho nutričné hodnoty
- `MealEaten` - obsahuje FK (cudzí kľúč) na tabuľku `Meal` s inforáciou o čase a ďalších údajoch
- `Drink` - tabuľka reprezentujúca nápoje a ich nutričné hodnoty
- `DrinkDrunk` - obsahuje FK (cudzí kľúč) na tabuľku `Drinks` s inforáciou o čase a ďalších údajoch
- `Activity` - reprezentuje fyzičkú aktivitu a jej údaje
- `ActivityDone` - obsahuje FK (cudzí kľúč) na tabuľku `Activity` s inforáciou o dátume a ďalších údajoch
- `Recipe` - tabuľka reprezentujúca recepty s názvom a postupom
- `RecipeEaten` - obsahuje FK (cudzí kľúč) na tabuľku `Recipe` s inforáciou o čase a dátume

Medzi tabuľkami `Meal` a `Recipe` je vzťah m:n, preto je potrebná pomocná tabuľka `MealRecipe`, ktorá obsahuje FK (cudzí kľúč) na tabuľku `Meal` a FK na tabuľku `Recipe`.

## API
V rámci rozhrania api voláme nasledujúce metódy z kontrolérov pri požiadavke od užívateľa (GET, POST, PUT, DELETE):
- `index()` - zobrazenie dát z vyžadovaného zdroja
- `store()` - uloženie novo vytvorených dát zadaných užívateľom
- `show()` - zobrazenie konkrétnych dát z vyžadovaného zdroja
- `update()` - aktualizácia dát zdroja na základe vstupu od užívateľa
- `destroy()` - odstránenie dát zdroja

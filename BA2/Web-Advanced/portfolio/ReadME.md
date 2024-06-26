# Portfolio Web Advanced 

Dit project is een mock integratie van de [Cubepanion API](https://github.com/Fesaa/CubepanionAPI), publiek te vinden op https://ameliah.art/cubepanion.
Vanwege de eenvoud wordt ze niet echt gebruikt.

Volgende zaken moeten aanwezig zijn in het project:
- **Selecting elements**
- **Manipulating elements**
- **Linking an event to an element**
- **Validating forms**
- **Using a constant**
- **Using template literals**
- **Destructuring**
- **Spread & Rest operator**
- **Iterating over an array**
- **Arrow function**
- **Callback function**
- **Promise**
- **Consumer methods**
- **Async & Await**
- **Self-executing function**
- **Fetching data**
- **Manipulating and displaying JSON**
- **Basic CSS Animation**
- **Using flexbox or CSS grid**
- **Using LocalStorage**
- **Theoretical knowledge** (demonstrated through self-tests on Canvas, available online in early March)

# References:
- [Mozilla Docs](https://developer.mozilla.org/en-US/)
- [API Docs](https://fesaa.github.io/CubepanionAPI/)

---------------

# Docs

Start de go server met. 
```go
go run .
```
Deze zal static alles in `./public` server. Navigeer naar http://127.0.0.1:8000, om de website te bekijken.

----------------

# Impl

### Selection Elements & Manipulating
Vanboven te vinden in `leaderboard.js` & `games.js`. Worden doorheen de bestanten gebruikt om data te weergeven.

### Linking an event to an element
`index.js #8`, `games.js #21` 

### Validating forms
`player.js #19` - super simple, only one field

### Using a constant
Doorheen de code, aan de bovenkant. Klinkt nogal triviaal?

### Using template literals
`leaderboard.js #10` - invoegen van de rows

### Destructuring
`leaderboard.js #10` - info uit (json) obj halen

### Spread & Rest operator
Niet echt plek om dit ergens nuttig te gebruiken. Dit zo dan maar :/
```js

function loadLotsOfRowsFromApi() {
    // Implementation left to the reader
}

function sum(...numbers) {
    return numbers.reduce((total, num) => total + num, 0);
}


const rows = loadLotsOfRowsFromApi();
const [header, ...content] = rows;

const total = sum(...content.map(obj => obj.value));
```

### Iteration over een array
`leaderboards.js #40` & `games.js #10`

### Arrow function
`games.js #13` transformeren van de eventFunctie om juiste parameters mee te krijgen

### Callback function
Gebruikt doorheen het project om als event callback door te geven aan de game divs

### Promise
Gebruikt bij fetch, en in de main method

### Consumer methode
Deze worden gebruik in then, en catch I suppose?

### Async & Await
Callback in beide fetch (`games.js #32` & `leaderboard.js #57`) om json uit de request te halen

### Self executing function
`player.js #5`, de functie `createForm` roept zichzelf aan om de error page op te stellen

### Fetch om data op te halen & JSON manipuleren en weergeven
Zie beschrijving project & functions van Async & Await.

### Basis CSS Animatie
De leaderboard fetch heeft een forced loading animatie. `leaderboards.js #55 & #69`. Animatie in `style.css #69`

### Gebruiken van een flexbox of CSS grid
Nou, zowat alles is een flexbox :D

### Gebruik van LocalStorage
Gebruikt om je naam te bewaren, om je een achtergrond kleurtje te geven in leaderboards. `index.js #24` & `leaderboars.js #16`

### Theoretische kennis
Pesterij, kan het nog niet doen


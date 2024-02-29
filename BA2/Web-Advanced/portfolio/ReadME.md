# Portfolio Web Advanced 

Dit project is een mock integratie van de [Cubepanion API](https://github.com/Fesaa/CubepanionAPI), publiek te vinden op https://ameliah.art/cubepanion_api.
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
TODO

### Using a constant
Doorheen de code, aan de bovenkant. Klinkt nogal triviaal?

### Using template literals
`leaderboard.js #10` - invoegen van de rows

### Destructuring
TODO

### Spread & Rest operator
TODO

### Iteration over een array
`leaderboards.js #40` & `games.js #10`

### Arrow function
`games.js #13` transformeren van de eventFunctie om juiste parameters mee te krijgen

### Callback function
Gebruikt doorheen het project om als event callback door te geven aan de game divs

### Promise
TODO / gebruikt bij fetch

### Consumer methods
TODO

### Async & Await
Callback in beide fetch (`games.js #32` & `leaderboard.js #57`) om json uit de request te halen

### Self executing function
TODO

### Fetch om data op te halen & JSON manipuleren en weergeven
Zie beschrijving project & functions van Async & Await.

### Basis CSS Animatie
De leaderboard fetch heeft een forced loading animatie. `leaderboards.js #55 & #69`

### Gebruiken van een flexbox of CSS grid
Nou, zowat alles is een flexbox :D

### Gebruik van LocalStorage
TODO

### Theoretische kennis
Pesterij, kan het nog niet doen


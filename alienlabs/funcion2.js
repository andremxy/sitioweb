const jokeContainer = document.getElementById("joke");
const btn = document.getElementById("btn");
const url = "https://v2.jokeapi.dev/joke/Any?lang=es&type=single";
let getJoke = () => {
    
    fetch(url)
    .then(data => data.json())
    .then(item =>{
        jokeContainer.textContent = `${item.joke}`;
        
    ();

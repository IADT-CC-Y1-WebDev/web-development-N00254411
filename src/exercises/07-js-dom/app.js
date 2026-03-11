console.log("Hello World");

const p = document.createElement('p');
p.innerHTML = 'This is a <strong>paragraph</strong>';
document.body.appendChild(p);

let myButton = document.getElementById("myBtn");

// function addParagraph(){
//     // console.log("Hello");
//     const p = document.createElement('p');
//     p.innerHTML = 'This is a <strong>paragraph</strong>';
//     document.body.appendChild(p);
// };

// myButton.addEventListener('click', addParagraph );


const myBtn = document.getElementById('myButton');
let myInput = document.getElementById('title');


function addParagraph() {
  let p = document.createElement('p');
  p.innerHTML = title.value;
  document.body.appendChild(p);
}
myButton.addEventListener('click', addParagraph);
myInput.addEventListener('keyup', function (e){
    console.log(this.enterKeyHint.key);
    if (e.key === 'Enter'){
        addParagraph;
    }
    console.log(e.key);
});
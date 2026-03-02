console.log("Hello world");

// function timesTwo(inputNumber){
//     return inputNumber * 2;
// }

// const timesTwo = inputNumber =>inputNumber * 2;


//  console.log(timesTwo(1) + 5);


// // setTimeout(???, );






let myName = "Victoria"

myName.length



let user = {
    firstName:"John",
    lastName:"Connolly",
    age: 53,
    hobbies:["Building","Swimming"],
    friends:[
        {
            firstName:"Tim",
            lastName:"Fortune",
            age:48,
        },
        {
            firstName:"James",
            lastName:"Cullen",
            age:60,
        }
    ],
};




console.log(user.friends[1].firstName);


let donuts = ["Chocolate", "Jam", "Custard"];

donuts.forEach((donut, i)=>{
    //console.log((i + 1) + " " + donut);
    console.log(`Option ${i+1}: ${donut}`);
});



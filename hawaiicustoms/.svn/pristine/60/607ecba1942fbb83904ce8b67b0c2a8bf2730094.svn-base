// GasCalc Function

function calc(textstring) {
if (document.getElementById) {
var gallon=document.form1.gallon.value;
var mpg=document.form1.mpg.value;
var milesdriven=document.form1.milesdriven.value;
//var cost=document.form1.cost.value;

var gallonsused = milesdriven/mpg;
var yearlycost1 = gallonsused*gallon;
var mpg2=(mpg*.11)+Number(mpg);
var gallonsused2 = milesdriven/mpg2;
var yearlycost2 = gallonsused2*gallon;

//yearly savings
var savings=yearlycost1-yearlycost2;


//monthly savings
var savings2=savings/12;

if(document.form1.gallon.value==""){
alert("Please enter the amount per gallon") 
return false;}
if(document.form1.mpg.value==""){
alert("Please enter your vehicle's mpg") 
return false;}
if(document.form1.milesdriven.value==""){
alert("Please enter the miles driven per year") 
return false;}

document.getElementById('savings').childNodes[0].nodeValue = "$"+(Math.round(savings*100)/100);
document.getElementById('savings2').childNodes[0].nodeValue = "$"+(Math.round(savings2*100)/100);
return false;


} else { return true;}

}

